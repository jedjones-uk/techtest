<?php namespace App\Actions\Product\Get;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class GetProductIndexAction {

    use AsAction;

    /**
     * @param ActionRequest $request
     * @return bool
     */
    public function authorize(ActionRequest $request): bool {
        return true; //Would put permission checks here
    }

    /**
     * @param bool        $withTrashed
     * @param string|null $categorySlug
     * @return Product[]|Collection
     */
    public function handle(bool $withTrashed = false, string $categorySlug = null) {
        $query = $withTrashed ? Product::onlyTrashed() : Product::query();
        $query->with(['productCategory']);

        if ($categorySlug !== null) {
            $query->whereHas('productCategory', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        return $query->orderBy('product_name')->get();
    }

    /**
     * @param ActionRequest $request
     * @return Product[]|Collection
     */
    public function asController(ActionRequest $request) {
        $categorySlug = $request->get('product_category');
        $archived = $request->query('archived', 0) === '1';
        return $this->handle($archived, $categorySlug);
    }

    /**
     * @param $products
     * @return View
     */
    public function htmlResponse($products, ActionRequest $request): View {
        $archived = $request->query('archived', 0) === '1';
        return view('product.index')->with([
            'products' => $products,
            'archived' => $archived
        ]);
    }

    /**
     * @param $products
     * @return JsonResponse
     */
    public function jsonResponse($products): JsonResponse {
        return response()->json($products);
    }

}
