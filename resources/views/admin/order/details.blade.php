@extends('admin.layouts.master')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">


        <a href="{{ route('admin#orderList') }}" class=" text-black m-3"> <i class="fa-solid fa-arrow-left-long"></i> Back</a>

        <!-- DataTales Example -->


        <div class="row">
            <div class="card col-5 shadow-sm m-4 col">
                <div class="card-header bg-primary text-white">
                    Registered Customer Information
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-5">Name :</div>
                        <div class="col-7">{{ $order[0]->user_name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Phone :</div>
                        <div class="col-7">
                            {{ $order[0]->user_phone == null ? '...' : $order[0]->user_phone }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Address : {{ $order[0]->address }}</div>
                        <div class="col-7">
                            {{ $order[0]->address == null ? '...' : $order[0]->address }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Order Code :</div>
                        <div class="col-7" id="orderCode">{{ $order[0]->order_code }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Order Date :</div>
                        <div class="col-7">{{ $order[0]->created_at->format("j-F-Y") }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Total Price :</div>
                        <div class="col-7">{{ ($paymentHistory->total_amt)*1 }} mmk<br>
                            <small class=" text-danger ms-1">( Contain Delivery Charges )</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card col-5 shadow-sm m-4 col">
                <div class="card-header bg-primary text-white">
                    Payment History Information
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-5">Contact Phone :</div>
                        <div class="col-7">{{ $paymentHistory->phone }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Address :</div>
                        <div class="col-7">{{ $paymentHistory->address }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Payment Method :</div>
                        <div class="col-7">{{ $paymentHistory->payment_type }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Purchase Date :</div>
                        <div class="col-7">{{ $paymentHistory->created_at->format("j-F-Y") }}</div>
                    </div>
                    <div class="row mb-3">
                        <img style="width: 150px" src="{{ asset('/payslip_image/'.$paymentHistory->payslip_image) }}" class=" img-thumbnail">
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                Order Board
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover shadow-sm data-table" id="">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="col-2">Image</th>
                                <th>Name</th>
                                <th>Order Count</th>
                                <th>Available Stock</th>
                                <th>Product Price (each)</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($order as $item)
                                <tr>
                                    <input type="hidden" class="productId" value="{{ $item->product_id }}">
                                    <input type="hidden" class="count" value="{{ $item->order_count }}">

                                    <td>
                                        <img src="{{ asset('/productImage/'.$item->image) }}" class=" w-50 img-thumbnail rounded-circle">
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->order_count }} @if( $item->order_count > $item->stock)
                                        <small class="text-danger">( out of stock )</small> @endif</td>
                                    <td>{{ $item->stock }}</td>
                                    <td>{{ $item->price }} mmk</td>
                                    <td>{{ $item->price * $item->order_count }} mmk</td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <div class="">
                    @if($status)
                        <button type="button" id="btn-order-accept" class="btn btn-success rounded shadow-sm">Accept</button>
                    @endif
                    <button type="button" id="btn-order-reject" class="btn btn-danger rounded shadow-sm">Reject</button>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

@endsection


@section('js-script')
<script>
    // $(document).ready(function() {
    //     orderCode = $('#orderCode').text();
    //     console.log('it is working');

    //     $.ajax({
    //         type : 'get',
    //         url : '/admin/order/reject',
    //         data : { 'orderCode' : orderCode },
    //         dataType : 'json',
    //         success : function(res) {
    //             res.status == success ? location.href='/admin/order/list' : '';
    //         }

    //     });
    // })

    $(document).ready(function () {

        $('#btn-order-accept').click(function() {
            orderCode = $('#orderCode').text();
            orderList = [];

            $('.data-table tbody tr').each(function(index, row) {
                productId = $(row).find('.productId').val();
                count = $(row).find('.count').val();

                orderList.push({
                    'product_id' : productId,
                    'count' : count,
                    'order_code' : orderCode,
                })
            })
            // console.log(orderList);

            $.ajax({
                type: 'get',
                url: '/admin/order/confirm',
                data: Object.assign({}, orderList),
                dataType: 'json',
                success: function (res) {
                    if (res.status == 'success') {
                        window.location.href = '/admin/order/list';
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Reject request failed:", error);
                }
            });

        })

        $('#btn-order-reject').click(function() {
            orderCode = $('#orderCode').text();

            $.ajax({
                type: 'get',
                url: '/admin/order/reject',
                data: { orderCode : orderCode },
                dataType: 'json',
                success: function (res) {
                    if (res.status == 'success') {
                        window.location.href = '/admin/order/list';
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Reject request failed:", error);
                }
            });
        });
    });

</script>
@endsection
