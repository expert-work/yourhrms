<div class="modal  fade lead-modal in" id="lead-modal" role="dialog" aria-labelledby="myLargeModalLabel"
    style="display: block;">
    <div class="modal-dialog">
        <div class="modal-content data">
            <div class="modal-header text-center" style="background: #001f3f">
                <h5 class="modal-title text-white">{{ @$data['title'] }} </h5>
                <button type="button" class="close text-white" onclick="modalClose(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" />
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="row p-5">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="cus-label">{{ _trans('common.Department') }}</label>
                            <select id="department" class="form-control select2">
                                <option value="">{{ _trans('common.Department') }}</option>
                                <option value="0">{{ _trans('common.All') }}</option>
                                @foreach ($data['departments'] as $department)
                                    <option value="{{ $department->id }}">{{ $department->title }}</option>
                                @endforeach
                            </select>
                            <div class="error_show_department"></div>
                        </div>

                        <div class="form-group">
                            <label class="cus-label">{{ _trans('common.Month') }}</label>
                            <input type="date" class="form-control" id="month" />
                            <div class="error_show_month"></div>

                        </div>
                        <div class="form-group text-right">
                            <button type="button" onclick="makeGenerate()"
                                class="btn btn-primary pull-right"><b>{{ @$data['button'] }}</b></button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="select_department" value="{{ _trans('message.Select an department') }}">
<input type="hidden" id="error_department" value="{{ _trans('message.Please select a department') }}">
<input type="hidden" id="error_month" value="{{ _trans('message.Please select a month') }}">
<input type="hidden" id="__generate" value="{{ @$data['url'] }}">
<script src="{{ asset('public/backend/js/payroll/__salary_generate.js') }}"></script>
