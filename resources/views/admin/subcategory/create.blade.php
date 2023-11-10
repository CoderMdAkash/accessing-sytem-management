<form class="form-load" type="create" action="{{ route('admin.subcategory.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Select Category</label>
                <select class="form-control" name="category_id" required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $item)
                        <option value="{{$item->id}}">{{$item->category_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Sub Category Name</label>
                <input type="text" class="form-control" name="subcategory_name" placeholder="Sub Category Name" required>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label class="required"> Image [Size: 120 * 120 px]</label>
                <img id="categoryimg" width="50%" width="50%">
                <input type="file" name="image" class="form-control" oninput="categoryimg.src=window.URL.createObjectURL(this.files[0])">
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


