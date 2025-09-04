@extends('admin.layouts.master')

@section('content')

    <div class="container">
        <div class=" d-flex justify-content-between my-2">
            <a href="{{ route('account#userList') }}"> <button class=" btn btn-sm btn-secondary  "> User List</button> </a>
            <div class="">
                <form action="{{ route('account#adminList') }}" method="get">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="searchKey" value="{{ request('searchKey') }}" class=" form-control"
                            placeholder="Enter Search Key...">
                        <button type="submit" class=" btn bg-dark text-white"> <i
                                class="fa-solid fa-magnifying-glass"></i> </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-hover shadow-sm text-center">
                    <thead class="bg-primary text-white">
                        <tr>
                            {{-- <th>ID</th> --}}
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Created Date</th>
                            {{-- <th> Platform</th> --}}
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($admin) != 0)
                            @foreach ($admin as $item)
                                <tr>
                                    <td>
                                        <img class="img-profile img-thumbnail w-50" id="output"
                                        src="{{ asset( $item->profile != null ? 'profile/'.$item->profile : 'picForDefault/defaultImage.jpg' ) }}">
                                    </td>
                                    <td class="col-2">{{ $item->name != null ? $item->name : $item->nickname}}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{!! $item->address != null ? $item->address : '<span style="color: red; opacity:0.6">No Data...</span>' !!}</td>
                                    <td>{!! $item->phone != null ? $item->phone : '<span style="color: red; opacity:0.6">No Data...</span>' !!}</td>
                                    <td><span class="btn btn-sm bg-danger text-white rounded shadow-sm">{{ $item->role }}</span></td>
                                    <td class="col-2">{{$item->created_at->format('j-F-Y')}}</td>
                                    {{-- <td>
                                        @if ($item->provider == 'google') <i class="fa-brands fa-google text-primary"></i> @endif
                                        @if ($item->provider == 'github') <i class="fa-brands fa-github text-primary"></i> @endif
                                        @if ($item->provider == 'simple') <i class="fa-solid fa-right-to-bracket text-primary"></i> @endif
                                    </td> --}}
                                    <td>
                                        <button type="button" onclick="deleteProcess( {{ $item->id }} )" @if($item->role == 'superadmin') hidden @endif
                                            href="" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7">
                                    <h5 class="text-muted text-center">There is no admin</h5>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <span class=" d-flex justify-content-end">{{ $admin->links() }}</span>

            </div>
        </div>
    </div>

@endsection


@section('js-script')
    <script>
        function deleteProcess($id) {
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
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your Product has been deleted.",
                        icon: "success"
                    });

                    setTimeout(() => {
                        location.href = '/admin/account/admin/delete/' +$id
                    }, 1000);
                }
            });
        }
    </script>
@endsection
