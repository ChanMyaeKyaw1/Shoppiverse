@extends('admin.layouts.master')

@section('content')

    <div class="container">
        <div class=" d-flex justify-content-between my-2">
            <div class=""></div>
            <div class="">
                {{-- <form action="{{ route('admin#orderList') }}" method="get">

                    <div class="input-group">
                        <input type="text" name="searchKey" value="" class=" form-control"
                            placeholder="Enter Search Key...">
                        <button type="submit" class=" btn bg-dark text-white"> <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form> --}}
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col-6">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <span class="">
                                <strong><i class="fa-solid fa-triangle-exclamation text-warning me-3"></i></strong>
                                You can click order code to see order details... </span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
                <table class="table table-hover shadow-sm ">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Date</th>
                            <th>Order Code</th>
                            <th>Customer Name</th>
                            <th>Order Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderList as $orderCode => $item)
                            <tr>
                                <td>{{ $item->first()->created_at->format('j F Y') }}</td>
                                <td> <a href="{{ route('admin#orderDetails', $orderCode) }}" class="orderCode">{{ $orderCode }}</a> </td>
                                <td>{{ $item->first()->name }}</td>
                                <td>
                                    <select name="" id="" class="form-select statusChange">
                                        <option value="0" @if( $item->first()->status == 0 ) selected @endif>Pending</option>

                                        {{-- @foreach($item as $product) --}}
                                            {{-- @if($item->count <= $item->stock) --}}
                                                <option value="1" @if($item->first()->status == 1) selected @endif>Success</option>
                                            {{-- @endif --}}
                                        {{-- @endforeach --}}

                                        <option value="2" @if( $item->first()->status == 2 ) selected @endif>Reject</option>
                                    </select>
                                </td>
                                <td>
                                    @if ( $item->first()->status == 0 )
                                        <i class="fa-solid fa-spinner text-warning"></i>

                                    @elseif ( $item->first()->status == 1 )
                                        <i class="fa-solid fa-check text-success"></i>

                                    @elseif ( $item->first()->status == 2 )
                                        <i class="fa-solid fa-xmark text-danger"></i>

                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection


@section('js-script')
<script>
    $(document).ready(function () {
        $('.statusChange').change(function () {
            let status = $(this).val();
            let orderCode = $(this).parents("tr").find(".orderCode").text();
            // console.log("Order Code:", orderCode, "Status:", status);

            $.ajax({
                type: 'get',
                url: '/admin/order/statusChange',
                data: {
                    order_code: orderCode,        // match backend naming
                    status: status
                },

                dataType: 'json',
                success: function (res) {
                    if (res.status == 'success') {
                        location.reload();
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Status changing failed:", error);
                }
            });
        });
    });
</script>
@endsection


{{-- @section('js-script') --}}
{{-- <script>
    $(document).ready(function () {
        $('.statusChange').change(function () {
            status = $(this).val();
            orderCode = $(this).parents("tr").find(".orderCode").text();
            console.log(orderCode);

            $data = {
                'order_code' : orderCode,
                'status' : status
            };

            $.ajax({
                type: 'get',
                url: '/admin/order/statusChange',
                data: { orderCode: orderCode },
                dataType: 'json',
                success: function (res) {
                    if (res.status == 'success') {
                        location.reload();
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Status changing failed:", error);
                }
            });
        });
    });
</script> --}}
{{-- @endsection --}}
