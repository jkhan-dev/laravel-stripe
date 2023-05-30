@extends('base')
@section('content')
<div class="d-flex justify-content-end">
    <a href="{{route('admin.products.create')}}" class="btn w-25 bg-gradient-primary" >
        Add Product
    </a>
</div>
<div class="card">
    <div class="table-responsive">
        <table class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Price</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Quantity</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">image</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action
                    </th>

                </tr>
            </thead>
            <tbody>

                @foreach ($products as $product)
                    <tr>
                        <td>
                            <p class="text-xs text-secondary mb-0">{{ $product->name }}</p>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">{{ $product->price }}</p>

                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">{{ $product->quantity }}</p>

                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">{{ $product->description }}</p>

                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">{{  ucwords($product->status) }}</p>

                        </td>
                        <td>
                            <a href="{{asset('storage/images/'.$product->image)}}" target="_blank">
                                <img class="text-xs font-weight-bold mb-0" height="100px" width="100px" src="{{asset('storage/images/'.$product->image)}}">
                            </a>

                        </td>
                        <td class="text-center">
                            <a href="{{route('admin.products.edit',['product'=>$product->id])}}"
                                class="text-secondary btn-default btn btn-round font-weight-bold text-xs" data-original-title="Edit ">
                                Edit
                            </a>
                            <form action="{{ route('admin.products.destroy', ['product' => $product->id]) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <button type="submit" onclick="return confirm('Are You sure want to remove ?')"
                                    data-id="{{ $product->id }}"
                                    class="text-secondary btn-danger text-white ms-2 btn btn-round font-weight-bold text-xs"
                                    data-toggle="tooltip" data-original-title="Delete ">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
@endsection