<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container">
        
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success')}}
        </div>
    @endif

        <!-- isi konten -->
        @yield('content')
    </div>
</body>
</html>