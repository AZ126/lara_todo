<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body,
        html {
            height: 100%;
        }

        .sticky-footer {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1030;
            background-color: #343a40;
            color: #fff;
            padding: 15px;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Sticky Top Footer -->
        <header class="sticky-top d-flex justify-content-between align-items-center bg-dark text-white p-3">
            <div class="d-flex align-items-center">
                <a href="{{ route('tasks.index') }}"><b class="text-white">Home</b></a>
                <a href="{{ route('user.notify') }}" class="px-3"><b class="text-white">Notifications</b></a>
                <p class="ml-5 pl-5"></p>
                <p class="mb-0 mx-5 pl-5 text-white text-center">Welcome {{ Auth::user()->name }}</p>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-danger me-3">Logout</button>
            </form>
        </header>
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
