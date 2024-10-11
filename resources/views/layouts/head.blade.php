<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
     <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
     <title>Festinator</title>
     <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
      
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

     
   
     <link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css" >
     <!-- Fonts and icons -->
     <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
     <!-- Nucleo Icons -->
     <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
     <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
     <!-- Font Awesome Icons -->
     {{-- <script src="https://kit.fontawesome.com/42d5adcbca.js')}}" crossorigin="anonymous"></script> --}}
     <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
     <!-- CSS Files -->
     <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css?v=1.0.3') }}" rel="stylesheet" />

     
   <style>
.footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    z-index: 1030;
    background-color: #fff; /* Adjust to fit your design */
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
    align-content: center;
}

   </style>
   
     @stack('style')
   