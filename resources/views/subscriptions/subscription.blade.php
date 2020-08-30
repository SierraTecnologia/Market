@extends('siravel-frontend::layouts.store')

@section('store-content')

    <h3 class="mb-4">Subscriptions</h3>

    <table class="table table-stripped">
        <tr>
            <td>Name</td>
            <td class="text-right">{{ $subscription->name }}</td>
        </tr>
        <tr>
            <td>Ending On</td>
            <td class="text-right">{{ $subscription->ends_at }}</td>
        </tr>
        <tr>
            <td>Created On</td>
            <td class="text-right">{{ $subscription->created_at }}</td>
        </tr>
        <tr>
            <td>Details</td>
            <td class="text-right">{{ market()->subscriptionPlan($subscription)->description }}</td>
        </tr>
        @if (is_null($subscription->ends_at))
            <tr>
                <td>Upcoming</td>
                <td class="text-right">
                    {{ market()->subscriptionUpcoming($subscription)['total'] }}<br>
                    {{ market()->subscriptionUpcoming($subscription)['date'] }}
                </td>
            </tr>
        @endif
    </table>

    @if (is_null($subscription->ends_at))
        {!! market()->cancelSubscriptionBtn($subscription, 'btn btn-danger fload-right') !!}
    @endif

@endsection

