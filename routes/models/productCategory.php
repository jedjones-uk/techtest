<?php


use App\Actions\ProductCategory\CreateProductCategoryAction;
use App\Actions\ProductCategory\DeleteProductCategoryAction;
use App\Actions\ProductCategory\Get\GetProductCategoryCreatePageAction;
use App\Actions\ProductCategory\Get\GetProductCategoryEditPageAction;
use App\Actions\ProductCategory\Get\GetProductCategoryIndexAction;
use App\Actions\ProductCategory\PermanentlyDeleteProductCategoryAction;
use App\Actions\ProductCategory\RestoreProductCategoryAction;
use App\Actions\ProductCategory\UpdateProductCategoryAction;
use App\Models\ProductCategory;

Route::bind('productCategory', function ($id) {
    return ProductCategory::withTrashed()->findOrFail($id);
});

Route::get('/product-category/', GetProductCategoryIndexAction::class)->name('index');

Route::get('/product-category/create', GetProductCategoryCreatePageAction::class)->name('create');
Route::post('/product-category/', CreateProductCategoryAction::class)->name('store');

Route::get('/product-category/{productCategory}/edit', GetProductCategoryEditPageAction::class)->name('edit');
Route::put('/product-category/{productCategory}', UpdateProductCategoryAction::class)->name('update');

Route::delete('/product-category/{productCategory}', DeleteProductCategoryAction::class)->name('destroy');
Route::get('/product-category/{productCategory}/restore', RestoreProductCategoryAction::class)->name('restore');
Route::get('/product-category/{productCategory}/delete', PermanentlyDeleteProductCategoryAction::class)->name('delete-permanently');

