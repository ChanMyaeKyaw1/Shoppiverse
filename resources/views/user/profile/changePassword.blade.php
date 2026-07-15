@extends('user/layouts/master')

@section('content')

    <!-- Begin Page Content -->
        <div class="container" style="margin-top: 140px; margin-bottom: 60px;">
            <div class="row justify-content-center">
            </div>
        </div>

        <!-- Page Heading -->
        <div class="">
            <div class="row">
                <div class="col-8 offset-2">
                    <div class="card">
                        <div class="card-body shadow">

                            <form action="{{ route('user#updatePassword') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Old Password</label>
                                    <input class="form-control @error('oldPassword') is-invalid @enderror" type="password" name="oldPassword" placeholder="Enter Old Password..." required>
                                    @error('oldPassword')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <input class="form-control @error('newPassword') is-invalid @enderror" type="password" name="newPassword" placeholder="Enter New Password..." required>
                                    @error('newPassword')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input class="form-control" type="password" name="newPassword_confirmation" placeholder="Enter Confirm Password..." required>
                                </div>

                                <button type="submit" class="btn btn-dark rounded-50 px-2.5 py-1.5">Change</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
