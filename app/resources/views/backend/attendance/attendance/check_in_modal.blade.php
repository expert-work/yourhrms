<div class="modal  fade lead-modal in" id="lead-modal" role="dialog" aria-labelledby="myLargeModalLabel"
    style="display: block;">
    <div class="modal-dialog">
        <div class="modal-content data">
            <div class="modal-header text-center" style="background: #001f3f">
                <h5 class="modal-title text-white">{{ @$data['title'] }} </h5>
                <a href="javascript:;" type="button" class="text-white" onclick="modalClose(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" />
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </a>
            </div>
            <div class="modal-body">
                <div class="row pb-4 text-align-center">
                    <div class="col-md-12">
                        <div class="form-group">
                            <p id="interim"></p>
                            <p id="final"></p>
                            <p class="text-center pb-2">
                                {{ _trans('common.Choose your option') }}
                            </p>
                            <div class="place-switch">
                                <div class="switch-field">
                                    
                                    <input type="radio" id="place_office" name="place_mode" value="1" checked="">
                                    <label for="place_office">
                                        <i class="fas fa-building"></i>
                                        <p class="on-half-expanded">Office</p>
                                    </label>

                                    <input type="radio" id="place_home" name="place_mode" value="0">
                                    <label for="place_home">
                                        <i class="fas fa-home"></i>
                                        <p class="on-half-expanded">Home</p>
                                    </label>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="timer-field pt-2 pb-2">
                                <h1 class="text-center">
                                    <div class="clock company_name_clock fs-16 clock" id="clock"
                                        onload="currentTime()">00:00:00</div>
                            </div>
                        </div>
                        @if (@$data['reason'][0] == 'L')
                           <div class="form-group w-50 ml-auto mr-auto">
                                <label class="cus-label float-left">{{ _trans('common.Late Reason') }}</label>
                                <textarea type="text" name="reason" id="reason" rows="3" class="form-control" required onkeyup="textAreaValidate(this.value, 'error_show_reason')">{{ old('reason') }}</textarea>
                                <small class="error_show_reason text-left text-danger">
                                    
                                </small>
                            </div>
                        @endif

                        <div class="form-group button-hold-container">
                            <button class="button-hold" id="button-hold">
                                <div>
                                    <svg class="progress" viewBox="0 0 32 32">
                                        <circle r="8" cx="16" cy="16" />
                                    </svg>
                                    <svg class="tick" viewBox="0 0 32 32">
                                        <polyline points="18,7 11,16 6,12" />
                                    </svg>
                                </div>
                            </button>
                        </div>

                        <input type="hidden" id="form_url" value="{{ @$data['url'] }}">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('public/backend/js/pages/__attendance.js') }}"></script>
