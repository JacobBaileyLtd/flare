@extends('flare::admin.sections.wrapper')

@section('page_title', $modelAdmin::title())

@section('content')

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">
            Edit {{ $modelAdmin->modelManager()->title() }}
        </h3>
    </div>
    <form action="" method="post">
        <div class="box-body">
            @foreach ($modelAdmin->modelManager()->getMapping() as $attribute => $field)
                {!! \Flare::renderAttribute('edit', $attribute, $field, $modelItem, $modelAdmin->modelManager()) !!}
            @endforeach
        </div>
        <div class="box-footer">
            {!! csrf_field() !!}
            <a href="{{ $modelAdmin::currentUrl() }}" class="btn btn-default">
                Cancel
            </a>
            <button class="btn btn-primary" type="submit">
                <i class="fa fa-edit"></i>
                Update {{ $modelAdmin->modelManager()->title() }}
            </button>
        </div>
    </form>
</div>

@stop
