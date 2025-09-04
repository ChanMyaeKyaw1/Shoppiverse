@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Category List</h1>
        </div>

        <div class="">
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body shadow">
                            <form action="{{ route('category#create') }}" method="post" class="p-3 rounded">
                                @csrf

                                <input type="text" name="categoryName"
                                    class=" form-control @error('categoryName') is invalid @enderror "
                                    placeholder="Category Name..." value="{{ old('categoryName') }}">
                                @error('categoryName')
                                    <small class = "text-danger"> {{ $message }} </small>
                                @enderror

                                <input type="submit" value="Create" class="btn btn-outline-primary mt-3">
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col ">
                    <table class="table table-hover shadow-sm ">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Created Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($categories as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->created_at->format('j-F-Y') }}</td>
                                    <td>
                                        {{-- <button type="button" onclick="editProcess({{ $item->id }})" class="btn btn-sm btn-outline-secondary">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button> --}}
                                        <a href="{{ route('category#edit', $item->id) }}" class="btn btn-sm btn-outline-secondary"> <i class="fa-solid fa-pen-to-square"></i> </a>

                                        <button type="button" onclick="deleteProcess({{ $item->id }})" class="btn btn-sm btn-outline-danger">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end"> {{ $categories->links() }} </div>

                </div>
            </div>
        </div>

    </div>
@endsection

@section('js-script')
    <script>
        // function deleteProcess($id) {
        //     Swal.fire({
        //         title: "Are you sure?",
        //         text: "You won't be able to revert this!",
        //         icon: "warning",
        //         showCancelButton: true,
        //         confirmButtonColor: "#3085d6",
        //         cancelButtonColor: "#d33",
        //         confirmButtonText: "Yes, delete it!"
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             Swal.fire({
        //                 title: "Deleted!",
        //                 text: "Your file has been deleted.",
        //                 icon: "success"
        //             });

        //             setInterval(() => {
        //                 location.href = '/admin/category/delete/' +$id
        //             }, 1000);
        //         }
        //     });
        // }

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
                    // Create a form dynamically
                    let form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/admin/category/delete/' + id;

                    // Add CSRF token
                    let csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);

                    // Append form and submit
                    document.body.appendChild(form);
                    form.submit();

                    // setInterval(() => {
                    //     location.href = '/admin/category/delete/' +$id
                    // }, 1000);
                }
            });
        }

        function editProcess(id) {
            route('category#edit')
        }
    </script>
@endsection
