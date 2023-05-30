@extends('base')
@section('content')

<div class="card">
    <div class="table-responsive">
        <table class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Order Id</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Product Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Quantity</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Amount</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Payment Status</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action
                    </th>

                </tr>
            </thead>
            <tbody>

                @foreach ($orders as $order)
                    <tr>
                        <td>
                            <p class="text-xs text-secondary mb-0">#{{ $order->order_id }}</p>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">{{ $order->product->name }}</p>

                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">{{ $order->qty }}</p>

                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">&#8377;{{ $order->amount }}</p>

                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">{{ ucwords($order->payment->status) }}</p>

                        </td>
                       
                        <td class="text-center">
                            <form action="{{route('orders.update',['order'=>$order->id])}}" method="post">
                            @method('PUT')
                            @csrf
                                <select  onchange="submitParentForm(this)" name="status" class="form-select" id="">
                                    <option {{$order->status == 'new-order' ? 'selected' : ''}} value="new-order" >New Order</option>
                                    <option {{$order->status == 'in-process' ? 'selected' : ''}} value="in-process" >In Process</option>
                                    <option {{$order->status == 'completed' ? 'selected' : ''}} value="completed" >Completed</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
@endsection

@push('js')
<script>
    const submitParentForm = e =>{
        let Userconfirm = confirm('Are you Sure to update ?');
        if(!Userconfirm) return false;
        let form = e.closest('form')
        form.submit()
    }
</script>

@endpush
