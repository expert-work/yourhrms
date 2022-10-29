<div>
    <div class="form-group">
        <label for="exampleInputFile">{{ @$label }}</label>
        <div class="input-group image_preview_div" style="display:{{ $data['preview'] }}">
            <img src="{{ uploaded_asset('') }}" style="height: 200px; width:200px;"
                id="preview_image{{ $data['random_number'] }}" class="img-fluid img-thumbnail" alt="{{ @$label }}">
        </div>
        <input type="text" hidden id="accepted_fileType" value="{{ @$fileType }}">
        <input type="text" hidden id="no_image" value="{{ uploaded_asset('') }}">
        <div class="input-group">
            <div class="custom-file">
                <input type="file" @if($data['accepted_file_types']!=null) accept="{{ $data['accepted_file_types'] }}"
                    @endif class="custom-file-input select_file_upload"
                    data-random_number="{{ $data['random_number'] }}" name="{{ @$name }}" id="exampleInputFile">
                <label class="custom-file-label" id="custom-file-label{{ $data['random_number'] }}"
                    for="exampleInputFile">Choose file</label>
            </div>
        </div>
    </div>
</div>