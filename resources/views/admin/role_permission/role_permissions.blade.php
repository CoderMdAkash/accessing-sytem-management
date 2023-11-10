<div class="page-header">
    <div class="page-title">
        <h4>Role Name : {{$role->role_name}}</h4>
    </div>
    <div class="page-btn">
        <a class="btn btn-added anchor" href="rolePermissions">
            Back To List
        </a>
    </div>
</div>

@csrf

<div class="card">
    <div class="card-body">
        <div class="table-top">
            <div class="wordset">
                <ul>
                    <li>
                        <x-admin.print-button />
                    </li>
                </ul>
            </div>
        </div>

        <div class="table-responsive">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <form class="form-load" type="create" action="{{ route('admin.rolePermissions.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="role_id" value="{{$role->id}}">
                    <table class="table datanew dataTable no-footer" id="DataTables_Table_0" role="grid"
                        aria-describedby="DataTables_Table_0_info">
                        <thead>
                            <tr role="row">
                                <th class="sorting">Sl</th>
                                <th class="sorting">Menu name</th>
                                <th class="sorting">Status</th>
                                <th class="text-center"> <label for="selectAll">Select All</label> <input @if(count($menus) == $total_menu_permission){{"checked"}}@endif id="selectAll" type="checkbox"></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($menus as $key => $item)
                                <tr class="odd">
                                    <td class="sorting_1">
                                        {{ $key + 1 }}
                                    </td>
                                    <td class="productimgname">
                                        <a href="javascript:void(0);">{{ $item->menu_name }}</a>
                                    </td>
                                    <td>@if($item->active == 1){{"Active"}}@else{{"Invactive"}}@endif</td>
                                    <td class="action text-center">
                                        <input @if(@$item->permission->id){{"checked"}}@endif type="checkbox" value="{{$item->id}}" name="menus[]" class="check-box-data">
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div>
                        <button class="btn btn-success mt-5" type="submit">Update</button>
                    </div>
                </form>
                
                
            </div>
        </div>

    </div>
</div>

<script>
    $('#selectAll').on('click', function(e){
        if ($(this).prop('checked')==true){ 
            $(".check-box-data").prop('checked', true);
        }else{
            $(".check-box-data").prop('checked', false);
        }
    });
    $(".check-box-data").on('click', function(e){
        let totalCheckbox = $('.check-box-data').length;
        let statusCount = 0;
        $(".check-box-data").each( function (){
            if($(this).prop('checked') == true){
                statusCount++;
            }else{
                statusCount--;
                
            }
            if(totalCheckbox == statusCount){
                $("#selectAll").prop('checked', true);
            }else{
                $("#selectAll").prop('checked', false);
            }
        });
        
    });

</script>

