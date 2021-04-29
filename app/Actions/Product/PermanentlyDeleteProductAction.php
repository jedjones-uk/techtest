<?php namespace App\Actions\Product;

use App\Events\Product\ProductPermanentlyDeleted;
use App\Models\Product;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use RuntimeException;
use Throwable;

class PermanentlyDeleteProductAction {

    use AsAction;

    /**
     * @var DatabaseManager
     */
    private DatabaseManager $db;

    /**
     * PermanentlyDeleteProductAction constructor.
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
            throw new RuntimeException(__('you must first delete the product before you can permanently delete it'));
        }

        return $this->db->transaction(function () use ($product) {
            if ($product->forceDelete()) {
                event(new ProductPermanentlyDeleted($product));
                return $product;
            }

            throw new RuntimeException(__('There was a problem deleting this product permanently'));
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
        return redirect()->route('product.index', ['archived' => 1]);
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function jsonResponse(Product $product): JsonResponse {
        return response()->json($product);
    }

}
