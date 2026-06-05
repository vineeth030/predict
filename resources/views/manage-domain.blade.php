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

    <div class="card-glass mb-4">
        <h2 class="mb-3">Allowed Domains</h2>
        <table class="table table-striped align-middle">
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
    </div>

    <div class="card-glass">
        <h2 class="mb-3">Add Domain</h2>
        <form  action="{{ route('domain.add') }}" method="POST" class="row g-3">
        @csrf <!-- {{ csrf_field() }} -->
                <div class="col-md-6">
                    <label for="domain">Domain</label>
                    <input type="text" id="domain" name="domain" class="form-control" required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-danger">Add Domain</button>
                </div>
            </form>
    </div>

</main>

@endsection
