<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Management') }}
            <small class="text-sm">@lang('Update Product')</small>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row">
                <div class="col-md">
                    {{  html()->modelForm($product, 'PUT', route('product.update', $product['product_id']))->class('needs-validation')->attributes(['novalidate'])->open()}}
                    <div class="card">

                        <div class="card-body">
                            @include('product.includes.product-fields')
                        </div>

                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <a class="btn btn-outline-danger btn-sm" href="{{route('product.index')}}">Cancel</a>
                            <button class="btn btn-success btn-sm pull-right" type="submit">Update Product</button>
                        </div>

                    </div>
                    {{ html()->closeModelForm() }}
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
