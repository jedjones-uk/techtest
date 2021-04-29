<?php namespace App\Actions\ProductCategory;

use App\Events\ProductCategory\ProductCategoryCreated;
use App\Models\ProductCategory;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use RuntimeException;
use Throwable;

class CreateProductCategoryAction {

    use AsAction;

    /**
     * @var DatabaseManager
     */
    private DatabaseManager $db;

    /**
     * CreateProductCategoryAction constructor.
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
            'name' => ['required', 'max:255'],
        ];
    }

    /**
     * @param Collection $data
     * @return ProductCategory
     * @throws Throwable
     */
    public function handle(Collection $data): ProductCategory {
        return $this->db->transaction(function () use ($data) {
            $ProductCategory = ProductCategory::create($data->all());
            if ($ProductCategory) {
                event(new ProductCategoryCreated($ProductCategory));
                return $ProductCategory;
            }

            throw new RuntimeException(__('There was a problem creating the product category'));
        });
    }


    /**
     * @param ActionRequest $request
     * @return ProductCategory
     * @throws Throwable
     */
    public function asController(ActionRequest $request): ProductCategory {
        $data = collect($request->only(['name', 'description']));
        return $this->handle($data);
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
