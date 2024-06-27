@extends('layouts.app')

@section('content')
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #e5e5e5;
  color: black;
}
</style>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="btn-toolbar mb-2 mb-md-0">
        </div>
    </div>
    <body>
    <h1>Feedback List</h1>
    <table id="customers">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Question</th>
                <th>Answer</th>
                <th>created At</th>
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
</body>
 

</main>
@endsection