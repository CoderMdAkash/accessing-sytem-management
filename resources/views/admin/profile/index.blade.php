<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Profile Setting</h4>
            <h6>Manage Profile Setting</h6>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <form class="form-load" type="create" action="{{ route('admin.profileSettings.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                        <h3 class="text-center">Profile Settings</h3>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" class="form-control" disabled value="{{$profile->email}}">
                        </div>
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Name" value="{{$profile->name}}">
                        </div>
                    
                        <div class="form-group">
                            <label class="required"> image</label>
                            <img id="profileImage" style="height: 100px;width:auto" src="@if($profile->avatar){{asset('frontend/images/profile/'.$profile->avatar)}}@endif">
                            <input type="file" name="image" class="form-control" oninput="profileImage.src=window.URL.createObjectURL(this.files[0])">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-submit me-2">Update Profile</button>
                        </div>

                    </form>
                </div>

                    <div class="col-lg-6 row">
                        <form class="form-load" type="create" action="{{ route('admin.profileSettings.store') }}" method="POST">
                            @csrf
                            <h3 class="text-center">Password Change</h3>
                            <div class="form-group input-group-sm">
                                <label for="">Old Password</label>
                                <input name="old_password" type="password" class="form-control " placeholder="Old Password" value="">
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="">New Password</label>
                                <input name="new_password" type="password" class="form-control " placeholder="New Password" value="">
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="">Re-New Password</label>
                                <input name="re_password" type="password" class="form-control " placeholder="Re New Password" value="">
                            </div>


                            <div class="form-group">
                                <button type="submit" class="btn btn-submit me-2">Change Password</button>
                            </div>
                        </form>
                    </div>

                    
                    
                </div>
            
        </div>
    </div>

</div>
