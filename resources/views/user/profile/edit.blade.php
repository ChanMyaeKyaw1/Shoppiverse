@extends('user/layouts/master')

@section('content')

    <!-- Main Content Wrapper with adequate padding to push it safely beneath the fixed navbar -->
    <div class="container" style="padding-top: 180px; padding-bottom: 80px; position: relative;">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <!-- Profile Card Grid Container -->
                <div class="card shadow border-0 rounded-3">
                    <div class="card-header bg-white py-3 border-bottom-0">
                        <h5 class="m-0 font-weight-bold text-primary" style="color: #81c408 !important;">User Profile</h5>
                    </div>

                    <form action="{{ route('user#updateProfile') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body p-4">
                            <div class="row">

                                <!-- Left Column: Profile Picture Upload Wrapper -->
                                <div class="col-md-4 text-center d-flex flex-column align-items-center justify-content-center mb-4 mb-md-0 border-end-md">
                                    <div class="mb-3 p-2 bg-light rounded" style="width: 200px; height: 200px; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid #dee2e6;">
                                        <img class="img-fluid" id="output"
                                             src="{{ asset( Auth::user()->profile != null ? 'profile/'.Auth::user()->profile : 'picForDefault/defaultImage.jpg' ) }}"
                                             style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                    </div>

                                    <div class="px-2 w-100">
                                        <input type="file" name="image" accept="image/*" class="form-control @error('image') is-invalid @enderror" onchange="loadFile(event)">
                                        @error('image')
                                            <small class="invalid-feedback d-block text-start">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Right Column: User Information Input Fields -->
                                <div class="col-md-8">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label font-weight-bold text-secondary small">Name</label>
                                                <input type="text" name="name" class="form-control py-2 @error('name') is-invalid @enderror" placeholder="Name..."
                                                       value="{{ old('name', Auth::user()->name != null ? Auth::user()->name : Auth::user()->nickname) }}">
                                                @error('name')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label font-weight-bold text-secondary small">Email</label>
                                                <input type="email" name="email" class="form-control py-2 @error('email') is-invalid @enderror"
                                                       value="{{ old('email', Auth::user()->email) }}" placeholder="Email...">
                                                @error('email')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label font-weight-bold text-secondary small">Phone</label>
                                                <input type="text" name="phone" class="form-control py-2 @error('phone') is-invalid @enderror"
                                                       value="{{ old('phone', Auth::user()->phone) }}" placeholder="09xxxxxx">
                                                @error('phone')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label font-weight-bold text-secondary small">Address</label>
                                                <input type="text" name="address" class="form-control py-2 @error('address') is-invalid @enderror"
                                                       value="{{ old('address', Auth::user()->address) }}" placeholder="Address">
                                                @error('address')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="my-3">
                                        <a href="{{ route('user#changePasswordPage') }}" class="text-decoration-none fw-bold" style="color: #81c408;">Change Password</a>
                                    </div>

                                    <button type="submit" class="btn btn-primary px-4 py-2 text-white fw-bold rounded-pill" style="background-color: #81c408; border-color: #81c408;">
                                        Update Profile
                                    </button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('js-script')
<script>
    function loadFile(event) {
        var output = document.getElementById('output');
        if (event.target.files && event.target.files[0]) {
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src);
            }
        }
    }
</script>
@endsection
