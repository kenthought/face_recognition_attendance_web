@extends('layouts.app')
@section('content')
@guest

    <b-jumbotron class="p-5">
        <template #header>Face Recognition Attendance Web</template>

        <template #lead>
            Web app for Face Recognition Attendance
        </template>

        <hr class="my-4">

        <p>A brief description of the Face Recognition Attendance App.</p>

        <b-button variant="primary" href="{{ route('login') }}">Login</b-button>
        <b-button variant="success" href="{{ route('register') }}">Register</b-button>
    </b-jumbotron>
@endguest
@auth
<div class="container-fluid">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
    <div class="row justify-content-center">
        <sidebar></sidebar>
        <div class="col-md-8">
            <router-view></router-view>
        </div>
    </div>
</div>
@endauth
@endsection