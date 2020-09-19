@extends( (isset($bladeLayout) && !empty($bladeLayout)) ?: \Illuminate\Support\Facades\Config::get('pedreiro.blade_layout', 'layouts.app'))

@section('stylesheets')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ Market::moduleAsset('css/store.css', 'text/css') }}">
@stop

@section('pageTitle') Products @stop

@section('content')

    <div class="col-md-12 mt-2">
        @include('market::admin.products.breadcrumbs', ['location' => ['edit']])

        @include('market::admin.products.tabs', $tabs)
    </div>

@endsection

@section('javascript')

    @parent
    {!! Minify::javascript(Market::moduleAsset('js/products.js', 'application/javascript')) !!}

@endsection
