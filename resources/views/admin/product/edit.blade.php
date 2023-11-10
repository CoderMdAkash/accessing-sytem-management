<form class="form-load" type="update" action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Product Name</label>
                <input type="text" class="form-control" name="product_name" placeholder="Product Name" required value="{{$product->product_name}}">
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Select Category</label>
                <select class="form-control" name="category_id" required id="category-id">
                    <option value="">Select Category</option>
                    @foreach ($categories as $item)
                        <option @if($product->category_id == $item->id){{"selected"}}@endif value="{{$item->id}}">{{$item->category_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group" id="sub_category">
                <label class="required">Select Sub Category</label>
                <select class="form-control" name="subcategory_id" required>
                    <option value="">Select Sub Category</option>
                    @foreach ($subcategories as $item)
                        <option @if($product->subcategory_id == $item->id){{"selected"}}@endif value="{{$item->id}}">{{$item->subcategory_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label class="required"> Image [Size: 350 * 350 px]</label>
                <div class="product-create-images"></div>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <textarea id="product-add" name="description">{{$product->description}}</textarea>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Status</label>
                <select class="form-control" name="status" id="">
                    <option @if($product->status == 1){{"selected"}}@endif value="1">Active</option>
                    <option @if($product->status == 2){{"selected"}}@endif value="2">Inactive</option>
                </select>
            </div>
        </div>
    </div>

    <x-admin.modal.create-btn />
    
</form>

<script>
    $(document).ready(function(){
        $("#category-id").change(function(e){
            e.preventDefault();
            let category_id = $(this).val();
            $.ajax({
                type: 'get',
                url: "{{url('category-wise-sub-category')}}/"+category_id,
                dataType: 'html',
                success: function (data) {
                    $("#sub_category").html(data);
                }
            });
        })
    })

    $('#product-add').summernote({height:200,minHeight:null,maxHeight:null,focus:true});
</script>
<script>
    $(function () {
        // $('.product-create-images').imageUploader();
        let preloaded = [
            @foreach ($product_images as $key => $img)
            {id: "{{$img->id}}", src: "{{asset('frontend/images/product/'.$img->image)}}"},
            @endforeach
        ];

        $('.product-create-images').imageUploader({
            preloaded: preloaded,
            imagesInputName: 'images',
            preloadedInputName: 'images',
            maxFiles: 10
        });
    });
</script>


