<div class="row">
    <div class="col-sm-6">
        <div class="form-group @if ($errors->has($attribute)) has-error @endif">
            <label class="control-label" for="{{ $attribute }}">
                {{ $attributeTitle }} @if (isset($field['required'])) * @endif
            </label>

            <div class="clearfix"></div>
            
            @if(count($field['options']) > 0)
                @foreach ($field['options'] as $value => $option)
                <div class="checkbox col-sm-12 col-md-6 col-lg-4">
                    <label>
                        <input type="checkbox"
                                value="{{ $value }}"
                                name="{{ $attribute }}"
                                @if (isset($field['required'])) required="required" @endif>
                        {{ $option }}
                    </label>
                </div>
                @endforeach
            @else 
                <div class="callout callout-warning">
                    <strong>
                    No options available for {{ $attributeTitle }}!
                    </strong>
                </div>
            @endif
            
            @if ($errors->has($attribute))
                <span class="help-block">
                    {{ $errors->first($attribute) }}
                </span>
            @endif
        </div>
    </div>
</div>