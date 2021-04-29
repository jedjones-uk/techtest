<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Category List') }}
            @if($archived)
                <a href="{{route('productCategory.index')}}"
                   class="btn btn-sm btn-outline-primary float-right d-inline-block">
                    @lang('Product Category List')
                </a>
            @else
                <a href="{{route('productCategory.index',['archived'=>1])}}"
                   class="btn btn-sm btn-outline-primary float-right d-inline-block">@lang('Deleted Product Categories')</a>
            @endif
            <a href="{{route('productCategory.create')}}"
               class="btn btn-sm btn-outline-primary float-right d-inline-block mr-2">@lang('Add Product Category')</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">@lang('Name')</th>
                            <th scope="col">@lang('Last Update')</th>
                            <th scope="col">@lang('Actions')</th>
                        </tr>
                        </thead>
                        <tbody>

                        @forelse($productCategories as $productCategory)
                            <tr>
                                <th scope="row">{{$productCategory->id}}</th>
                                <td>{{$productCategory->name}}</td>
                                <td>{{$productCategory->updated_at->format('jS F Y g:i')}}</td>
                                <td>
                                    @if($archived)
                                        <a href="{{route('productCategory.restore',[$productCategory->id])}}"
                                           class="btn btn-sm btn-primary">
                                            @lang('Restore')
                                        </a>
                                        <a href="{{route('productCategory.delete-permanently',[$productCategory->id])}}"
                                           class="btn btn-sm btn-danger">
                                            @lang('Delete Permanently')
                                        </a>
                                    @else
                                        <a href="{{route('productCategory.edit',[$productCategory->id])}}"
                                           class="btn btn-sm btn-primary">
                                            @lang('Edit')
                                        </a>
                                        <form class="d-inline-block" method="POST"
                                              action="{{ route('productCategory.destroy', [ $productCategory->id ]) }}">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-sm btn-danger btn-icon">
                                                @lang('Delete')
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"> No Product Categories</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
