@include('frontend.includes.header')
<style>
    .page_404 {
        padding: 40px 0;
        background: #fff;
        font-family: 'Arvo', serif;
    }

    .page_404 img {
        width: 100%;
    }

    .four_zero_four_bg {

        background-image: url(https://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif);
        height: 400px;
        background-position: center;
    }


    .four_zero_four_bg h1 {
        font-size: 80px;
    }

    .four_zero_four_bg h3 {
        font-size: 80px;
    }

    .link_404 {
    background: linear-gradient(93.58deg, #a58cf6 0%, #645496 100%);
    color: #fff;
    transition: all 0.25s ease-in-out;
    padding: 0.45rem 1.2rem;
    font-size: 0.975rem;
    border-radius: 5px;
    box-shadow: 0 4px 4px rgb(0 0 0 / 20%);
}
.link_404:hover{
    color: #fff
}

    .err_page h4 {
        color: #6400ff;
        font-size: 14pt;
    }

    .contant_box_404 {
        margin-top: -50px;
    }

    .err_page_right h1 {
        font-family: 'Noto Sans', sans-serif;
        font-size: 70pt;
        margin: 0;
        color: #6400ff ;
    }

    .err_page_right p {
        font-size: 14pt;
        color: #737373;
    }

    .err_btn {
        background: #fff;
        border: 2px solid #6400ff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0px 8px 15px rgb(0 0 0 / 10%);
        cursor: pointer;
        font-size: 13pt;
        transition: background 0.5s;
    }

</style>

<div class=" new-main-content">
    <div class="ltn__contact-address-area mt-70 mb-50 ">
        <div class="container">
            <section class="page_404">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <h1 class="" style="color: #555658; font-size:90px;">Oops!</h1>
                            {{-- <h4>We can't seem to find the page you're looking for</h4> --}}
                            <h4>Error Code: @yield('code')</h4>
                            {{-- <p>Error Code: @yield('code')</p> --}}
                            <h3 class="h2" style="color: #555658;">
                                @yield('message')
                            </h3>

                            <p>@yield('details')</p>

                            <a href="{{ url('/') }}" class="link_404">Go to Home</a>
                        </div>
                        <div class="col-md-4">
                            <div class="error-img">
                                <img src="/public/images/error.gif" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@include('frontend.includes.contact_box')
@include('frontend.includes.footer')
