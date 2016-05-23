@extends('_templates.app')

@section('page-header')
    @parent
    <a class="navbar-brand first-child-md" href="">Satellites</a>
@stop


@section('page-css')
@stop

@section('page-js')

@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-block">
                    <h5>Add Badge</h5>
                    @include('_includes.errors')

                    {!!  Form::open(array('route'=>'badges.store')) !!}
                    <fieldset class="form-group">
                        {{ Form::label('name', 'Name : ',['class'=>'col-md-3']) }}
                        {{ Form::text('name',null,['class'=>'form-control col-md-9','id'=>'name',
                                'placeholder'=>'Badge Title']) }}
                    </fieldset>
                    <fieldset class="form-group">
                        {{ Form::label('description', 'Description : ',['class'=>'col-md-3']) }}
                        {{ Form::text('description',null,['class'=>'form-control col-md-9','id'=>'description',
                                'placeholder'=>'Badge Description']) }}
                    </fieldset>
                    <fieldset class="form-group">
                        {{ Form::label('logo', 'Logo : ') }}
                        {{ Form::text('logo',null,['class'=>'form-control col-md-9','id'=>'logo',
                                'placeholder'=>'Badge Logo']) }}
                    </fieldset>

                    <fieldset class="form-group">
                        {{ Form::submit('Add', null,['class'=>'col-md-3']) }}
                    </fieldset>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@stop

@section('page-scripts')
@stop