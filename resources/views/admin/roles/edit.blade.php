<form class="form-load" type="update" action="{{ route('admin.roles.update', $role->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Role Name</label>
                <input type="text" class="form-control" value="{{$role->role_name}}" name="role_name" placeholder="Role Name" required>
            </div>
        </div>

        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Status</label>
                <select class="form-control" name="status" id="">
                    <option @if($role->status == 1){{"selected"}}@endif value="1">Active</option>
                    <option @if($role->status == 2){{"selected"}}@endif value="2">Inactive</option>
                </select>
            </div>
        </div>
    </div>

    <x-admin.modal.update-btn />
    
</form>