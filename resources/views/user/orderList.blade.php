@extends('user.layouts.master')

@section('content')

    <div class="container " style="margin-top: 150px">
        <div class="row">
            <table class="table table-hover shadow-sm ">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Date</th>
                        <th>Order Code</th>
                        <th>Order Status</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($orderList as $orderCode => $item)
                        <tr>
                            <td>{{ $item->first()->created_at->format('j F Y') }}</td>
                            <td>{{ $orderCode }}</td>
                            <td>
                                @if ($item->first()->status == 0)
                                    <i class="fa-solid fa-spinner btn btn-sm btn-warning rounded shadow-sm me-3"></i>Pending

                                @elseif ($item->first()->status == 1)
                                    <i class="fa-solid fa-check btn btn-sm btn-success rounded shadow-sm me-3"></i>Accept

                                @elseif ($item->first()->status == 2)
                                    <i class="fa-solid fa-xmark btn btn-sm btn-danger rounded shadow-sm me-3"></i>Reject

                                @endif
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

@endsection
