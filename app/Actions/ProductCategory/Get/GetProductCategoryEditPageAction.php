<?php namespace App\Actions\ProductCategory\Get;

use App\Models\ProductCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsController;

class GetProductCategoryEditPageAction {

    use AsController;

    /**
     * @param ActionRequest $request
     * @return bool
     */
    public function authorize(ActionRequest $request): bool {
        return true;
    }

    /**
     * @param ProductCategory $productCategory
     * @return array
     */
    public function handle(ProductCategory $productCategory): array {
        return [
            'productCategory' => $productCategory
        ];
    }

    /**
     * @param array $data
     * @return View
     */
    public function htmlResponse(array $data): View {
        return view('productCategory.update')->with($data);
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    public function jsonResponse(array $data): JsonResponse {
        return response()->json($data);
    }

}
