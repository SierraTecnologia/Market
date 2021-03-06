@extends( (isset($bladeLayout) && !empty($bladeLayout)) ?: \Illuminate\Support\Facades\Config::get('pedreiro.blade_layout', 'layouts.app'))

@section('pageTitle') Orders: Edit @stop

@section('content')

    <div class="modal fade" id="cancelDialog" tabindex="-3" role="dialog" aria-labelledby="refundModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="refundModalLabel">Cancel Order</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to cancel this order? This will refund the customer's transaction.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a id="cancelBtn" class="btn btn-danger" href="#">Confirm Cancel</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mt-4">

        {!! Form::model($order, ['route' => ['master'.'.orders.update', $order->id], 'method' => 'patch']) !!}

            <div class="row raw-margin-bottom-24">
                <div class="col-md-6">
                    @include('market::master.orders.breadcrumbs', ['location' => ['edit']])
                </div>
                <div class="col-md-6">
                    <h4 class="text-center raw-margin-top-8">#{{ $order->uuid }} @if ($order->is_shipped) <span class="fa fa-truck"></span> @endif</h4>
                    @if ($order->status == 'cancelled')
                        <div class="alert alert-danger text-center">
                            <span>Cancelled on: {{ Carbon\Carbon::parse($order->refund_date)->toFormattedDateString() }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <table class="table table-sitecpaymentd">
                        <tr>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                        @foreach($order->items as $item)
                        <tr>
                            <td><a href="{{ url('master'.'/orders/item/'.$item->id) }}">{{ $item->product->name }}</a></td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->total }}</td>
                            <td>{{ ucfirst($item->status) }}</td>
                            <td class="text-right">
                                <a href="{{ url('master'.'/orders/item/'.$item->id) }}" class="btn btn-sm btn-outline-primary">Review</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-sitecpaymentd">
                        @foreach(json_decode($order->shipping_address) as $address => $detail)
                        <tr>
                            <td>{{ ucfirst($address) }}</td>
                            <td>{{ $detail }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>

            </div>

            {!! FormMaker::setColumns(2)->fromObject($order, [
                'is_shipped' => [
                    'type' => 'checkbox',
                ],
                'status' => [
                    'type' => 'string'
                ],
                'tracking_number' => [
                    'type' => 'string'
                ],
                'notes' => [
                    'type' => 'text'
                ],
            ]) !!}

            <div class="form-group float-right">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>
        {!! Form::close() !!}

        @if ($order->status !== 'cancelled' && !$order->hasRefundedOrderItems())
            {!! Form::open(['id' => 'cancelForm', 'url' => 'master'.'/orders/cancel', 'method' => 'post', 'class' => 'inline-form float-left']) !!}
                @input_maker_create('id', ['type' => 'hidden'], $order)
                {!! Form::submit('Cancel Order', ['class' => 'btn btn-warning']) !!}
            {!! Form::close() !!}
        @endif
    </div>
@endsection

@section('javascript')
    @parent
    <script type="text/javascript">
        $(function(){
            $('#cancelForm').submit(function(e){
                e.preventDefault();
                $('#cancelDialog').modal('show');
            });

            $('#cancelBtn').click(function(e){
                $('#cancelForm')[0].submit();
                $('#cancelDialog').modal('hide');
            });
        });
    </script>
@endsection
