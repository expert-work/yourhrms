<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content data">
            <div class="modal-header text-center" style="background: #001f3f">
                <h5 class="modal-title text-white">Break Time</h5>
                <button type="button" class="close text-white break_close" onclick="modalClose(this)">
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

                        @php
                            $date1 = new DateTime($data->break_time);
                            $date2 = new DateTime($data->back_time);
                            $difference = $date1->diff($date2);
                        @endphp
                        <p>
                            <strong>{{ _translate('You have taken ') }}</strong> :
                            {{ $difference->format('%h hours %i minutes %s seconds') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
