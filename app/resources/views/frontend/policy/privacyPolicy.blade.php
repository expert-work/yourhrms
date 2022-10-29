@extends('frontend.includes.master')
@section('title', @$data['title'])
@section('content')

    <div class="new-main-content">
        <div class="container">
            <div class="row py-5 mt-5">
                <div class="col-md-12">
                    <h3 style="font-size: 22pt; color:#555555 !important">{{ $data['show']->title }}</h3>
                <p>
                    {!! @$data['show']->content !!}
                </p>
                    {{-- <h3>Introduction</h3>
                    <p>
                        This 24HOURX Privacy Policy includes how we collect, use, disclose, transfer, and store your
                        personal data for the activities mentioned-below, including your visit to 24HOURX website that links
                        to this page, your attendance to our marketing and learning events both online and offline, and for
                        our business account management. Your choices and rights related to your personal data are
                        extensively described here. <br>
                        We are very expressive towards our firm commitment to help our users comprehend what information we
                        collect about them and what may happen to that information through this Privacy Policy.
                    </p>
                    <h3>Privacy Policy</h3>
                    <p>
                        Your privacy is valuable and 24HOURX values it. In this Privacy Policy, we describe the information
                        that we collect about you when you visit our website, 24hourx (the "Website") and use the services
                        available on the Website ("Services"), and how we use and disclose that information. <br>
                        If you have any questions or comments about the Privacy Policy, please contact us at info@24hourx.
                        This Policy is incorporated into and is subject to the 24HOURX Terms of Use, which can be accessed
                        at 24hourx /terms-and-condition. Your use of the Website and/or Services and any personal
                        information you provide on the Website remains subject to the terms of the Policy and 24HOURX 's
                        Terms of Use.

                    </p>
                    <h3>
                        TYPE OF INFORMATION WE COLLECT
                    </h3>
                    <h5>1. PERSONAL INFORMATION</h5>
                    <p>
                        "Personal information" is defined to include information that whether on its own or in combination
                        with other information may be used to readily identify or contact you such as: name, address, email
                        address, phone number etc. <br>
                        We collect personal information from Service Professionals offering their products and services.
                        This information is partially or completely accessible to all visitors using 24HOURX 's website or
                        mobile application, either directly or by submitting a request for a service. Service Professionals
                        and customers are required to create an account to be able to access certain portions of our
                        Website, such as to submit questions, participate in polls or surveys, to request a quote, to submit
                        a bid in response to a quote, and request information. - Service Professionals, if and when they
                        create and use an account with 24HOURX, will be required to disclose and provide to 24HOURX
                        information including personal contact details, bank details, personal identification details and
                        participate in polls or surveys or feedbacks etc. Such information gathered shall be utilized to
                        ensure greater customer satisfaction and help a customer satiate their needs. <br>
                        The type of personal information that we collect from you varies based on your particular
                        interaction with our Website or mobile application. <br>
                        <b>Consumers:</b> During the Account registration process and during your usage of 24HOURX 's
                        website or application, we will collect information such as your name, postal code, telephone email
                        address and other personal information. You also may provide us with your, mailing address, and
                        demographic information (e.g., gender, age, political preference, education, race or ethnic origin,
                        and other information relevant to user surveys and/or offers). We may also collect personal
                        information that you post in your Offer, Profile, Wants, or Feedback, and any comments or
                        discussions you post in any blog, chat room, or other correspondence site on the Website or mobile
                        application, or any comments you provide during dispute resolution with other users of the Website
                        or mobile application. <br>
                        Service Professionals: If you are a Service Professional and would like to post any information
                        about yourself, we will require you to register for an Account. During the Account registration
                        process, we will collect your business name, telephone number, address, zip code, travel
                        preferences, a description of your services, a headline for your profile, first and last name, and
                        email address. Other information may also be required to be provided to 24HOURX whilst you avail and
                        use 24HOURX ’s website or application. In addition, you may require to provide other content or
                        information about your business, including photographs and videos. <br>

                        24HOURX reserves the right to record the conversations between service professionals and consumers
                        facilitated by 24HOURX through the messaging/chat mechanism on the platform or the calls made
                        through the virtual numbers provided to safeguard the privacy of consumers and service
                        professionals. All the chat/messaging logs or call recordings can be used to but not limited to
                        monitor and prohibit abuse, safeguard the rights of consumers and service professionals, resolve
                        disputes. --}}
                    </p>
                </div>
            </div>
        </div>
    </div>

@endsection
