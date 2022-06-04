<form method="get" class="admin_filter">
    <label for="category" class="my-2">Categorie:</label>
    <div class="admin_filter__select">
        <select name="category" id="category" class="rounded-md mr-4">
            <option value="0">{{ __('pick_category')}}</option>
            @foreach ($categories as $category)
            <option {{ request()->category == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->title }}</option>
            @endforeach
        </select>
        <button class="link-btn sm:ml-0 ml-4" type="submit">{{ ucfirst(__('filter'))}}</button>
    </div>
</form>