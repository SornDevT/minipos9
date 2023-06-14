<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My App</title>
    @vite('resources/css/app.css')

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

      <!-- Core CSS -->
    <link rel="stylesheet" href="{{ url('assets/vendor/css/core-1.css')}}" class="template-customizer-core-css">
    <link rel="stylesheet" href="{{ url('assets/vendor/css/theme-default-1.css')}}" class="template-customizer-theme-css">
    <link rel="stylesheet" href="{{ url('assets/css/demo-1.css')}}">
    <link rel="stylesheet" href="{{ url('assets/css/font_lao.css')}}">


    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar-1.css')}}">
    
    <link rel="stylesheet" href="{{ url('assets/vendor/libs/apex-charts/apex-charts-1.css')}}">


</head>
<body>


    <div id="app-vue"></div>

    <script src="{{ url('assets/vendor/libs/jquery/jquery-1.js')}}"></script>
  <script src="{{ url('assets/vendor/libs/popper/popper-1.js')}}"></script>
  <script src="{{ url('assets/vendor/js/bootstrap-1.js')}}"></script>
  <script src="{{ url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar-1.js')}}"></script>

    @vite('resources/js/app.js')
</body>
</html>