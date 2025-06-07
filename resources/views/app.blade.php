<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ config('app.name') }}</title>

  <!-- Load assets via Vite -->
  @vite(['resources/js/app.js', 'resources/css/app.css'])

  <!-- Inertia head placeholder -->
  @inertiaHead
</head>
<body>
  <!-- Inertia mount point -->
  @inertia
</body>
</html>
