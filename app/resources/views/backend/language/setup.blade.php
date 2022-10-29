@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')

    <div class="content-wrapper dashboard-wrapper mt-30">
        <!-- Main content -->
        <section class="content p-0 ">
            <h5 class="fm-poppins m-0 text-dark">{{ @$data['title'] }}</h5>
        <div class="row mt-2">
            <div class="col-lg-4">
             <div class="container-fluid table-filter-container border-radius-5 p-imp-30 ">

                    <div class="form-group">
                        <input type="hidden" name="id" id="id" value="{{ $data['language']->id }}">
                        <label for="">Choose File</label>
                        <div><select name="file_name" id="file_name" class="custom-select" onchange="get_translate_file()"
                                style="background-image: url(&quot;https://pipex.gainhq.com/images/chevron-down.svg&quot;);">
                                @foreach (scandir(base_path('resources/lang/'.userLocal().'/')) as $key => $value)
                                @php
                                    $explode = explode(".",$value);
                                @endphp
                                @if ($key>1)
                                    @if($explode[1]=='json')
                                        <option value="{{ $value }}" @if ($key==2) selected @endif>{{ Str::title(substr($value, 0, -5)) }}</option>
                                    @endif
                                @endif

                                @endforeach
                            </select>
                            <!---->
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-8 col-md-8" id="" style="min-height: 500px">
                <div class="container-fluid table-filter-container border-radius-5 p-imp-30 ">
                    <div id="translate_form"></div>

                </div>
            </div>
        </div>

            </div>
        </section>
    </div>



    <input type="hidden" name="translate_file" class="translate_file" value="{{ route('language.get_translate_file') }}">
@endsection
@section('script')
    @include('backend.partials.datatable')
    <script src="{{ asset('public/backend/js/language.js') }}"></script>
@endsection
