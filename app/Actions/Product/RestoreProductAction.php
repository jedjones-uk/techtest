<?php namespace App\Actions\Product;

use App\Events\Product\ProductRestored;
use App\Models\Product;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use RuntimeException;
use Throwable;

class RestoreProductAction {

    use AsAction;

    /**
     * @var DatabaseManager
     */
    private DatabaseManager $db;

    /**
     * RestoreProductAction constructor.
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
        if ($product->deleted_at === null) {
            throw new RuntimeException(__('The product is not deleted, you cannot restore it'));
        }

        return $this->db->transaction(function () use ($product) {
            if ($product->restore()) {
                event(new ProductRestored($product));
                return $product;
            }

            throw new RuntimeException(__('There was a problem restoring this product'));
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
