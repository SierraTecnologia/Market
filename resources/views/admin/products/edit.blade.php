@extends('siravel::layouts.dashboard')

@section('stylesheets')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ Market::moduleAsset('siravel', 'css/store.css', 'text/css') }}">
@stop

@section('pageTitle') Products @stop

@section('content')

    <div class="col-md-12 mt-2">
        @include('market::products.breadcrumbs', ['location' => ['edit']])

        @include('market::products.tabs', $tabs)
    </div>

@endsection

@section('javascript')

    @parent
    {!! Minify::javascript(Market::moduleAsset('siravel', 'js/products.js', 'application/javascript')) !!}

@endsection
