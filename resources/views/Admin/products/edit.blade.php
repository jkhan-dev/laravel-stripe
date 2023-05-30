@extends('base')
@section('content')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6>Products</h6>
                    </div>
                </div>
                <hr>
                <div class="card-body ">
                    <form enctype="multipart/form-data" method="post"
                        action="{{ route('admin.products.update',['product'=>$product]) }}">
                      @csrf
                      @method('PUT')
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <input type="text" class="form-control"  id="name"
                                        name="name" value="{{ $product->name}}" placeholder="Product Name">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <input type="number" class="form-control"  id="qty"
                                        name="quantity" value="{{$product->quantity }}" placeholder="Quantity">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <input type="number" class="form-control"  id="price"
                                        name="price" value="{{$product->price }}" placeholder="Price">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <textarea  class="form-control"  name="description"  placeholder="Description">{{$product->description }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <input type="file" class="form-control"  id="image"
                                        name="image" placeholder="">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                  <select name="status" class="form-select" id="status">
                                    <option value="" disabled selected>Select Status</option>
                                    <option {{$product->status =='active' ? 'selected' : ''}} value="active">active</option>
                                    <option {{$product->status =='inactive' ? 'selected' : ''}} value="inactive">inactive</option>
                                  </select>
                                </div>
                            </div>
                        </div>
                        <div class="my-3">
                            <button type="submit" class="btn bg-gradient-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection