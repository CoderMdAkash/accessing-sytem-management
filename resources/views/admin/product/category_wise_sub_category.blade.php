<label class="required">Select Sub Category</label>
<select class="form-control" name="subcategory_id" required>
    <option value="">Select Sub Category</option>
    @foreach ($subcategories as $item)
        <option value="{{$item->id}}">{{$item->subcategory_name}}</option>
    @endforeach
</select>