@extends('user.layouts.master') {{-- Make sure this matches your layout extension --}}

@section('content')
<div class="container" style="margin-top: 150px; margin-bottom: 50px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4">
                <h2 class="text-primary mb-4 text-center">Contact Us</h2>
                <form action="{{ route('user#contactSend') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Subject / Title</label>
                        <input type="text" name="contactTitle" class="form-control" placeholder="What is this regarding?" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Message</label>
                        <textarea name="contactMessage" rows="5" class="form-control" placeholder="Type your message here..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 text-white py-2" style="border-radius: 0 !important;">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
