<?php namespace App\Actions\Product;

use App\Events\Product\ProductsInCategoryDeleted;
use App\Models\Product;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use RuntimeException;
use Throwable;

class BulkDeleteProductsInCategory {

    use AsAction;

    /**
     * @var DatabaseManager
     */
    private DatabaseManager $db;

    /**
     * BulkDeleteProductsInCategory constructor.
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
     * @param string $categorySlug
     * @return Collection
     * @throws Throwable
     */
    public function handle(string $categorySlug): Collection {
        return $this->db->transaction(function () use ($categorySlug) {
            $toDelete = Product::whereHas('productCategory', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            })->get();
            $deleted = Product::whereIn('product_id', $toDelete->pluck('product_id'))->delete();
            if ($deleted) {
                event(new ProductsInCategoryDeleted($toDelete, $categorySlug));
                return $deleted;
            }

            throw new RuntimeException(__('There was a problem deleting the products in this category'));
        });
    }

    /**
     * @param ActionRequest $request
     * @return Collection
     * @throws Throwable
     */
    public function asController(ActionRequest $request): Collection {
        $categorySlug = $request->get('product_category');
        return $this->handle($categorySlug);
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
