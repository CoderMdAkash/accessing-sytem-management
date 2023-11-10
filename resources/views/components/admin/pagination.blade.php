<div>
    @if($paginate)
    <div class="dataTables_paginate paging_numbers" id="DataTables_Table_0_paginate">
        {!! $paginate->links() !!} 
    </div>
    <div style="float: left;" class="dataTables_info mt-3" id="DataTables_Table_0_info" role="status" aria-live="polite"> {{$paginate->firstItem()}} - {{$paginate->lastItem()}} of {{$paginate->total()}} items</div>
    @endif
</div>
