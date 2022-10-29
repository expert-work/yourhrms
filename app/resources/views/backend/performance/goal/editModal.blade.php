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
                                    value="{{ @$data['edit']->subject }}">
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
                                        <option {{ @$data['edit']->goal_type_id == $goal_type->id ? ' selected' : '' }}
                                            value="{{ $goal_type->id }}">{{ $goal_type->name }}</option>
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
                                    value="{{ @$data['edit']->target }}">
                                @if ($errors->has('target'))
                                    <div class="error">{{ $errors->first('target') }}</div>
                                @endif
                            </div>
                        </div>



                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="cus-label">{{ _trans('common.Start Date') }}</label>
                                <input type="date" name="start_date" class="form-control" required
                                    value="{{ @$data['edit']->start_date }}">
                                @if ($errors->has('start_date'))
                                    <div class="error">{{ $errors->first('start_date') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="cus-label">{{ _trans('common.End Date') }}</label>
                                <input type="date" name="end_date" class="form-control" required
                                    value="{{ @$data['edit']->end_date }}">
                                @if ($errors->has('end_date'))
                                    <div class="error">{{ $errors->first('end_date') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="cus-label">{{ _trans('common.Status') }}</label>
                                <select name="status" class="form-control" required>
                                    <option value="24" {{ $data['edit']->status_id == 24 ? ' selected' : '' }}>
                                        {{ _trans('project.Not Started') }}</option>
                                    <option value="26" {{ $data['edit']->status_id == 26 ? ' selected' : '' }}>
                                        {{ _trans('project.In Progress') }} </option>
                                    <option value="27" {{ $data['edit']->status_id == 27 ? ' selected' : '' }}>
                                        {{ _trans('project.Completed') }}</option>
                                </select>
                                @if ($errors->has('month'))
                                    <div class="error">{{ $errors->first('month') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="cus-label">{{ _trans('common.Rating') }}</label>
                                <br>
                                <fieldset class="rating">
                                    <input type="radio" {{ $data['edit']->rating == 5 ? ' checked' : '' }}
                                        id="star5" name="rating" value="5" />
                                    <label class="full" for="star5" title="Awesome - 5 stars"></label>
                                    <input type="radio" {{ $data['edit']->rating == 4.5 ? ' checked' : '' }}
                                        id="star4half" name="rating" value="4.5" />
                                    <label class="half" for="star4half" title="Pretty good - 4.5 stars"> </label>
                                    <input type="radio" {{ $data['edit']->rating == 4 ? ' checked' : '' }}
                                        id="star4" name="rating" value="4" />
                                    <label class="full" for="star4" title="Pretty good - 4 stars"></label>
                                    <input type="radio" {{ $data['edit']->rating == 3.5 ? ' checked' : '' }}
                                        id="star3half" name="rating" value="3.5" />
                                    <label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                    <input type="radio" {{ $data['edit']->rating == 3 ? ' checked' : '' }}
                                        id="star3" name="rating" value="3" />
                                    <label class="full" for="star3" title="Meh - 3 stars"></label>
                                    <input type="radio" {{ $data['edit']->rating == 2.5 ? ' checked' : '' }}
                                        id="star2half" name="rating" value="2.5" />
                                    <label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                    <input type="radio"{{ $data['edit']->rating == 2 ? ' checked' : '' }}
                                        id="star2" name="rating" value="2" />
                                    <label class="full" for="star2" title="Kinda bad - 2 stars"></label>
                                    <input type="radio" {{ $data['edit']->rating == 1.5 ? ' checked' : '' }}
                                        id="star1half" name="rating" value="1.5" />
                                    <label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                    <input type="radio" {{ $data['edit']->rating == 1 ? ' checked' : '' }}
                                        id="star1" name="rating" value="1" />
                                    <label class="full" for="star1" title="bad time - 1 star"></label>

                                </fieldset>

                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="" class="cus-label">{{ _trans('project.Progress') }}
                                    <small id="progress_percentage"> {{ @$data['edit']->progress }}% </small> </label>
                                <input type="range" name="progress" class="form-control" min="0"
                                    max="100" oninput="progressValue(this.value)"
                                    onchange="progressValue(this.value)" value="{{ @$data['edit']->progress }}">
                                @if ($errors->has('progress'))
                                    <div class="error">{{ $errors->first('progress') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">{{ _trans('common.Description') }} </label>
                                <textarea class="form-control" name="description" rows="5">{{ @$data['edit']->description }}</textarea>
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
