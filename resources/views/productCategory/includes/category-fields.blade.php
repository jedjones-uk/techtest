<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="name">
                @lang('Category Name')
                <em class="small text-muted d-inline ml-2">@lang('Required')</em>
            </label>
            {{html()->text('name')->id('name')->required()->maxlength(255)->autofocus(true)->class('form-control')}}
            <small class="invalid-feedback">@lang('Your product category needs to be given a name')</small>
        </div>
        <br/>
        <div class="form-group">
            <label for="product_desc">
                @lang('Category Description')
                <em class="small text-muted d-inline ml-2"></em>
            </label>
            {{html()->textarea('description')->id('description')->maxlength(2000)->class('form-control')}}
        </div>

    </div>
</div>
