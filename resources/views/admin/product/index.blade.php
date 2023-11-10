<div class="page-header">
    <div class="page-title">
        <h4>Product list</h4>
        <h6>View/Search product</h6>
    </div>
    <div class="page-btn">
        <a href="#" class="btn btn-added show-modal" hideModal="hide" modalTitle="Add Product" modalSize="lg" url="product/create">
            <img src="{{ asset('admin/assets/img/icons/plus.svg') }}" class="me-1" alt="img">Add Product
        </a>
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
                            <th class="sorting">Product name</th>
                            <th class="sorting">Category name</th>
                            <th class="sorting">Sub Category name</th>
                            <th class="sorting">Images</th>
                            <th class="sorting">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $paginate = $products;
                        @endphp

                        @foreach ($products as $key => $item)
                            <tr class="odd">
                                <td class="sorting_1">
                                    {{ $key + 1 }}
                                </td>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->category_name }}</td>
                                <td>{{ $item->subcategory_name }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info show-modal" type="show" modalTitle="{{ $item->product_name }} - Images" modalSize="md" url="product/{{$item->id}}">Images</button>
                                </td>
                                <td>
                                    @if($item->status == 1){{"Active"}}@else{{"Invactive"}}@endif
                                </td>
                                <td class="action text-center">
                                    <a class="me-3 data-edit" data-id="{{ $item->id }}" url="product/{{ $item->id }}/edit" hideModal="hide" modalTitle="Edit Product" modalSize="lg">
                                        <img src="{{ asset('admin/assets/img/icons/edit.svg') }}" alt="img">
                                    </a>
                                    <a data-id="{{ $item->id }}" class="me-3 confirm-text delete" href="javascript:void(0);">
                                        <img src="{{ asset('admin/assets/img/icons/delete.svg') }}" alt="img">
                                    </a>
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


