<form class="form-load" type="create" action="{{ route('admin.roles.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Role Name</label>
                <input type="text" class="form-control" name="role_name" placeholder="Role Name" required>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Status</label>
                <select class="form-control" name="status" id="">
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                </select>
            </div>
        </div>
    </div>

    <x-admin.modal.create-btn />
    
</form>


