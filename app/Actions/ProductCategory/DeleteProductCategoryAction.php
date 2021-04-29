<?php namespace App\Actions\ProductCategory;

use App\Events\ProductCategory\ProductCategoryDeleted;
use App\Models\ProductCategory;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use RuntimeException;
use Throwable;

class DeleteProductCategoryAction {

    use AsAction;

    /**
     * @var DatabaseManager
     */
    private DatabaseManager $db;

    /**
     * DeleteProductCategoryAction constructor.
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
        return $this->db->transaction(function () use ($productCategory) {
            if ($productCategory->delete()) {
                event(new ProductCategoryDeleted($productCategory));
                return $productCategory;
            }

            throw new RuntimeException(__('There was a problem deleting this product category'));
        });
    }

    /**
     * @param ProductCategory $productCategory
     * @param ActionRequest   $request
     * @return ProductCategory
     * @throws Throwable
     */
    public function asController(ProductCategory $productCategory): ProductCategory {
        return $this->handle($productCategory);
    }

    /**
     * @return RedirectResponse
     */
    public function htmlResponse(): RedirectResponse {
        return redirect()->route('productCategory.index');
    }

    /**
     * @param ProductCategory $productCategory
     * @return JsonResponse
     */
    public function jsonResponse(ProductCategory $productCategory): JsonResponse {
        return response()->json($productCategory);
    }

}
