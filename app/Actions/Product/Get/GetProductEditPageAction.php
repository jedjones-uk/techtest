<?php namespace App\Actions\Product\Get;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsController;

class GetProductEditPageAction {

    use AsController;

    /**
     * @param ActionRequest $request
     * @return bool
     */
    public function authorize(ActionRequest $request): bool {
        return true;
    }

    /**
     * @param Product $product
     * @return array
     */
    public function handle(Product $product): array {
        return [
            'productCategories' => ProductCategory::query()->orderBy('name')->pluck('name', 'id'),
            'product'           => $product
        ];
    }

    /**
     * @param array $data
     * @return View
     */
    public function htmlResponse(array $data): View {
        return view('product.update')->with($data);
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    public function jsonResponse(array $data): JsonResponse {
        return response()->json($data);
    }

}
