<div class="row g-3 mb-3">
    <div class="col-md-6"><label class="form-label">Name</label><input name="name" class="form-control" value="{{ $product->name ?? '' }}" required></div>
    <div class="col-md-6"><label class="form-label">Brand</label><input name="brand" class="form-control" value="{{ $product->brand ?? '' }}"></div>
    <div class="col-md-4">
        <label class="form-label">Category</label>
        <select name="category_id" class="form-select">
            @foreach($categories as $cat)<option value="{{ $cat->id }}" @selected(($product->category_id ?? null)==$cat->id)>{{ $cat->name }}</option>@endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-select">
            @foreach(['male','female','unisex'] as $g)<option value="{{ $g }}" @selected(($product->gender ?? '')==$g)>{{ ucfirst($g) }}</option>@endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Activity</label>
        <select name="activity_type" class="form-select">
            @foreach(['running','walking','sports','casual','gym'] as $a)<option value="{{ $a }}" @selected(($product->activity_type ?? '')==$a)>{{ ucfirst($a) }}</option>@endforeach
        </select>
    </div>
    <div class="col-md-3"><label class="form-label">Price</label><input type="number" step="0.01" name="price" class="form-control" value="{{ $product->price ?? '' }}" required></div>
    <div class="col-md-3"><label class="form-label">Stock</label><input type="number" name="stock" class="form-control" value="{{ $product->stock ?? 0 }}" required></div>
    <div class="col-md-3"><label class="form-label">Size Range</label><input name="size_range" class="form-control" value="{{ $product->size_range ?? '' }}"></div>
    <div class="col-md-3"><label class="form-label">Image</label><input type="file" name="image" class="form-control"></div>
    <div class="col-12"><label class="form-label">Description</label><textarea name="description" class="form-control">{{ $product->description ?? '' }}</textarea></div>
    <div class="col-12 form-check"><input type="checkbox" name="is_featured" class="form-check-input" @checked($product->is_featured ?? false)><label class="form-check-label">Featured Product</label></div>
</div>
