<!-- Footer -->
<footer class="bg-light text-muted mx-md-text-center footer-custom">

    <!-- Section: Links  -->

    <!-- Copyright -->
    <div class="text-center py-4 copyright-sm-area">
        <div class="container px-2">
            <div class="row align-items-center">
                <div class="col-12 col-lg-6 col-xl-6 text-md-star text-lg-start text-xl-start">
                    <span class="copyright-text">©
                        <script>
                            document.write(new Date().getFullYear())
                        </script> <a href="{{ url('/') }}"> {{ env('APP_NAME') }} All Rights Reserved.</a>
                    </span>
                </div>
                <div class="col-12 col-lg-6 col-xl-6 text-md-end">
                    <div
                        class="login-page-footer d-flex flex-row align-items-center justify-content-center justify-content-lg-end justify-content-xl-end">
                        <a class="mr-3" href="{{ url('terms-and-conditions') }}">Terms And Condition</a>
                        <a href="{{ url('privacy-policy') }}">Privacy Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright -->
</footer>
<!-- Footer -->

<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"
    integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous">
</script>
<script src="{{ asset('/') }}public/frontend/assets/jquery.min.js"></script>
<script src="{{ asset('/') }}public/frontend/assets/bootstrap/bootstrap.min.js"></script>
<script src="{{ asset('/') }}public/frontend/assets/slick.min.js"></script>
<script src="{{ asset('/') }}public/frontend/js/__header.js"></script>
<script src="{{ asset('/') }}public/frontend/js/__accordion.js"></script>
<script src="{{ asset('/') }}public/frontend/js/__scrollUp.js"></script>
<script src="{{ asset('/') }}public/frontend/js/__sideMenuLang.js"></script>
<script src="{{ asset('/') }}public/frontend/js/__mobileViewNavMenu.js"></script>
<script src="{{ asset('/') }}public/frontend/js/wow.min.js"></script>
<script src="{{ asset('/') }}public/frontend/js/image_preview.js"></script>
<script src="{{ asset('/') }}public/frontend/js/navbar.js"></script>
<script src="{{ asset('/') }}public/frontend/js/__animation.js"></script>
<script src="{{ asset('/') }}public/frontend/js/__apexChart.js"></script>
<script src="{{ asset('/') }}public/frontend/js/slider.js"></script>


<script src="{{ asset('/') }}public/frontend/assets/js/iziToast.js"></script>
<script src="{{ asset('public/frontend/js/v1/__g_footer.js') }}"></script>


<script src="{{ asset('/') }}public/frontend/js/__footer.js"></script>


<script src="{{ asset('/') }}public/backend/js/select2.min.js"></script>
{{-- <script src="{{ asset('/') }}public/frontend/js/driver/__driver.js"></script> --}}





<div id="fb-root"></div>
<!-- Your customer chat code -->

<script src="{{ asset('/') }}public/js/3.5.1.chart.min.js"></script>
<script src="{{ asset('/') }}public/backend/plugins/moment/moment.min.js"></script>
<script src="{{ asset('/') }}public/js/bootstrap-datetimepicker.min.js"></script>
{{-- <script src="{{ asset('/') }}public/frontend/js/driver/driver_dashboard.js"></script> --}}


<!-- jQuery -->
<script src="{{ asset('public/backend/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('public/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/backend/js/adminlte.min.js') }}"></script>
{{-- iziToast cdn --}}
<script src="{{ asset('public/frontend/assets/js/iziToast.js') }}"></script>

<script src="{{ asset('public/backend/') }}/js/select2.min.js"></script>

<script src="{{ asset('public/js/toastr.js') }}"></script>
{!! Toastr::message() !!}

@include('backend.partials.message')
@stack('script')

@yield('script')
</body>

</html>