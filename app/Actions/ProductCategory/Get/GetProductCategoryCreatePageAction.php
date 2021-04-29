<?php namespace App\Actions\ProductCategory\Get;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsController;

class GetProductCategoryCreatePageAction {

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
            //Dependencies go here
        ];
    }

    /**
     * @param array $data
     * @return View
     */
    public function htmlResponse(array $data): View {
        return view('productCategory.create')->with($data);
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    public function jsonResponse(array $data): JsonResponse {
        return response()->json($data);
    }

}
