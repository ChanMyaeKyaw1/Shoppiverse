@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Payment Accounts</h1>
        </div>

        <div class="row">
            {{-- left: create form --}}
            <div class="col-4">
                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('payment#store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label>Phone Number</label>
                                <input name="account_number" value="{{ old('account_number') }}"
                                    class="form-control @error('account_number') is-invalid @enderror">
                                @error('account_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label>Account Name</label>
                                <input name="account_name" value="{{ old('account_name') }}"
                                    class="form-control @error('account_name') is-invalid @enderror">
                                @error('account_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label>Type</label>
                                <select name="type" class="form-control @error('type') is-invalid @enderror">
                                    <option value="">Choose Type...</option>
                                    <option value="Bank Transfer" {{ old('type') == 'Bank Transfer' ? 'selected' : '' }}>KBZ Pay</option>
                                    <option value="Mobile Wallet" {{ old('type') == 'Mobile Wallet' ? 'selected' : '' }}>Wave Pay</option>
                                    <option value="Mobile Wallet" {{ old('type') == 'Mobile Wallet' ? 'selected' : '' }}>AYA Pay</option>
                                    <option value="Mobile Wallet" {{ old('type') == 'Mobile Wallet' ? 'selected' : '' }}>CB Pay</option>
                                    <option value="Mobile Wallet" {{ old('type') == 'Mobile Wallet' ? 'selected' : '' }}>UAB Pay</option>
                                    {{-- <option value="Cash" {{ old('type') == 'Cash' ? 'selected' : '' }}>Cash</option> --}}
                                </select>
                                @error('type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label>Note (optional)</label>
                                <textarea name="note" class="form-control">{{ old('note') }}</textarea>
                            </div>

                            <input type="submit" class="btn btn-outline-primary w-100" value="Create">
                        </form>
                    </div>
                </div>
            </div>

            {{-- right: table --}}
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>ID</th>
                                    <th>Phone Number</th>
                                    <th>Account Name</th>
                                    <th>Type</th>
                                    <th>Created Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $p)
                                    <tr>
                                        <td>{{ $p->id }}</td>
                                        <td>{{ $p->account_number }}</td>
                                        <td>{{ $p->account_name }}</td>
                                        <td>{{ $p->type }}</td>
                                        <td>{{ $p->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="{{ route('payment#edit', $p->id) }}"
                                                class="btn btn-sm btn-outline-secondary"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>

                                            <button type="button" onclick="deleteProcess({{ $p->id }})"
                                                class="btn btn-sm btn-outline-danger">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No payment account yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-end">
                            {{ $payments->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-script')
    <script>
        function deleteProcess(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    // create POST form and submit
                    let form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/admin/payment/delete/' + id;

                    let csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
@endsection
