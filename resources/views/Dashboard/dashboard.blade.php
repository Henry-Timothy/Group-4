@extends('template')
@section('dashboard')
    <div class="card">
        <div class="d-flex align-items-end row">
            <div class="col-sm-7">
                <div class="card-body">
                    <h5 class="card-title text-primary">Hallo {{ $user->NamaDepan }} {{ $user->NamaBelakang }} as
                        {{ $user->NamaAkses }}! 🎉</h5>
                    <p class="mb-4">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras ut lacinia justo. Vestibulum viverra,
                        ligula fermentum posuere vestibulum, odio diam vulputate ex, id ornare lectus ipsum eu massa.
                    </p>
                </div>
            </div>
            <div class="col-sm-5 text-center text-sm-left">
                <div class="card-body pb-0 px-0 px-md-4">
                    <img src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}" height="140"
                        alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                        data-app-light-img="illustrations/man-with-laptop-light.png">
                </div>
            </div>
        </div>
    </div>
@endsection
