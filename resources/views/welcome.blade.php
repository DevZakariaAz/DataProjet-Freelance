<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user" content="{{ auth()->user() }}">
    <title>DataPro</title>
    
    @vite(['resources/js/app.js','resources/css/app.css'])
</head>
<body>
    <div id="app" class=""></div>
    @vite('resources/js/utils/finisher-header.es5.min.js')
</body>
</html>