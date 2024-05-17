@extends('layouts.app')

@section('content')

<head>
    <title>Add Game</title>
    <style>
        form {
            max-width: 300px;
            margin: auto;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input,
        button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
        }
    </style>
</head>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manage Games</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        </div>
    </div>
    <form action="{{ route('games.manage') }}" method="POST">
        @csrf
        <label for="team_one_id">Team One ID:</label>
        <input type="number" id="team_one_id" name="team_one_id" required>

        <label for="team_two_id">Team Two ID:</label>
        <input type="number" id="team_two_id" name="team_two_id" required>

        <label for="game_type">Game Type:</label>
        <input type="text" id="game_type" name="game_type" required>

        <label for="match_status">Match Status:</label>
        <input type="text" id="match_status" name="match_status" required>

        <label for="kick_off_time">Kick Off Time:</label>
        <input type="text" id="kick_off_time" name="kick_off_time" required>

        <button type="submit">Save Game</button>
    </form>
    @if (session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div style="color: red;">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('games.delete') }}" method="POST">
        @csrf
        @method('delete')
        <label for="game_id">Game ID:</label>
        <input type="number" id="game_id" name="game_id" required>

        <button type="submit">Delete Game</button>
    </form>

</main>

@endsection