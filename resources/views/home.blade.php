<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BEO Predict — Login</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
</head>
<body class="auth-page">
  <div class="auth-card">
    <div class="d-flex align-items-center gap-3 mb-3">
      <span class="brand-mark">B</span>
      <div>
        <h1 class="mb-0 fs-4">BEO Predict</h1>
        <p class="mb-0 text-white-50">Sign in to manage the tournament hub</p>
      </div>
    </div>

    @if (count($errors) > 0)
      <div class="alert alert-danger" role="alert">
        @foreach ($errors->all() as $error)
          {{ $error }} <br>
        @endforeach
      </div>
    @endif

    <form action="{{ route('login') }}" method="POST" class="mt-3">
      {{ csrf_field() }}
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <div class="input-group">
          <span class="input-group-text bg-transparent border-end-0 text-white-50"><i class="bi bi-envelope"></i></span>
          <input type="text" class="form-control border-start-0" name="email" id="email" placeholder="name@company.com" autocomplete="email">
        </div>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
          <span class="input-group-text bg-transparent border-end-0 text-white-50"><i class="bi bi-lock"></i></span>
          <input type="password" class="form-control border-start-0" name="password" id="password" placeholder="••••••••" autocomplete="current-password">
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Sign in</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
