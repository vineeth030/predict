@extends('layouts.app')

@section('content')

<main class="app-content col-12 col-md-9 col-lg-10 px-md-4 ms-auto">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Games</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        </div>
    </div>
    <div class="card-glass mb-3">
      <p class="mb-1 text-warning">• If the match is a draw, set Winning Team ID to 0</p> 
      <p class="mb-0 text-warning">• For a non-scoring match, set First Goal ID to 0</p>
    </div>
    <div class="card-glass">
        <table class="table table-striped align-middle game-list">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Team1 ID</th>
                    <th>Team1 Name</th>
                    <th>Team2 ID</th>
                    <th>Team2 Name</th>
                    <th>Result</th>
                    <th>Update</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($games as $game)
                <tr>
                    <td>{{ $game->id }}</td>
                    <td>{{ $game->team_one_id }}</td>
                    <td>{{ optional($game->teamOne)->name }}</td>
                    <td>{{ $game->team_two_id}}</td>
                    <td>{{ optional($game->teamTwo)->name }}</td>
                    <td>{{ $game->result }}</td>
                    <td>
                        <form method="POST" action="{{ route('games.update', ['id' => $game->id]) }}" class="row g-2 align-items-end">
                            @method('PUT')
                            @csrf
                            <div class="col-lg-3">
                                <label for="WinningTeam">Winning Team ID</label>
                                <input type="text" class="form-control form-control-sm" name="winning_team_id" value="{{ $game->winning_team_id }}" min="0">
                            </div>

                            <div class="col-lg-2">
                                <label for="Team1Goals">Team 1 Goals:</label>
                                <input type="number" class="form-control form-control-sm" name="team_one_goals" value="{{ $game->team_one_goals }}" min="0">
                            </div>

                            <div class="col-lg-2">
                                <label for="Team2Goals">Team 2 Goals:</label>
                                <input type="number" class="form-control form-control-sm" name="team_two_goals" value="{{ $game->team_two_goals }}" min="0">
                            </div>

                            <div class="col-lg-3">
                                <label for="First Goal Team">First Goal Team ID</label>
                                <input type="number" class="form-control form-control-sm" name="first_goal_team_id" value="{{ $game->first_goal_team_id }}" min="0">
                            </div>

                            <div class="col-lg-2">
                                <button type="submit" class="btn btn-primary btn-sm w-100">Submit</button>
                            </div>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</main>

@endsection
