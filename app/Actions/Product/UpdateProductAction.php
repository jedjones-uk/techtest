<?php namespace App\Actions\Product;

use App\Events\Product\ProductUpdated;
use App\Models\Product;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use RuntimeException;
use Throwable;

class UpdateProductAction {

    use AsAction;

    /**
     * @var DatabaseManager
     */
    private DatabaseManager $db;

    /**
     * UpdateProductAction constructor.
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
            'product_name'        => ['required', 'max:255'],
            'product_category_id' => ['required', 'integer'],
            'product_price'       => ['required', 'numeric'],
        ];
    }

    /**
     * @param Collection $data
     * @return Product
     * @throws Throwable
     */
    public function handle(Product $product, Collection $data): Product {
        return $this->db->transaction(function () use ($product, $data) {

            $updated = $product->update($data->all());
            if ($updated) {
                event(new ProductUpdated($product));
                return $product;
            }

            throw new RuntimeException(__('There was a problem updating the product'));
        });
    }


    /**
     * @param ActionRequest $request
     * @return Product
     * @throws Throwable
     */
    public function asController(Product $product, ActionRequest $request): Product {
        $data = collect($request->only([
            'product_name', 'product_desc', 'product_category_id', 'product_price'
        ]));
        return $this->handle($product, $data);
    }

    /**
     * @return RedirectResponse
     */
    public function htmlResponse(): RedirectResponse {
        return redirect()->route('product.index');
    }

    /**
     * @param $product
     * @return JsonResponse
     */
    public function jsonResponse($product): JsonResponse {
        return response()->json($product);
    }

}
