<div class="page-header">
    <div class="page-title">
        <h4>Role list</h4>
        <h6>View/Search Role</h6>
    </div>
    <div class="page-btn">
        
    </div>
</div>

@csrf

<div class="card">
    <div class="card-body">
        <div class="table-top">

            @include('components.admin.search')

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
                <table class="table datanew dataTable no-footer" id="DataTables_Table_0" role="grid"
                    aria-describedby="DataTables_Table_0_info">
                    <thead>
                        <tr role="row">
                            <th class="sorting text-center">Sl</th>
                            <th class="sorting text-center">Role name</th>
                            <th class="sorting text-center">Action</th>
                            <th class="sorting text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $key => $item)
                            <tr class="odd">
                                <td class="sorting_1 text-center">
                                    {{ $key + 1 }}
                                </td>
                                <td class="text-center">{{ $item->role_name }}</td>
                                <td class="action text-center">
                                    <a href="rolePermissions/{{$item->id}}" class="btn btn-info btn-sm anchor">Permissions</a>
                                </td>
                                <td class="text-center">@if($item->status == 1){{"Active"}}@else{{"Invactive"}}@endif</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                
                
            </div>
        </div>

    </div>
</div>

