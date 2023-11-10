<div class="dataTables_length" id="DataTables_Table_0_length">
    <label>
        <select id="perpage" class="custom-select custom-select-sm form-control form-control-sm">
            <option @if(@$perpage == 10) {{"selected"}} @endif value="10">10</option>
            <option @if(@$perpage == 25) {{"selected"}} @endif value="25">25</option>
            <option @if(@$perpage == 50) {{"selected"}} @endif value="50">50</option>
            <option @if(@$perpage == 100) {{"selected"}} @endif value="100">100</option>
        </select>
    </label>
</div>