<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Dashboard</title>
</head>
<body>
  <p>Daftar Mantri: </p>
  @foreach ($mantri as $user)
    <p>{{ $user->name }}</p>
  @endforeach 
  <form action="/logout" method="POST">
    @csrf
    <button type="submit">Logout</button>
  </form>
</body>
</html>