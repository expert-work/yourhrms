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
                                <label for="" class="cus-label">{{ _trans('performance.Title') }}</label>
                                <input type="text" name="title" class="form-control" required
                                    value="{{ old('title') }}">
                                @if ($errors->has('title'))
                                    <div class="error">{{ $errors->first('title') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="cus-label">{{ _trans('project.Employee') }}</label>
                                <select name="user_id" class="form-control" id="custom_user" required>
                                </select>
                                @if ($errors->has('department_id'))
                                    <div class="error">{{ $errors->first('department_id') }}</div>
                                @endif
                            </div>
                        </div>



                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="cus-label">{{ _trans('common.Date') }}</label>
                                <input type="date" name="date" class="form-control" required
                                    value="{{ date('Y-m-d') }}">
                                @if ($errors->has('date'))
                                    <div class="error">{{ $errors->first('date') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="" class="cus-label">{{ _trans('common.Remarks') }} </label>
                                <textarea class="form-control" name="remarks" rows="5" required></textarea>
                            </div>
                        </div>



                    </div>
                    <div class="row">
                        @foreach ($data['competence_types'] as $competence_type)
                            <div class="col-md-12 mt-3">
                                <h6>{{ $competence_type->name }}</h6>
                                <hr class="mt-0">
                            </div>

                            @foreach ($competence_type->competencies as $competences)
                                <div class="col-6">
                                    {{ $competences->name }}
                                </div>
                                <div class="col-6">
                                    <fieldset id="demo1" class="rating">
                                        <input type="radio" id="star5_{{ $competences->id }}"
                                            name="rating[{{ $competences->id }}]" value="5" />
                                        <label class="full" for="star5_{{ $competences->id }}"
                                            title="Awesome - 5 stars"></label>
                                        <input type="radio" id="star4half_{{ $competences->id }}"
                                            name="rating[{{ $competences->id }}]" value="4.5" />
                                        <label class="half" for="star4half_{{ $competences->id }}"
                                            title="Pretty good - 4.5 stars"> </label>
                                        <input type="radio" id="star4_{{ $competences->id }}"
                                            name="rating[{{ $competences->id }}]" value="4" />
                                        <label class="full" for="star4_{{ $competences->id }}"
                                            title="Pretty good - 4 stars"></label>
                                        <input type="radio" id="star3half_{{ $competences->id }}"
                                            name="rating[{{ $competences->id }}]" value="3.5" />
                                        <label class="half" for="star3half_{{ $competences->id }}"
                                            title="Meh - 3.5 stars"></label>
                                        <input type="radio" id="star3_{{ $competences->id }}"
                                            name="rating[{{ $competences->id }}]" value="3" />
                                        <label class="full" for="star3_{{ $competences->id }}"
                                            title="Meh - 3 stars"></label>
                                        <input type="radio" id="star2half_{{ $competences->id }}"
                                            name="rating[{{ $competences->id }}]" value="2.5" />
                                        <label class="half" for="star2half_{{ $competences->id }}"
                                            title="Kinda bad - 2.5 stars"></label>
                                        <input type="radio" id="star2_{{ $competences->id }}"
                                            name="rating[{{ $competences->id }}]" value="2" />
                                        <label class="full" for="star2_{{ $competences->id }}"
                                            title="Kinda bad - 2 stars"></label>
                                        <input type="radio" id="star1half_{{ $competences->id }}"
                                            name="rating[{{ $competences->id }}]" value="1.5" />
                                        <label class="half" for="star1half_{{ $competences->id }}"
                                            title="Meh - 1.5 stars"></label>
                                        <input type="radio" id="star1_{{ $competences->id }}" checked
                                            name="rating[{{ $competences->id }}]" value="1" />
                                        <label class="full" for="star1_{{ $competences->id }}"
                                            title="bad time - 1 star"></label>
                                    </fieldset>
                                </div>
                            @endforeach
                        @endforeach
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
<script src="{{ asset('public/backend/js/pages/__commonUser.js') }}"></script>
