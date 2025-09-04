@extends('admin.layouts.master')

@section('content')

    <div class="container">
        <a href="{{ route('product#list') }}" class="btn bg-dark text-white rounded shadow-sm col-1 offset-2 my-3"> <i class="fa-solid fa-backward me-2"></i> Back</a>
        <div class="row">
            <div class="col-8 offset-2 card p-3 shadow-sm rounded">

                <form action="{{ route('product#update', $product->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="productId" value="{{ $product->id }}" id="">
                    <input type="hidden" name="productImage" value="{{ $product->image }}" id="">
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="d-flex justify-content-center">
                                <img class="img-profile mb-1 w-25" accept="image/*" id="output" src="{{ asset('productImage/' .$product->image) }}">
                            </span>
                            <input type="file" name="image" class="form-control mt-1 @error('image') is-invalid @enderror " onchange="loadFile(event)">
                            @error('image')
                                <small class = "text-danger"> {{ $message }} </small>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control @error('name') is-invalid @enderror "
                                        placeholder="Enter Name...">
                                    @error('name')
                                        <small class = "text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Category Name</label>
                                    <select name="categoryId" id="" class="form-control @error('categoryId') is-invalid @enderror ">
                                        {{-- <option value="">Choose Category...</option> --}}
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->id }}"
                                                @if( old('categoryId', $product->category_id) == $item->id ) selected @endif > {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('categoryId')
                                        <small class = "text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Price</label>
                                    <input type="text" name="price" value="{{ old('price', $product->price) }}" class="form-control @error('price') is-invalid @enderror "
                                        placeholder="Enter Price...">
                                    @error('price')
                                        <small class = "text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Stock</label>
                                    <input type="text" name="stock" value="{{ old('stock', $product->stock) }}" class="form-control @error('stock') is-invalid @enderror "
                                        placeholder="Enter Stock...">
                                    @error('stock')
                                        <small class = "text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="" cols="30" rows="10" class="form-control @error('description') is-invalid @enderror "
                                placeholder="Enter Description...">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <small class = "invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input type="submit" value="Update Product" class=" btn btn-primary w-100 rounded shadow-sm">
                        </div>
                    </div>
                </form>


            </div>

        </div>
    </div>

@endsection
