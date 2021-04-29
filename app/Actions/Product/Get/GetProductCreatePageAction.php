<?php namespace App\Actions\Product\Get;

use App\Models\ProductCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsController;

class GetProductCreatePageAction {

    use AsController;

    /**
     * @param ActionRequest $request
     * @return bool
     */
    public function authorize(ActionRequest $request): bool {
        return true;
    }

    /**
     * @return array
     */
    public function handle(): array {
        return [
            'productCategories' => ProductCategory::query()->orderBy('name')->pluck('name', 'id')
        ];
    }

    /**
     * @param array $data
     * @return View
     */
    public function htmlResponse(array $data): View {
        return view('product.create')->with($data);
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    public function jsonResponse(array $data): JsonResponse {
        return response()->json($data);
    }

}
