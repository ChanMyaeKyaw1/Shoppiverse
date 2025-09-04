@extends('user.layouts.master')

@section('content')

    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite py-5 mt-5">
        <div class="container py-5">
            <div class="tab-class text-center">
                <div class="row g-4">
                    <div class="col-lg-4 text-start">
                        <h1>Our Products</h1>
                    </div>
                    <div class="col-lg-8 text-end">
                        <ul class="nav nav-pills d-inline-flex text-center mb-5">

                            <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill @if( request('categoryId') == null ) active @endif" href="{{ url('user/home') }}">
                                    <span class="text-dark" style="width: 130px;">All Products</span>
                                </a>
                            </li>

                            @foreach ($categories as $item)
                                <li class="nav-item">
                                    <a class="d-flex m-2 py-2 bg-light rounded-pill @if( $item->id == request('categoryId') ) active @endif" href="{{ url('user/home?categoryId='.$item->id) }}">
                                        <span class="text-dark" style="width: 130px;">{{ $item->name }}</span>
                                    </a>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <div class="col-3">
                                <div class="form">
                                    <form action="{{ route('user#homePage') }}" method="get">
                                        @csrf
                                        <div class="input-group">
                                            <input type="text" name="searchKey" value="{{ request('searchKey') }}" class=" form-control"
                                                placeholder="Enter Search Key...">
                                            <button type="submit" class=" btn"> <i
                                                    class="fa-solid fa-magnifying-glass"></i> </button>
                                        </div>
                                    </form>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <form action="{{ route('user#homePage') }}" method="get">
                                            @csrf
                                            <input type="text" name="minPrice" value="{{ request('minPrice') }}" placeholder="Minimum Price..."
                                                class=" form-control my-2">
                                            <input type="text" name="maxPrice" value="{{ request('maxPrice') }}" placeholder="Maximun Price..."
                                                class=" form-control my-2">
                                            <input type="submit" value="Search" class=" btn btn-success my-2 w-100">
                                        </form>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <form action="{{ route('user#homePage') }}" method="get">
                                            @csrf
                                            <select name="sortingType" class="form-control w-100 bg-white mt-3">
                                                <option value="name,asc" @if( request('sortingType') == "name,asc" ) selected @endif> Alpha : A - Z </option>
                                                <option value="name,desc" @if( request('sortingType') == "name,desc" ) selected @endif> Alpha : Z - A </option>
                                                <option value="price,asc" @if( request('sortingType') == "price,asc" ) selected @endif> Price : Low - High </option>
                                                <option value="price,desc" @if( request('sortingType') == "price,desc" ) selected @endif> Price : High - Low </option>
                                                <option value="created_at,asc" @if( request('sortingType') == "created_at,asc" ) selected @endif> Date : Asc - Desc </option>
                                                <option value="created_at,desc" @if( request('sortingType') == "created_at,desc" ) selected @endif> Date : Desc - Asc </option>
                                            </select>

                                            <input type="submit" value="Sort" class=" btn btn-success my-3 w-100">
                                        </form>
                                    </div>
                                </div>

                                {{-- <a href="{{ route('user#homePage') }}"> <input type="button" value="Clear Filter" onclick="" class="btn btn-danger my-3 w-100"> </a> --}}

                            </div>
                            <div class="col-9">
                                <div class="row g-4">

                                    <span>Products ( {{ count($products) }} )</span>
                                    @if( count($products) != 0 )
                                        @foreach ($products as $item)
                                            <div class="col-4">
                                                <div class="rounded position-relative fruite-item">
                                                    <div class="fruite-img">
                                                        <a href="{{ route('user#productDetails', $item->id) }}"><img src="{{ asset('productImage/' .$item->image) }}" style="height: 250px"
                                                                class="img-fluid w-100 rounded-top" alt=""></a>
                                                    </div>
                                                    <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                        style="top: 10px; left: 10px;">{{ $item->category_name }}</div>
                                                    <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                        <h4>{{ $item->name }}</h4>
                                                        <p>{{ Str::words($item->description, 10, '...') }}</p>
                                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                                            <p class="text-dark fs-5 fw-bold mb-0">{{ $item->price }} mmk</p>

                                                            <a href="{{ route('user#productDetails', $item->id) }}"
                                                                class="btn border border-secondary rounded-pill px-3 text-primary">
                                                                {{-- <i class="fa-solid fa-cart-shopping me-2 text-primary"></i> --}}
                                                                <i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        {{-- <div class="text-center">
                                            <span class="text-muted h-3 m-5">There is no product</span>
                                        </div> --}}
                                        <tr>
                                            <td colspan="7">
                                                <h5 class="text-muted text-center">There is no product</h5>
                                            </td>
                                        </tr>
                                    @endif

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fruits Shop End-->

@endsection
