<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>General Setting</h4>
            <h6>Manage General Setting</h6>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form class="form-load" type="create" action="{{ route('admin.generalSettings.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <input type="hidden" name="id" value="1">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Email</label>
                            <input value="{{$setting->email}}" name="email" type="email" class="form-control " placeholder="Email">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group input-group-sm">
                            <label for="">Phone Number</label>
                            <input value="{{$setting->phone}}" name="phone" type="text" class="form-control " placeholder="Phone Number">
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group input-group-sm">
                            <label for="">Facebook</label>
                            <input value="{{$setting->facebook}}" name="facebook" type="text" class="form-control" placeholder="Facebook Link">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group input-group-sm">
                            <label for="">Twitter</label>
                            <input value="{{$setting->twitter}}" name="twitter" type="text" class="form-control" placeholder="Twitter Link">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group input-group-sm">
                            <label for="">LinkIn</label>
                            <input value="{{$setting->linkedin}}" name="linkedin" type="text" class="form-control" placeholder="LinkIn Link">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group input-group-sm">
                            <label for="">Whats App</label>
                            <input value="{{$setting->whatapp}}" name="whats_app" type="text" class="form-control" placeholder="whats app Link">
                        </div>
                    </div>
                
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="required"> Logo</label>
                            <img id="websiteLogo" width="auto" height="80px" src="{{asset('frontend/logo/'.$setting->logo)}}">
                            <input type="file" name="logo" class="form-control" oninput="websiteLogo.src=window.URL.createObjectURL(this.files[0])">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="required">Favicon</label>
                            <img id="metaLogo" width="auto" height="80px" src="{{asset('frontend/logo/'.$setting->meta_logo)}}" alt="Favicon">
                            <input type="file" name="meta_logo" class="form-control" oninput="metaLogo.src=window.URL.createObjectURL(this.files[0])">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group input-group-sm">
                            <label for="">Address</label>
                            <textarea name="address" type="text" class="form-control " placeholder="Address">{{$setting->address}}</textarea>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-submit me-2">Submit</button>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>

</div>
