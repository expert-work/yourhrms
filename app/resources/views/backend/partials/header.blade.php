@if (env('FILESYSTEM_DRIVER') == 'server')
    <link rel="shortcut icon" href="{{ Storage::disk('s3')->url(config('settings.app')['company_icon']) }}"
        type="image/x-icon" />
@elseif(env('FILESYSTEM_DRIVER') == 'local')
     <link rel="shortcut icon" href="{{Storage::url(config('settings.app')['company_icon']) }}" type="image/x-icon" />
@else
     <link rel="shortcut icon" href="{{Storage::url(config('settings.app')['company_icon']) }}" type="image/x-icon" />
@endif

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('public/backend/') }}/plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="{{ asset('public/backend/') }}/css/ionicons.min.css">
<!-- Tempusdominus Bootstrap 4 -->
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}
<link rel="stylesheet"
    href="{{ asset('public/backend/') }}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- iCheck -->
<link rel="stylesheet" href="{{ asset('public/backend/') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<link rel="stylesheet" href="{{ asset('public/backend/') }}/plugins/select2/css/select2.min.css">
<!-- JQVMap -->
<link rel="stylesheet" href="{{ asset('public/backend/') }}/plugins/jqvmap/jqvmap.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('public/backend/') }}/css/adminlte.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{ asset('public/backend/') }}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset('public/backend/') }}/plugins/daterangepicker/daterangepicker.css">

{{-- timepicker --}}
<link rel="stylesheet" href="{{ asset('public/backend/') }}/plugins/timepicker/timepicker.css">
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('public/css/toastr.css') }}">
<link rel="stylesheet" href="{{ asset('public/backend/') }}/plugins/summernote/summernote-bs4.min.css">
<link rel="stylesheet" href="{{ asset('public/backend/') }}/css/custom.css">
{{-- <link rel="stylesheet" href="{{url('public/css/main.css')}}"> --}}
<link rel="stylesheet" href="{{ url('public/css/mainbackend.css') }}">
<link href="{{ asset('public/backend/') }}/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/jquery-clockpicker.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.6.1/font/bootstrap-icons.min.css" />


<link rel="stylesheet" type="text/css" href="{{ url('public/cute-alert/cute-alert.css') }}">

<!-- plugins css -->
<link rel="stylesheet" href="{{ url('public/frontend/css') }}/plugins.css">
<!-- Main Stylesheet -->

<link rel="stylesheet" href="{{ asset('public/backend/') }}/css/loadSuperAdmin.css">
<link rel="stylesheet" href="{{ asset('public/backend/') }}/css/app_setting.css">
<link rel="stylesheet" href="{{ asset('public/backend/') }}/css/theme-switch.css">
