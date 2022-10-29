<div class="modal  fade lead-modal in" id="lead-modal" role="dialog" aria-labelledby="myLargeModalLabel"
    style="display: block;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content data">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-0">

                                <div class="search-box">
                                    <input id="pac-input" class="controls" type="text"
                                        placeholder="Enter a location" />
                                    {{-- <button class="btn btn-primary">Location</button> --}}
                                </div>

                                <div class="dataTable-btButtons">
                                    <div class="col-lg-12">
                                        <div class="ltn__map-area">
                                            <div class="ltn__map-inner">
                                                <div id="map" style="height: 500px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                @if (@$data['url'])
                                    <div class="row  mt-20">
                                        <div class="col-md-12">
                                            <div class="text-right">
                                                <button class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

