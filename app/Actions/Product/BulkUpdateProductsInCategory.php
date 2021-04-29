<?php namespace App\Actions\Product;

use App\Events\Product\ProductsInCategoryUpdated;
use App\Models\Product;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use RuntimeException;
use Throwable;

class BulkUpdateProductsInCategory {

    use AsAction;

    /**
     * @var DatabaseManager
     */
    private DatabaseManager $db;

    /**
     * BulkUpdateProductsInCategory constructor.
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
     * @return array
     */
    public function rules(): array {
        return [
            'product_category' => ['required']
        ];
    }

    /**
     * @param string                         $categorySlug
     * @param \Illuminate\Support\Collection $data
     * @return Collection
     * @throws Throwable
     */
    public function handle(string $categorySlug, \Illuminate\Support\Collection $data): Collection {
        return $this->db->transaction(function () use ($categorySlug, $data) {

            $toUpdate = Product::whereHas('productCategory', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            })->get();

            $updated = Product::whereIn('product_id', $toUpdate->pluck('product_id'))->update($data->all());;
            if ($updated) {
                event(new ProductsInCategoryUpdated($toUpdate, $categorySlug));
                return $updated;
            }

            throw new RuntimeException(__('There was a problem updating all the products in this category'));
        });
    }

    /**
     * @param ActionRequest $request
     * @return Collection
     * @throws Throwable
     */
    public function asController(ActionRequest $request): Collection {
        $categorySlug = $request->get('product_category');
        $data = collect($request->only(['product_name', 'product_desc', 'product_category_id', 'product_price']))->filter();
        return $this->handle($categorySlug, $data);
    }

    /**
     * @return RedirectResponse
     */
    public function htmlResponse(): RedirectResponse {
        return redirect()->route('product.index');
    }

    /**
     * @param Collection $products
     * @return JsonResponse
     */
    public function jsonResponse(Collection $products): JsonResponse {
        return response()->json($products);
    }

}
