<?php namespace App\Actions\ProductCategory;

use App\Events\ProductCategory\ProductCategoryRestored;
use App\Models\ProductCategory;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use RuntimeException;
use Throwable;

class RestoreProductCategoryAction {

    use AsAction;

    /**
     * @var DatabaseManager
     */
    private DatabaseManager $db;

    /**
     * RestoreProductCategoryAction constructor.
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
     * @param ProductCategory $productCategory
     * @return ProductCategory
     * @throws Throwable
     */
    public function handle(ProductCategory $productCategory): ProductCategory {
        if ($productCategory->deleted_at === null) {
            throw new RuntimeException(__('The product category is not deleted, you cannot restore it'));
        }

        return $this->db->transaction(function () use ($productCategory) {
            if ($productCategory->restore()) {
                event(new ProductCategoryRestored($productCategory));
                return $productCategory;
            }

            throw new RuntimeException(__('There was a problem restoring this product category'));
        });
    }

    /**
     * @param ProductCategory $productCategory
     * @return ProductCategory
     * @throws Throwable
     */
    public function asController(ProductCategory $productCategory ): ProductCategory {
        return $this->handle($productCategory);
    }

    /**
     * @return RedirectResponse
     */
    public function htmlResponse(): RedirectResponse {
        return redirect()->route('productCategory.index');
    }

    /**
     * @param ProductCategory $ProductCategory
     * @return JsonResponse
     */
    public function jsonResponse(ProductCategory $ProductCategory): JsonResponse {
        return response()->json($ProductCategory);
    }

}
