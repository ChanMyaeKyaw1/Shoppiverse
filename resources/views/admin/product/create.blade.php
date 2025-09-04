@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8 offset-2 card p-3 shadow-sm rounded">

                <form action="{{ route('product#create') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">
                        <div class="mb-3">
                            <div class="text-center">
                                <img class="img-profile mb-1 w-25 rounded" id="output" src="">
                            </div>
                            <input type="file" name="image" accept="image/*" id="" class="form-control mt-1 "
                                onchange="loadFile(event)">
                            @error('image')
                                <small class = "text-danger"> {{ $message }} </small>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Enter Name...">
                                    @error('name')
                                        <small class = "text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Category Name</label>
                                    <select name="categoryId" id="" class="form-control  @error('image') is-invalid @enderror">
                                        <option value="">Choose Category...</option>

                                        @foreach ($categories as $item)
                                            <option value=" {{ $item->id }} "
                                                @if (old('categoryId') == $item->id) selected @endif> {{ $item->name }}
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
                                    <input type="number" name="price" value="{{ old('price') }}" class="form-control @error('price') is-invalid @enderror"
                                        placeholder="Enter Price...">

                                    @error('price')
                                        <small class = "text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Stock</label>
                                    <input type="number" name="stock" value="{{ old('stock') }}" class="form-control @error('stock') is-invalid @enderror"
                                        placeholder="Enter Stock...">

                                    @error('stock')
                                        <small class = "text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="" cols="30" rows="10" class="form-control @error('description') is-invalid @enderror"
                                placeholder="Enter Description..."> {{ old('description') }} </textarea>

                            @error('description')
                                <small class = "text-danger"> {{ $message }} </small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input type="submit" value="Create Product" class=" btn btn-primary w-100 rounded shadow-sm">
                        </div>
                    </div>
                </form>


            </div>

        </div>
    </div>
@endsection
