@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')
    <div class="content-wrapper dashboard-wrapper mt-30">
        <!-- Main content -->
        <section class="content p-0">
            <div class="container-fluid table-filter-container border-radius-5 p-imp-30">
                <div class="row align-items-center mb-15">
                    <div class="col-sm-6">
                        <h5 class="fm-poppins m-0 text-dark">{{ @$data['title'] }}</h5>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="content py-primary">
                                <div class="dataTable-btButtons">
                                    <table id="table" class="table card-table table-vcenter datatable mb-0 w-100">
                                        <thead>
                                        <tr>
                                            <td>{{ _trans('common.Title') }}</td>
                                            <td>{{ @$data['visit']->title }} <span class="badge badge-primary ml-2" style="background-color: #{{ str_replace('0xFF','',visitStatusColor($data['visit']->status))  }}">{{ _trans("common.".plain_text($data['visit']->status)) }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>{{ _trans('common.Description') }}</td>
                                            <td>{{ @$data['visit']->description }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ _trans('common.Date') }}</td>
                                            <td>{{ showDate(@$data['visit']->date) }}</td>
                                        </tr>
                                        </thead>
                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-xl-7 col-lg-8 pt-2">
                        <div class="order-track">
                           <fieldset>
                            <legend class="d-flex">
                                <h4>
                                    {{ _trans('visit.Schedules List') }} 
                                    @if($data['visit']->schedules->count() > 0)
                                    <button type="button" class="btn btn-primary"  onclick="showMapModal(`{{json_encode($data['schedules'])}}`)">
                                      <i class="fa fa-map"></i> {{ _trans('visit.View Map') }}
                                    </button>
                                    @endif
                                </h4>
                            </legend>
                                @forelse ( $data['visit']->schedules as $item )
                                    <div class="order-track-step">
                                        <div class="timeline-info">
                                            <p class="timeline-info__date">{{ @showDate($item->updated_at) }}</p>
                                            <p class="timeline-info__time">{{ @onlyTimePlainText($item->updated_at) }}</p>
                                        </div>
                                        <div class="order-track-status">
                                            <span class="order-track-status-dot"></span>
                                            <span class="order-track-status-line"></span>
                                        </div>
                                            
                                            <div class="order-track-text">
                                                <p class="order-track-text-stat">{{ $item->title }}</p>
                                            </div>
                                    </div>
                                @empty
                                    <h3>{{ _trans('visit.Schedule Not Created Yet') }}</h3>
                                @endforelse
                           </fieldset>

                        </div>
                    </div>
                    {{-- <div class="col-md-12 col-xl-5 col-lg-4 pt-2">
                        <div class="ltn__map-area">
                            <div class="ltn__map-inner">
                                <div id="map" style="height: 600px;"></div>
                                <div id="directions_panel"></div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </section>
    </div>
    @include('backend.modal.visit_details_map')
    <input type="text" hidden id="data_url" value="{{ @$data['url'] }}">
@endsection

@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key={{ @settings('google') }}"></script>
<script src="{{ asset('public/backend/js/__visit_details.js') }}"></script>
{{-- <script src="{{ asset('public/backend/js/__location_history.js') }}"></script> --}}
@endsection
