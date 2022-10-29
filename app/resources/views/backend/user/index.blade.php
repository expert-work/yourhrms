@extends('backend.layouts.app')
@section('title', @$data['title'])

@section('content')
    <div class="content-wrapper dashboard-wrapper mt-30 has-table-with-td">
        <!-- Main content -->
        <section class="content p-0">
            <div class="container-fluid table-filter-container border-radius-5 p-imp-30">
                <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap">
                    <h5 class="fm-poppins m-0 text-dark">{{ @$data['title'] }}</h5>
                    <div class="d-flex align-items-center flex-wrap">
                        @if (hasPermission('user_delete'))
                            <div class="form-group mb-2 mr-2">
                                {{-- <label for="">Select User Type</label> --}}
                                <select name="userTypeId" id="userTypeId" class="form-control select2">
                                    <option value="">{{ _trans('Select User Type') }}</option>
                                    @foreach ($data['roles'] as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="form-group mb-2 mr-2">
                                <input class="daterange-table-filter" type="text" name="daterange" placeholder="Search " />
                            </div> --}}

                            <div class="form-group mb-2 mr-2">
                                <button type="submit" class="btn btn-primary user_table_search_form">{{ _trans('common.Submit') }}</button>
                            </div>
                        @endif
                        @if (hasPermission('user_create'))
                            <a href="{{ route('user.create') }}" class="btn btn-primary mb-2">{{ _trans('common.Add User') }}</a>
                        @endif
                    </div>
                </div>
            <div class="row dataTable-btButtons">
                <div class="col-lg-12">
                    <table id="table" class="table card-table table-vcenter datatable mb-0 w-100 users_table">
                        <thead>
                            <tr>
                                <th>{{ _trans('common.Name') }}</th> 
                                <th>
                                    @if(settings('login_method')=='pin')
                                        {{ _trans('common.Pin') }}
                                    @else
                                    {{ _trans('common.Email') }}
                                    @endif
                                </th>
                                <th>{{ _trans('common.Phone') }}</th>
                                <th>{{ _trans('common.Designation') }}</th>
                                <th>{{ _trans('common.Department') }}</th>
                                <th>{{ _trans('common.Role') }}</th>
                                <th>{{ _trans('common.Shift') }}</th>
                                <th>{{ _trans('common.Status') }}</th>
                                <th>{{ _trans('common.Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
    </div>
    </section>
    </div>
    <input type="hidden" name="" id="user_data_url" value="{{ route('user.data_table') }}">
    <input type="hidden" name="user_id" id="staff_user_id"
        value="{{ auth()->user()->role->slug === 'staff' ? auth()->id() : '' }}">
@endsection
@section('script')
    @include('backend.partials.datatable')
@endsection
