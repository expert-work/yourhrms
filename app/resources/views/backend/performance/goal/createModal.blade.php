<div class="modal  fade lead-modal in" id="lead-modal" role="dialog" aria-labelledby="myLargeModalLabel"
    style="display: block;">
    <div class="modal-dialog modal-lg">
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
                <form action="{{ $data['url'] }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="" class="cus-label">{{ _trans('common.Subject') }}</label>
                                <input type="text" name="subject" class="form-control" required
                                    value="{{ old('subject') }}">
                                @if ($errors->has('subject'))
                                    <div class="error">{{ $errors->first('subject') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="cus-label">{{ _trans('performance.Goal Type') }}</label>
                                <select name="goal_type_id" class="form-control select2" required>
                                    @foreach ($data['goal_types'] as $goal_type)
                                        <option value="{{ $goal_type->id }}">{{ $goal_type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('goal_type_id'))
                                    <div class="error">{{ $errors->first('goal_type_id') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for=""
                                    class="cus-label">{{ _trans('performance.Target Achievement') }}</label>
                                <input type="text" name="target" class="form-control" required
                                    value="{{ old('target') }}">
                                @if ($errors->has('target'))
                                    <div class="error">{{ $errors->first('target') }}</div>
                                @endif
                            </div>
                        </div>



                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="cus-label">{{ _trans('common.Start Date') }}</label>
                                <input type="date" name="start_date" class="form-control" required
                                    value="{{ date('Y-m-d') }}">
                                @if ($errors->has('start_date'))
                                    <div class="error">{{ $errors->first('start_date') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="cus-label">{{ _trans('common.End Date') }}</label>
                                <input type="date" name="end_date" class="form-control" required
                                    value="{{ date('Y-m-d', strtotime('+1 month')) }}">
                                @if ($errors->has('end_date'))
                                    <div class="error">{{ $errors->first('end_date') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">{{ _trans('common.Description') }} </label>
                                <textarea class="form-control" name="description" rows="5"></textarea>
                            </div>
                        </div>

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
<script src="{{ asset('public/backend/js/common/select2.js') }}"></script>
