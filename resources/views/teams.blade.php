@extends('layouts.app')

@section('content')

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Teams</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        </div>
    </div>

    <form method="POST" action="{{ route('teams.update') }}">
    @method('PUT')
                        @csrf

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Team Name</th>
                    <th>Group</th>
                   
                    <th>MGames Played</th>
                    <th>Wins</th>
                    <th>Draws</th>
                    <th>Losses</th>
                    <th>GF</th>
                    <th>GD</th>
                    <th>GA</th>
                    <th>Total Points</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teams as $team)
                <tr>
                    <td>{{ $team->id}}</td>
                    <td>{{ $team->name}}</td>
                    <td>{{ $team->group_id}}</td>
                  
                    <td><input type="number" name="teams[{{ $team->id }}][matches_played]" value="{{ $team->matches_played ?? 0 }}"></td>
                    <td><input type="number" name="teams[{{ $team->id }}][wins]" value="{{ $team->wins ?? 0 }}"></td>
                    <td><input type="number" name="teams[{{ $team->id }}][draws]" value="{{ $team->draws ?? 0 }}"></td>
                    <td><input type="number" name="teams[{{ $team->id }}][losses]" value="{{ $team->losses ?? 0 }}"></td>
                    <td><input type="number" name="teams[{{ $team->id }}][GF]" value="{{ $team->GF ?? 0 }}"></td>
                    <td><input type="number" name="teams[{{ $team->id }}][GD]" value="{{ $team->GD ?? 0 }}"></td>
                    <td><input type="number" name="teams[{{ $team->id }}][GA]" value="{{ $team->GA ?? 0 }}"></td>
                    <td><input type="number" name="teams[{{ $team->id }}][points]" value="{{ $team->points ?? 0 }}"></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>

</main>
@endsection