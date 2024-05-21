@extends('layouts.app')

@section('content')



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manage Games</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        </div>
    </div>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-container">
        <!-- Add Game Form -->
        <form action="{{ route('games.manage') }}" method="POST" class="form-inline">
            @csrf
            <div class="form-group mb-3">
                <label for="team_one_id">Team One ID:</label>
                <input type="number" id="team_one_id" name="team_one_id" class="form-control" >
            </div>
            <div class="form-group mb-3">
                <label for="team_two_id">Team Two ID:</label>
                <input type="number" id="team_two_id" name="team_two_id" class="form-control" >
            </div>
            <div class="form-group mb-3">
                <label for="game_type">Game Type:</label>
                <input type="text" id="game_type" name="game_type" class="form-control" >
            </div>
            <div class="form-group mb-3">
                <label for="match_status">Match Status:</label>
                <input type="text" id="match_status" name="match_status" class="form-control" >
            </div>
            <div class="form-group mb-3">
                <label for="kick_off_time">Kick Off Time:</label>
                <input type="text" id="kick_off_time" name="kick_off_time" class="form-control" >
            </div>
            <button type="submit" class="btn btn-primary">Add Game</button>
        </form>

        <!-- Edit Game Form -->
        <form action="{{ route('games.editgame') }}" method="POST" class="form-inline">
        @method('PUT')
                        @csrf
            <div class="form-group mb-3">
                <label for="game_id">Game ID:</label>
                <input type="number" id="game_id" name="game_id" class="form-control" >
            </div>
            <div class="form-group mb-3">
                <label for="team_one_id">Team One ID:</label>
                <input type="number" id="team_one_id" name="team_one_id" class="form-control" >
            </div>
            <div class="form-group mb-3">
                <label for="team_two_id">Team Two ID:</label>
                <input type="number" id="team_two_id" name="team_two_id" class="form-control" >
            </div>
            <div class="form-group mb-3">
                <label for="game_type">Game Type:</label>
                <input type="text" id="game_type" name="game_type" class="form-control" >
            </div>
            <div class="form-group mb-3">
                <label for="match_status">Match Status:</label>
                <input type="text" id="match_status" name="match_status" class="form-control" >
            </div>
            <div class="form-group mb-3">
                <label for="kick_off_time">Kick Off Time:</label>
                <input type="text" id="kick_off_time" name="kick_off_time" class="form-control" >
            </div>
            <button type="submit" class="btn btn-warning">Edit Game</button>
        </form>

        <!-- Delete Game Form -->
        <form action="{{ route('games.delete') }}" method="POST" class="form-inline">
            @csrf
            @method('DELETE')
            <div class="form-group mb-3">
                <label for="game_id">Game ID:</label>
                <input type="number" id="game_id" name="game_id" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-danger">Delete Game</button>
        </form>
    </div>

 
</main>

@endsection
