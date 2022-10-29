<form class="" action="{{ route('language.updateLangTerm') }}" method="post">
    @csrf
    <div class="">
        <input type="hidden" name="id" value="{{ $language->id }}">
        <input type="hidden" name="translatable_file_name" value="{{ $translatable_file_name }}">
        <div class="col-lg-12 mb-2">
            <div class="d-flex">
                <button class="btn btn-sm btn-primary float-left-sm-device float-right">Save </button>
            </div>
        </div>
    </div>

<table id="table" class="table table-striped table-bordered">

    <thead class="">
        <tr>
            <th class="text-center" scope="col">SL</th>
            <th class="text-center" scope="col">Key</th>
            <th class="text-center" scope="col">Value</th>

        </tr>
    </thead>
    <tbody>
        @php
            $i = 1
        @endphp

        @forelse($languages as $key => $value)

        <tr>
            <td>{{ $i }}</td>
            <td>{{ $key }}</td>
            <td>
                @if( is_array($value) )
                    <table class="table pt-0 shadow_none pt-0 pb-0">
                        <tbody>
                        @foreach($value as $sub_key => $sub_value)
                            <tr>
                                <td width="10%">{{ $sub_key }}</td>
                                <td>
                                    @if( is_array($sub_value) )
                                        <table class="table pt-0 shadow_none pt-0 pb-0">
                                            <tbody>
                                            @foreach($sub_value as $sub_sub_key => $sub_sub_value)
                                                <tr>
                                                    <td>{{ $sub_sub_key }}</td>
                                                    <td>
                                                       <div class="col-lg-12">
                                                            <input type="text" class="form-control" style="width:100%"
                                                                name="key[{{ $key }}][{{ $sub_key }}][{{ $sub_sub_key }}]" @isset($sub_sub_value) value="{{ $sub_sub_value }}"
                                                                @endisset>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @else

                                        <div class="col-lg-12">
                                           <input type="text" class="form-control" style="width:100%" name="key[{{ $key }}][{{ $sub_key }}]" @isset($sub_value)
                                                value="{{ $sub_value }}" @endisset>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="col-lg-12">
                       <input type="text" class="form-control" style="width:100%" name="key[{{ $key }}]" @isset($value) value="{{ $value }}"
                            @endisset>
                    </div>
                @endif
            </td>
        </tr>
        @php
            $i++
        @endphp
         @empty
            <tr>
                <td class="text-center" colspan="3">No Data Found</td>
            </tr>
         @endforelse

    </tbody>
</table>

</form>
