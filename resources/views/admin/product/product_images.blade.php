<div class="row ">
    @foreach ($images as $item)    
        <div class="col-lg-3 col-sm-6 d-flex ">
            <div class="productset flex-fill active">
                <div class="productsetimg">
                    <img src="{{asset('frontend/images/product/'.$item->image)}}" alt="img">
                </div>
            </div>
        </div>
    @endforeach
</div>
