<form class="form-load" type="create" action="{{ route('admin.user.role_update') }}" method="POST">
    @csrf
    <input type="hidden" name="user_id" value="{{$user_id}}">
    <div class="col-lg-12 col-sm-12 col-12">
        <div class="form-group">
            <label class="required">Role</label>
            <select class="form-control" name="role" id="">
                <option value="1">Select Role</option>
                @foreach ($roles as $item)
                    <option @if($user_role == $item->id){{"selected"}}@endif value="{{$item->id}}">{{$item->role_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <x-admin.modal.update-btn />
</form>