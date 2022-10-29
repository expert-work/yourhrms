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
                        <form action="{{ $data['url'] }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="cus-label">{{ _trans('common.Expect Amount') }}</label>
                                <input type="number" name="expect_amount" class="form-control"
                                    value="{{ @$data['travel'] ? $data['travel']->expect_amount : old('amount') }}"
                                    disabled>
                            </div>

                            <div class="form-group">
                                <label class="cus-label">{{ _trans('common.Approve Amount') }}</label>
                                <input type="number" name="amount" class="form-control"
                                    value="{{ @$data['travel']->amount }}" required>
                            </div>
                            <div class="form-group">
                                <label class="cus-label">{{ _trans('common.Status') }}</label>
                                <select name="status" class="form-control" required>
                                    <option {{ @$data['travel']->status_id == 2 ? 'selected' : '' }} value="2">
                                        {{ _trans('common.Pending') }} </option>
                                    <option {{ @$data['travel']->status_id == 5 ? 'selected' : '' }} value="5">
                                        {{ _trans('common.Approved') }} </option>
                                    <option {{ @$data['travel']->status_id == 6 ? 'selected' : '' }} value="6">
                                        {{ _trans('common.Rejected') }} </option>
                                </select>

                            </div>
                            <div class="form-group text-right">
                                <button type="submit"
                                    class="btn btn-primary pull-right"><b>{{ @$data['button'] }}</b></button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('select').select2({
        placeholder: 'Choose one',
    })
</script>
