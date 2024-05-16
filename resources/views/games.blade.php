@extends('layouts.app')

@section('content')

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Games</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        </div>
    </div>
    <p style="color:red">** Incase of match is  draw then Winning Team ID will be 0</p> 
    <p style="color:red">** Incase of a non scoring  match  then First Goal ID will be 0</p>
    <table class="table table-striped game-list ">
        <thead>
            <tr>
                <th>ID</th>
                <th>Team1 ID</th>
                <th>Team1 Name</th>
                <th>Team2 ID</th>
                <th>Team2 Name</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($games as $game)
            <tr>
                <td>{{ $game->id }}</td>
                <td>{{ $game->team_one_id }}</td>
                <td>{{ $game->teamOne->name ? $game->teamOne->name : null;}}</td>
                <td>{{ $game->team_two_id}}</td>
                <td>{{ $game->teamTwo->name ? $game->teamTwo->name : null;}}</td>
                <td>{{ $game->result }}</td>
                <td>
                    <form method="POST" action="{{ route('games.update', ['id' => $game->id]) }}">
                        @method('PUT')
                        @csrf
                        <label for="WinningTeam">Winning Team ID</label>
                        <input type="text" name="winning_team_id" value="{{ $game->winning_team_id }}" min="0">

                        <label for="Team1Goals">Team 1 Goals:</label>
                        <input type="number" name="team_one_goals" value="{{ $game->team_one_goals }}" min="0">

                        <label for="Team2Goals">Team 2 Goals:</label>
                        <input type="number" name="team_two_goals" value="{{ $game->team_two_goals }}" min="0">

                        <label for="First Goal Team">First Goal Team ID</label>
                        <input type="number" name="first_goal_team_id" value="{{ $game->first_goal_team_id }}" min="0">

                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</main>

@endsection