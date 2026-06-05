@extends('layouts.app')

@section('content')



<main class="app-content col-12 col-md-9 col-lg-10 px-md-4 ms-auto">
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
        <div class="card-glass mb-4">
            <h5 class="mb-3">Add Game</h5>
            <form action="{{ route('games.manage') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-6">
                    <label for="team_one_id">Team One ID:</label>
                    <input type="number" id="team_one_id" name="team_one_id" class="form-control" >
                </div>
                <div class="col-md-6">
                    <label for="team_two_id">Team Two ID:</label>
                    <input type="number" id="team_two_id" name="team_two_id" class="form-control" >
                </div>
                <div class="col-md-6">
                    <label for="game_type">Game Type:</label>
                    <input type="text" id="game_type" name="game_type" class="form-control" >
                </div>
                <div class="col-md-6">
                    <label for="match_status">Match Status:</label>
                    <input type="text" id="match_status" name="match_status" class="form-control" >
                </div>
                <div class="col-md-6">
                    <label for="stadium_name">Stadium Name:</label>
                    <input type="text" id="stadium_name" name="stadium_name" class="form-control" >
                </div>
                <div class="col-md-6">
                    <label for="kick_off_time">Kick Off Time:</label>
                    <input type="text" id="kick_off_time" name="kick_off_time" class="form-control" >
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Add Game</button>
                </div>
            </form>
        </div>

        <!-- Edit Game Form -->
        <div class="card-glass mb-4">
            <h5 class="mb-3">Edit Game</h5>
            <form action="{{ route('games.editgame') }}" method="POST" class="row g-3">
            @method('PUT')
                            @csrf
                <div class="col-md-4">
                    <label for="game_id">Game ID:</label>
                    <input type="number" id="game_id" name="game_id" class="form-control" >
                </div>
                <div class="col-md-4">
                    <label for="team_one_id">Team One ID:</label>
                    <input type="number" id="team_one_id" name="team_one_id" class="form-control" >
                </div>
                <div class="col-md-4">
                    <label for="team_two_id">Team Two ID:</label>
                    <input type="number" id="team_two_id" name="team_two_id" class="form-control" >
                </div>
                <div class="col-md-4">
                    <label for="game_type">Game Type:</label>
                    <input type="text" id="game_type" name="game_type" class="form-control" >
                </div>
                <div class="col-md-4">
                    <label for="match_status">Match Status:</label>
                    <input type="text" id="match_status" name="match_status" class="form-control" >
                </div>
                <div class="col-md-4">
                    <label for="stadium_name">Stadium Name:</label>
                    <input type="text" id="stadium_name" name="stadium_name" class="form-control" >
                </div>
                <div class="col-md-6">
                    <label for="kick_off_time">Kick Off Time:</label>
                    <input type="text" id="kick_off_time" name="kick_off_time" class="form-control" >
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-warning">Edit Game</button>
                </div>
            </form>
        </div>

        <!-- Delete Game Form -->
        <div class="card-glass">
            <h5 class="mb-3">Delete Game</h5>
            <form action="{{ route('games.delete') }}" method="POST" class="row g-3">
                @csrf
                @method('DELETE')
                <div class="col-md-6">
                    <label for="game_id">Game ID:</label>
                    <input type="number" id="game_id" name="game_id" class="form-control" required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-danger">Delete Game</button>
                </div>
            </form>
        </div>
    </div>

   

</main>

@endsection
