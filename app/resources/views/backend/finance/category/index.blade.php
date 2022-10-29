@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')

    <div class="content-wrapper dashboard-wrapper mt-30">

        <!-- Main content -->
        <section class="content p-0">
            <div class="container-fluid table-filter-container border-radius-5 p-imp-30">
                <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap">
                    <h5 class="fm-poppins m-0 text-dark">{{ @$data['title'] }}</h5>
                    <span>
                        @if (@$data['create'])
                            <a href="{{ @$data['create'] }}" class="btn btn-primary btn-sm"> <i
                                    class="fa fa-plus-square"></i> {{ _trans('common.Create') }}</a>
                        @endif

                    </span>
                </div>

                <div class="row dataTable-btButtons">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="table"
                                    class="table card-table table-vcenter datatable mb-0 w-100 {{ @$data['class'] }}">
                                    <thead>
                                        <tr>
                                            @foreach ($data['fields'] as $field)
                                            <th>{{ $field }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
    <input type="text" hidden id="{{ @$data['url_id'] }}"  value="{{ @$data['url'] }}">
@endsection
@section('script')
    @include('backend.partials.datatable')
@endsection
