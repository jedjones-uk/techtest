<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Category Management') }}
            <small class="text-sm">@lang('Update Product Category')</small>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row">
                <div class="col-md">
                    {{  html()->modelForm($productCategory, 'PUT', route('productCategory.update', [$productCategory['id']]))->class('needs-validation')->attributes(['novalidate'])->open()}}
                    <div class="card">

                        <div class="card-body">
                            @include('productCategory.includes.category-fields')
                        </div>

                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <a class="btn btn-outline-danger btn-sm"
                               href="{{route('productCategory.index')}}">Cancel</a>
                            <button class="btn btn-success btn-sm pull-right" type="submit">Update Product Category
                            </button>
                        </div>

                    </div>
                    {{ html()->closeModelForm() }}
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
