@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')

    <div class="content-wrapper dashboard-wrapper mt-30">
        {{-- <x-month-picker /> --}}
        <!-- Main content -->
        <section class="content p-0">
            <div class="container-fluid table-filter-container border-radius-5 p-imp-30">
                <div class="row align-items-center">
                    <div class="col-sm-12 mb-30">
                        <h5 class="fm-poppins m-0 text-dark">{{ @$data['title'] }}</h5>
                    </div>

                    <div class="col-lg-12">
                        @if (hasPermission('weekend_read'))
                            <div class="table-responsive pl-3 pr-3">
                                <table id="table" class="table datatable card-table mb-0 w-100  ">
                                    <thead>
                                        <tr>
                                            <th>{{ _trans('common.Id') }}</th>
                                            <th>{{ _trans('common.Name') }}</th>
                                            <th> {{ _trans('attendance.Weekend') }}</th>
                                            <th>{{ _trans('common.Status') }}</th>
                                            <th>{{ _trans('common.Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['weekends'] as $key => $day)
                                            <tr id="{{ $key }}">
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ ucfirst($day->name) }}</td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $day->is_weekend === 'no' ? 'success' : 'danger' }}">{{ ucfirst($day->is_weekend) }}</span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $day->status->class }}">{{ $day->status_id == 1 ? 'Active' : 'Inactive' }}</span>
                                                </td>
                                                <td>
                                                    @if (hasPermission('weekend_update'))
                                                        <button class="btn btn-sm btn-primary"
                                                            onclick="showWeekendModal('{{ route('weekendSetup.show', $day->id) }}')">
                                                            <i class="fa fa-pencil-alt"></i></button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
    {{-- Modal start --}}
    <div class="modal fade weekendEditModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="tab-content px-primary">
                    <div class="d-flex justify-content-between">
                        <h5 class="d-flex align-items-center text-capitalize mb-0 title tab-content-header mt-3">
                            {{ _translate('Update weekend') }}</h5>
                        <a href="#" class="close mt-3 close-btn-size" onclick="modalClose(this)">
                            <i class="bi bi-x"></i>
                        </a>
                    </div>
                    <hr>
                    <div class="content py-primary">
                        <form action="{{ route('weekendSetup.update') }}" enctype="multipart/form-data" method="post"
                            id="weekendEditModal">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="weekend_id" id="weekend_id">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">{{ _trans('common.Name') }}</label>
                                        <div class="col-sm-9">
                                            <div><input type="text" name="name" id="name" required="required"
                                                    placeholder="{{ _trans('common.Name') }}" autocomplete="off" readonly
                                                    class="form-control">
                                            </div>
                                            @if ($errors->has('name'))
                                                <div class="error">{{ $errors->first('name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">{{ _trans('leave.Is weekend') }}</label>
                                <div class="col-sm-9">
                                    <div>
                                        <select name="is_weekend" id="is_weekend" class="form-control select2"
                                            required="required" style="width: 100%">
                                            <option value="" disabled selected>{{ _trans('common.Choose One') }}
                                            </option>
                                            <option value="yes">{{ _trans('common.Yes') }}</option>
                                            <option value="no">{{ _trans('common.No') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-3 col-form-label">{{ _trans('common.Status') }}</label>
                                <div class="col-sm-9">
                                    <div>
                                        <select name="status_id" id="sticker_status_id" class="form-control select2"
                                            required="required" style="width: 100%">
                                            <option value="" disabled selected>{{ _trans('common.Choose One') }}
                                            </option>
                                            <option value="1">{{ _trans('common.Active') }}</option>
                                            <option value="2">{{ _trans('common.In-active') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right mt-3">
                                <button type="submit" class="btn btn-primary">{{ _trans('common.Update') }}</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal end --}}
@endsection
@section('script')
    @include('backend.partials.datatable')
@endsection
