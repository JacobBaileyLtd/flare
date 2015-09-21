<div class="row">
    <div class="col-sm-6">
        <div class="form-group @if ($errors->has($attribute)) has-error @endif">
            <label class="control-label" for="{{ $attribute }}">
                {{ $attributeTitle }} @if (isset($field['required'])) * @endif
            </label>

            <div class="clearfix"></div>
            
            <div class="checkbox col-sm-12 col-md-6 col-lg-4">
                <label>
                    <input type="checkbox"
                            value=""
                            name=""
                            @if (true) @endif>
                    Name of Checkbox Value
                </label>
            </div>
            
            @if ($errors->has($attribute))
                <span class="help-block">
                    {{ $errors->first($attribute) }}
                </span>
            @endif
        </div>
    </div>
</div>