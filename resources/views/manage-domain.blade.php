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

    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Domain</th>
            <th>Company Group ID</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($emailExtensions as $extension)
            <tr>
                <td>{{ $extension->id }}</td>
                <td>{{ $extension->domain }}</td>
                <td>{{ $extension->company_group_id }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h2>Add Domain</h2>
    <form  action="{{ route('domain.add') }}" method="POST" class="form-inline">
    @csrf <!-- {{ csrf_field() }} -->
            <div class="form-group mb-3">
                <label for="domain">Domain</label>
                <input type="text" id="domain" name="domain" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="company_group_id">Company Group ID</label>
                <input type="number" id="company_group_id" name="company_group_id" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-danger">ADD Domain</button>
        </form>

</main>

@endsection
