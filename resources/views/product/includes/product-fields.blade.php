<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="product_name">
                @lang('Product Name')
                <em class="small text-muted d-inline ml-2">@lang('Required')</em>
            </label>
            {{html()->text('product_name')->id('product_name')->required()->maxlength(255)->autofocus(true)->class('form-control')}}
            <small class="invalid-feedback">@lang('Your product needs to be given a name')</small>
        </div>
        <br/>
        <div class="form-group">
            <label for="product_desc">
                @lang('Product description')
                <em class="small text-muted d-inline ml-2"></em>
            </label>
            {{html()->textarea('product_desc')->id('product_desc')->maxlength(2000)->class('form-control')}}
        </div>
        <br/>
        <div class="form-group">
            <label for="product_price">
                @lang('Product Price')
                <em class="small text-muted d-inline ml-2">@lang('Required')</em>
            </label>
            {{html()->number('product_price',null,0,null,0.01)->id('product_price')->required()->class('form-control')}}
            <small class="invalid-feedback">@lang('Your product needs to be given a price')</small>
        </div>
        <br/>
        <div class="form-group">
            <label for="product_category_id">
                @lang('Product Category')
                <em class="small text-muted d-inline ml-2">@lang('Required')</em>
            </label>
            {{html()->select('product_category_id', $productCategories->toArray())->id('product_category_id')->required()->class('form-control')}}
            <small class="invalid-feedback">@lang('Your product needs to be given a category')</small>
        </div>

    </div>
</div>
