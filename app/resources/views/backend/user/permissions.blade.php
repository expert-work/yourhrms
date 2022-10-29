<thead>
<tr>
    <th scope="col">{{__('Module')}}/{{__('Sub-module')}}</th>
    <th scope="col">{{__('Permissions')}}</th>
</tr>
</thead>
<tbody>
@foreach($data['permissions'] as $permission)
    <tr>
        <td><span class="text-capitalize">{{__($permission->attribute)}}</span></td>
        <td>
            @foreach($permission->keywords as $key=>$keyword)
                <div class="custom-control custom-checkbox">
                    @if($keyword != "")
                        <input type="checkbox" class="custom-control-input read common-key" name="permissions[]"
                               value="{{$keyword}}"
                               id="{{$keyword}}" {{in_array($keyword, $data['role_permissions']) ? 'checked':''}}>
                        <label class="custom-control-label" for="{{$keyword}}">{{__($key)}}</label>
                    @endif
                </div>
            @endforeach
        </td>
    </tr>
@endforeach

</tbody>
