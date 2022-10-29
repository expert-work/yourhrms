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
                        <form action="{{ $data['url'] }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="cus-label">{{ _trans('common.Subject') }}</label>
                                <input type="text" name="subject" class="form-control"
                                    placeholder="{{ _trans('common.Subject') }}" required>
                                <div class="error_show_subject"></div>
                            </div>
                            <div class="form-group pt-3">
                                <label class="cus-label">{{ _trans('common.Attach File') }}</label>
                                <input type="file" name="attach_file" class="form-control file_note"
                                    placeholder="{{ _trans('common.Title') }}" required>
                                <div class="error_show_attach_file"></div>
                            </div>
                            <div class="form-group d-none">
                                <div class="checkbox checkbox-primary">
                                    <input type="checkbox" name="show_to_customer" value="1"
                                        {{ @$data['edit']->show_to_customer == 33 ? 'checked' : '' }}
                                        id="show_to_customer">
                                    <label for="show_to_customer">{{ _trans('project.Visible to Customer') }}</label>
                                </div>
                            </div>
                            <div class="form-group text-right pt-3">
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
