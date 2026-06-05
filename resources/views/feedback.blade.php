@extends('layouts.app')

@section('content')

<main class="app-content col-12 col-md-9 col-lg-10 px-md-4 ms-auto">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="btn-toolbar mb-2 mb-md-0">
        </div>
    </div>
    <div class="card-glass">
        <h1 class="mb-3">Feedback List</h1>
        <table id="customers">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($feedbacks as $feedback)
                <tr>
                        <td>{{ $feedback->user_id }}</td>
                        <td>{{ $feedback->user_name }}</td>
                        <td>{{ $feedback->question }}</td>
                        <td>{{ $feedback->answer }}</td>
                        <td>{{ $feedback->created_at }}</td>
                        <td>{{ $feedback->updated_at}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
@endsection
