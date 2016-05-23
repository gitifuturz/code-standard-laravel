@extends('_templates.app')

@section('page-header')
    @parent
    <a class="navbar-brand first-child-md" href="">Badges</a>
@stop


@section('page-css')
    <link type="text/css" href="{{ URL::asset('assets/css/datatables.min.css') }}" rel="stylesheet">
@stop

@section('page-js')
    <script>
        jQuery(document).ready(function () {
            $('#table-badges').DataTable();
        });
    </script>

@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Badges List</h5>
        </div>
        
        <div class="clearfix"></div>
    </div>

@stop