<?php namespace App\Actions\ProductCategory;

use App\Events\ProductCategory\ProductCategoryUpdated;
use App\Models\ProductCategory;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use RuntimeException;
use Throwable;

class UpdateProductCategoryAction {

    use AsAction;

    /**
     * @var DatabaseManager
     */
    private DatabaseManager $db;

    /**
     * UpdateProductCategoryAction constructor.
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
        return true; //Would put permission checks here
    }

    /**
     * @return array
     */
    public function rules(): array {
        return [
            'name' => ['required', 'max:255']
        ];
    }

    /**
     * @param ProductCategory $productCategory
     * @param Collection      $data
     * @return ProductCategory
     * @throws Throwable
     */
    public function handle(ProductCategory $productCategory, Collection $data): ProductCategory {
        return $this->db->transaction(function () use ($productCategory, $data) {
            $updated = $productCategory->update($data->all());
            if ($updated) {
                event(new ProductCategoryUpdated($productCategory));
                return $productCategory;
            }

            throw new RuntimeException(__('There was a problem updating the product category'));
        });
    }


    /**
     * @param ProductCategory $productCategory
     * @param ActionRequest   $request
     * @return ProductCategory
     * @throws Throwable
     */
    public function asController(ProductCategory $productCategory, ActionRequest $request): ProductCategory {
        $data = collect($request->only(['name', 'description']));
        return $this->handle($productCategory, $data);
    }

    /**
     * @return RedirectResponse
     */
    public function htmlResponse(): RedirectResponse {
        return redirect()->route('productCategory.index');
    }

    /**
     * @param $ProductCategory
     * @return JsonResponse
     */
    public function jsonResponse($ProductCategory): JsonResponse {
        return response()->json($ProductCategory);
    }

}
