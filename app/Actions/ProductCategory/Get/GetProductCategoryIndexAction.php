<?php namespace App\Actions\ProductCategory\Get;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class GetProductCategoryIndexAction {

    use AsAction;

    /**
     * @param ActionRequest $request
     * @return bool
     */
    public function authorize(ActionRequest $request): bool {
        return true; //Would put permission checks here
    }

    /**
     * @param bool $withTrashed
     * @return ProductCategory[]|Collection
     */
    public function handle(bool $withTrashed = false) {
        $query = $withTrashed ? ProductCategory::onlyTrashed() : ProductCategory::query();
        return $query->orderBy('name')->get();
    }

    /**
     * @param ActionRequest $request
     * @return ProductCategory[]|Collection
     */
    public function asController(ActionRequest $request) {
        $archived = $request->query('archived', 0) === '1';
        return $this->handle($archived);
    }

    /**
     * @param               $productCategories
     * @param ActionRequest $request
     * @return View
     */
    public function htmlResponse($productCategories, ActionRequest $request): View {
        $archived = $request->query('archived', 0) === '1';
        return view('productCategory.index')->with([
            'productCategories' => $productCategories,
            'archived'          => $archived
        ]);
    }

    /**
     * @param $productCategories
     * @return JsonResponse
     */
    public function jsonResponse($productCategories): JsonResponse {
        return response()->json($productCategories);
    }

}
