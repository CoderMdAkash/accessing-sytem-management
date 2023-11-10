<div class="page-header">
    <div class="page-title">
        <h4>User list</h4>
        <h6>View/Search User</h6>
    </div>
    <div class="page-btn">
        {{-- <a href="#" class="btn btn-added show-modal" hideModal="hide" modalTitle="Add Category" modalSize="md" url="category/create">
            <img src="{{ asset('admin/assets/img/icons/plus.svg') }}" class="me-1" alt="img">Add User
        </a> --}}
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
                        @include('components.admin.perpage')
                    </li>
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
                            <th class="sorting">Sl</th>
                            <th class="sorting">Name</th>
                            <th class="sorting">Email</th>
                            <th class="sorting">User Type</th>
                            <th class="sorting">Verified</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $paginate = $users;
                        @endphp

                        @foreach ($users as $key => $item)
                            <tr class="odd">
                                <td class="sorting_1">
                                    {{ $key + 1 }}
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    @if($item->role == 0)
                                        {{"User"}}
                                    @else
                                        {{$item->roles->role_name}}
                                    @endif
                                </td>
                                <td>
                                    @if($item->verified == 1)
                                        {{"Verified"}}
                                    @else
                                        {{"Not Verified"}}
                                    @endif
                                </td>
                                <td>
                                   <button class="btn btn-info show-modal" hideModal="hide" modalTitle="Change Role - [{{ $item->name }}]" modalSize="md" url="user/edit-role?user_id={{$item->id}}&role={{$item->role}}">Role</button>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                
                @include('components.admin.pagination')
                
            </div>
        </div>

    </div>
</div>

