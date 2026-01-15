<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Dashboard - Prototype</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
        .modal { transition: opacity 0.3s ease, visibility 0.3s ease; }
        .modal.hidden { opacity: 0; visibility: hidden; display: flex !important; }
    </style>
</head>
<body class="text-slate-900">
    <div class="min-h-screen py-10 px-4">
        @yield('content')
    </div>
    @stack('scripts')
</body>
</html>
