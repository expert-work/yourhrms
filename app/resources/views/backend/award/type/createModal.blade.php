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
                <div class="row p-2">
                    <div class="col-md-12">
                        <form action="{{ $data['url'] }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label class="cus-label">{{ _trans('common.Name') }}</label>
                                <input type="text" class="form-control" name="name"
                                    placeholder="{{ _trans('common.Name') }}" required
                                    value="{{ @$data['edit'] ? $data['edit']->name : old('name') }}">

                            </div>
                            <div class="form-group">
                                <label class="cus-label">{{ _trans('common.Status') }}</label>
                                <select name="status" class="form-control select2" required>
                                    <option value="1"
                                        {{ @$data['edit'] ? ($data['edit']->status_id == 1 ? 'Selected' : '') : '' }}>
                                        {{ _trans('payroll.Active') }}</option>
                                    <option value="4"
                                        {{ @$data['edit'] ? ($data['edit']->status_id == 4 ? 'Selected' : '') : '' }}>
                                        {{ _trans('payroll.Inactive') }}</option>
                                </select>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit"
                                    class="btn btn-primary pull-right">{{ @$data['button'] }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('public/backend/js/common/select2.js') }}"></script>
