<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | Dapoer MJ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #F8F4E1;
            color: #4E1F00;
        }

        .card {
            background-color: #fff7e6;
        }

        a {
            text-decoration: none;
        }

        .btn-primary {
            background-color: #4E1F00;
            border-color: #4E1F00;
        }

        .btn-primary:hover {
            background-color: #74512D;
            border-color: #74512D;
        }
    </style>
</head>
<body>
    <main>
        @yield('content')
    </main>
</body>
</html>
