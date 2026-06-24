@extends('layouts.app')

@section('content')

<main class="app-content col-12 col-md-9 col-lg-10 px-md-4 ms-auto">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Users</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        </div>
    </div>
    <div class="card-glass">
        <h2 class="mb-4">Users List</h2>
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Verified</th>
                    <th>Designation</th>
                    <th>Employee ID</th>
                    <th>Fav Team</th>
                    <th>Image</th>
                    <th>Company Group ID</th>
                    <th>Old Rank</th>
                    <th>New Rank</th>
                    <th>Actions</th>
                    <th>Cards Collected</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->verified }}</td>
                        <td>{{ $user->designation }}</td>
                        <td>{{ $user->employee_id }}</td>
                        <td>{{ $user->fav_team }}</td>
                        <td>
                            @if($user->image)
                                <img src="{{ asset('storage/profile_images/' . $user->image) }}" alt="User Image" width="50">
                            @endif
                        </td>
                        <td>{{ $user->company_group_id }}</td>
                        <td>{{ $user->old_rank }}</td>
                        <td>{{ $user->new_rank }}</td>
                        <td>
                            <!-- Actions like edit, delete etc. -->
                        </td>
                        <td>
                            @forelse($user->cards_collected_by_country as $countryCards)
                                <div>{{ $countryCards['country_id'] }} - {{ $countryCards['card_ids'] }}</div>
                            @empty
                                <span class="text-muted">-</span>
                            @endforelse
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination links -->
        <div class="d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    </div>
</main>
@endsection
