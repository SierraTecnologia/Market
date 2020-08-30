@extends('siravel-frontend::layouts.store')

@section('store-content')

    <h1 class="mb-4">Checkout: Confirmation</h1>

    <div class="row">
        <div class="col-md-4">
            <h4 class="mb-4">Shipping Info</h4>
            <form method="post" action="{!! route('siravel.calculate.shipping') !!}">
                {!! csrf_field() !!}
                <div class="form-group">
                    <input class="form-control" required name="address[street]" placeholder="Street" value="{!! market()->customer()->shippingAddress('street') !!}">
                </div>
                <div class="form-group">
                    <input class="form-control" required name="address[postal]" placeholder="Postal" value="{!! market()->customer()->shippingAddress('postal') !!}">
                </div>
                <div class="form-group">
                    <input class="form-control" required name="address[city]" placeholder="City" value="{!! market()->customer()->shippingAddress('city') !!}">
                </div>
                <div class="form-group">
                    <input class="form-control" required name="address[state]" placeholder="State" value="{!! market()->customer()->shippingAddress('state') !!}">
                </div>
                <div class="form-group">
                    <input class="form-control" required name="address[country]" placeholder="Country" value="{!! market()->customer()->shippingAddress('country') !!}">
                </div>
                <input class="btn btn-outline-secondary pull-right" type="submit" value="Re-calculate Shipping">
            </form>
        </div>
        <div class="col-md-8">
            <h4 class="mb-4">Shopping Cart</h4>
            @include('siravel-frontend::checkout.coupon')
            @include('siravel-frontend::checkout.products')
            <a class="pull-right btn btn-primary" href="{!! route('siravel.payment') !!}">Purchase</a>
        </div>
    </div>

@endsection
