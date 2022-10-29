@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')
    <div class="content-wrapper dashboard-wrapper mt-30">
        <!-- Main content -->
        <section class="content p-0">
            @include('backend.partials.user_navbar')
            <div class="container-fluid table-filter-container border-radius-5 p-imp-30">
                <div class="row align-items-center mb-15">

                    <div class="col-md-2"></div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-sm-6">
                                <h5 class="fm-poppins m-0 text-dark">{{ @$data['title'] }}</h5>
                            </div>
                            <div class="col-sm-6">
                                @if(hasPermission('support_read'))
                                    <a href="{{ route('user.supportTicket') }}"
                                       class="btn btn-primary float-right float-left-sm-device btn-sm">
                                        Ticket list
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


                <form action="{{ route('supportTicket.store') }}"
                      enctype="multipart/form-data"
                      method="post" id="attendanceForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-2"></div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="" class="cus-label">Type</label>
                                    <select name="type_id" class="form-control select2" required="required">
                                        <option value="" disabled selected>{{ _trans('common.Choose One') }}</option>
                                        <option value="12">Open</option>
                                        <option value="13">Close</option>
                                    </select>
                                    @if ($errors->has('type_id'))
                                        <div class="error">{{ $errors->first('type_id') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="" class="cus-label">Priority</label>
                                    <select name="priority_id" class="form-control select2" required="required">
                                        <option value="" disabled selected>{{ _trans('common.Choose One') }}</option>
                                        <option value="14">High</option>
                                        <option value="15">Medium</option>
                                        <option value="16">Low</option>
                                    </select>
                                    @if ($errors->has('priority_id'))
                                        <div class="error">{{ $errors->first('priority_id') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="subject" class="cus-label">Subject</label>
                                    <input type="text" class="form-control" name="subject" id="subject"
                                           value="{{ old('subject') }}" required placeholder="Subject">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="description" class="cus-label">{{ _trans('common.Description') }}</label>
                                    <textarea class="form-control" name="description" placeholder="{{ _trans('common.Description') }}"
                                              rows="10"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div>
                                    <div class="custom-image-upload-wrapper">
                                        <div class="image-area d-flex">
                                            <img id="bruh"
                                                 src="{{ uploaded_asset(null) }}"
                                                 alt="" class="img-fluid mx-auto my-auto">
                                        </div>
                                        <div class="input-area"><label
                                                    id="upload-label"
                                                    for="appSettings_company_logo">
                                                Add attachment
                                            </label> <input
                                                    id="appSettings_company_logo"
                                                    name="attachment_file"
                                                    type="file"
                                                    class="form-control d-none">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="text-right">
                                    <button class="btn btn-primary ">Save</button>
                                </div>
                            </div>


                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
@section('script')
    <script src="{{ asset('public/frontend/assets/js/iziToast.js') }}"></script>
    <script src="{{url('public/backend/js/image_preview.js')}}"></script>


    <script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('public/ckeditor/config.js') }}"></script>
    <script src="{{ asset('public/ckeditor/styles.js') }}"></script>
    <script src="{{ asset('public/ckeditor/build-config.js') }}"></script>
    <script src="{{ asset('public/backend/js/ticket_ckeditor.js') }}"></script>

@endsection
