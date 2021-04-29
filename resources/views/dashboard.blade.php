<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!

@markdown
# API Routes

The web and api routes of this code are both powered by the same code. They are implemented with action classes and can be found in `app/Actions`. I extended the model given to use a seperate product category table because it's the better design and I like to be able to update such things. All api routes are the same as the web routes, but prefexid with `api`

### This documentation assumes the reader is familar with Laravel 8.

The following routes are available.

#### products

| Method | Route | Name | Action |
| ------ | ------ | ------ | ------ |
| GET | /product | product.index |list all products |
| GET | /product/create | product.create | Provide all options needed to create a product (the product category list) |
| POST | /product | product.store | Create a new product |
| GET | /product/{product}/edit | product.edit | Shows same as `product.create` + the product you want to edit |
| PUT | /product/{product} | product.update | Update Product |
| DELETE | /product/{product} | product.destroy | Soft Delete the product |
| GET | /product/{product}/restore | product.restore | Restore the product from softdelete |
| GET | /product/{product}/delete | product.delete-permanently | Delete the product from the database |
| POST | /product/empty-category | product.bulk-delete | Soft delete all products in a categroy |
| POST | /product/update-category | product.bulk-update | Bulk update all product in a category |

#### Product Category

| Method | Route | Name | Action |
| ------ | ------ | ------ | ------ |
| GET | /product-category | productCategory.index | list all categories |
| GET | /product-category/create | productCategory.create | Empty for json, but would be used as above to deliver dependacies |
| POST | /product-category | productCategory.store | Create a new category |
| GET | /product-category/{productCategory}/edit | productCategory.edit | Shows same as `productCategory.create` + the category you want to edit |
| PUT | /product-category/{productCategory} | productCategory.update | Update category |
| DELETE | /product-category/{productCategory} | productCategory.destroy | Soft Delete the category |
| GET | /product-category/{productCategory}/restore | productCategory.restore | Restore the category from softdelete |
| GET | /product-category/{productCategory}/delete | productCategory.delete-permanently | Delete the  category from the database |

#### Notes

Both Index routes accept additional query parameters:
- `archived` : When this is given the value `1`, then the index will be of all soft deleted results.
- `product_category` : This will filter the results based on the product category slug.
- These can be combined

The translation is defaulted to enlglish, to get a alternative translate the paramter `locale` should be set either as a query parama, or a post value. This will be detected by a Middleware and used to set the working language. To add a language to a product, you would use the update route and include the `locale` to indicate which you want to set.

There is seeders included to create test data, and some basic tests implemented.

There default account is `admin@admin.test`/`password`
@endmarkdown

                </div>
            </div>
        </div>
    </div>
</x-app-layout>