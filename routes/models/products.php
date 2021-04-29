<?php

use App\Actions\Product\BulkDeleteProductsInCategory;
use App\Actions\Product\BulkUpdateProductsInCategory;
use App\Actions\Product\CreateProductAction;
use App\Actions\Product\DeleteProductAction;
use App\Actions\Product\Get\GetProductCreatePageAction;
use App\Actions\Product\Get\GetProductEditPageAction;
use App\Actions\Product\Get\GetProductIndexAction;
use App\Actions\Product\PermanentlyDeleteProductAction;
use App\Actions\Product\RestoreProductAction;
use App\Actions\Product\UpdateProductAction;
use App\Models\Product;

Route::bind('product', function ($id) {
    return Product::withTrashed()->findOrFail($id);
});

Route::get('/product', GetProductIndexAction::class)->name('index');

Route::get('/product/create', GetProductCreatePageAction::class)->name('create');
Route::post('/product', CreateProductAction::class)->name('store');

Route::get('/product/{product}/edit', GetProductEditPageAction::class)->name('edit');
Route::put('/product/{product}', UpdateProductAction::class)->name('update');

Route::delete('/product/{product}', DeleteProductAction::class)->name('destroy');
Route::get('/product/{product}/restore', RestoreProductAction::class)->name('restore');
Route::get('/product/{product}/delete', PermanentlyDeleteProductAction::class)->name('delete-permanently');

Route::post('/product/empty-category', BulkDeleteProductsInCategory::class)->name('bulk-delete');
Route::post('/product/update-category', BulkUpdateProductsInCategory::class)->name('bulk-update');
