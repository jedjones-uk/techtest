<?php namespace App\Actions\Product;

use App\Events\Product\ProductDeleted;
use App\Models\Product;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use RuntimeException;
use Throwable;

class DeleteProductAction {

    use AsAction;

    /**
     * @var DatabaseManager
     */
    private DatabaseManager $db;

    /**
     * DeleteProduct constructor.
     * @param DatabaseManager $databaseManager
     */
    public function __construct(DatabaseManager $databaseManager) {
        $this->db = $databaseManager;
    }

    /**
     * @param ActionRequest $request
     * @return bool
     */
    public function authorize(ActionRequest $request): bool {
        return true;
    }

    /**
     * @param Product $product
     * @return Product
     * @throws Throwable
     */
    public function handle(Product $product): Product {
        return $this->db->transaction(function () use ($product) {
            if ($product->delete()) {
                event(new ProductDeleted($product));
                return $product;
            }

            throw new RuntimeException(__('There was a problem deleting this product'));
        });
    }

    /**
     * @param Product       $product
     * @param ActionRequest $request
     * @return Product
     * @throws Throwable
     */
    public function asController(Product $product, ActionRequest $request): Product {
        return $this->handle($product);
    }

    /**
     * @return RedirectResponse
     */
    public function htmlResponse(): RedirectResponse {
        return redirect()->route('product.index');
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function jsonResponse(Product $product): JsonResponse {
        return response()->json($product);
    }

}
