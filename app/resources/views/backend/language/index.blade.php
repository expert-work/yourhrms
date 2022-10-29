@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')

    <div class="content-wrapper dashboard-wrapper mt-30">
        <!-- Main content -->
        <section class="content p-0 ">
            <div class="container-fluid table-filter-container border-radius-5 p-imp-30 ">
                <!-- section 01  -->
                <div class="row align-items-center mb-15">
                    <div class="col-sm-6 col-12">
                        <h5 class="fm-poppins m-0 text-dark">{{ @$data['title'] }}</h5>
                    </div>

                    <div class="col-sm-6 col-12">
                        <button type="button" class="btn btn-sm btn-primary float-left-sm-device float-right"
                            data-toggle="modal" data-target="#exampleModalCenter">
                            {{ _trans('settings.Add Language') }}
                        </button>
                    </div>
                </div>

                <!-- section 02 -->
                <div class="row align-items-end mb-30 table-filter-data">

                </div>

                <!-- section 03  -->
                <div class="row dataTable-btButtons">

                    <div class="col-lg-12">
                        <table id="table"
                            class="table card-table table-vcenter datatable mb-0 w-100 language_datatable">
                            <thead>
                                <tr>
                                    <th>{{ _trans('common.Code') }}</th>
                                    <th>{{ _trans('common.Name') }}</th>
                                    <th>{{ _trans('common.Native') }}</th>
                                    <th>{{ _trans('common.RTL') }}</th>
                                    <th>{{ _trans('common.Status') }}</th>
                                    <th>{{ _trans('common.Action') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

    </div>
    </section>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"> {{ _trans('common.Add New') }}
                        {{ _trans('settings.Language') }}</h5>
                    <button type="button" class="close" onclick="modalClose(this)">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('language.add') }}" id="language_add_form" method="post">
                    <div class="modal-body text-center">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{ _trans('common.Add') }} {{ _trans('settings.Language') }} <span
                                    class="text-danger">*</span></label>
                            <select name="language_id" id="language" class="form-control">
                                <option value="">{{ _trans('common.Select') }} {{ _trans('settings.Language') }}
                                </option>
                                @foreach ($data['languages'] as $language)
                                    @php
                                        if (in_array($language->id, $data['hrm_languages'])) {
                                            continue;
                                        }
                                    @endphp
                                    <option value="{{ $language->id }}">{{ $language->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('language_id'))
                                <div class="error">{{ $errors->first('language_id') }}</div>
                            @endif
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ _trans('common.Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ _trans('common.Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <input type="text" hidden id="language_data_url" value="{{ route('dataTable.language') }}">
@endsection
@section('script')
    @include('backend.partials.datatable')
@endsection
