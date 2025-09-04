@extends('admin.layouts.master')

@section('content')
<div class="container">
    <div class="col-6 offset-3 card p-3 shadow">
        <form action="{{ route('payment#update', $payment->id) }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label>Phone Number</label>
                    <input type="text" name="account_number" value="{{ old('account_number', $payment->account_number) }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Account Name</label>
                    <input type="text" name="account_name" value="{{ old('account_name', $payment->account_name) }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Type</label>
                    <select name="type" class="form-control">
                        <option value="">Choose Type...</option>
                        <option value="KBZ Pay" {{ $payment->type=='KBZ Pay' ? 'selected' : '' }}>KBZ Pay</option>
                        <option value="Wave Pay" {{ $payment->type=='Wave Pay' ? 'selected' : '' }}>Wave Pay</option>
                        <option value="AYA Pay" {{ $payment->type=='AYA Pay' ? 'selected' : '' }}>AYA Pay</option>
                        <option value="CB Pay" {{ $payment->type=='CB Pay' ? 'selected' : '' }}>CB Pay</option>
                        <option value="UAB Pay" {{ $payment->type=='UAB Pay' ? 'selected' : '' }}>UAB Pay</option>
                        {{-- <option value="Cash" {{ $payment->type=='Cash' ? 'selected' : '' }}>Cash</option> --}}
                    </select>
                </div>

                <div class="mb-3">
                    <label>Note</label>
                    <textarea name="note" class="form-control">{{ old('note', $payment->note) }}</textarea>
                </div>

                <input type="submit" value="Update" class="btn btn-primary w-100">
            </div>
        </form>
    </div>
</div>
@endsection
