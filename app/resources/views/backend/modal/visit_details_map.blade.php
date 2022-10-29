<div class="modal fade" id="visitScheduleMap" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content data">
            <div class="modal-header text-center" style="background: #001f3f">
                <h5 class="modal-title text-white">{{ _trans('visit.Visit Map') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon text-white" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" />
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                    </span>
                  </button>
            </div>
            <div class="modal-body">
                <div class="row p-5">
                    <div class="col-md-12">
                        <div id="map" style="height: 500px;"></div>
                            <div class="mt-5" id="directions_panel"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
