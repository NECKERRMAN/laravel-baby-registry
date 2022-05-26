<div class="p-4 rounded border-2 border-[#9EC4C5]">
    <h2>{{ $category->title }}</h2>
    <p>{{ ucfirst(__('store'))}}: {{ $category->store->name }}</p>
    <p class="mb-4">{{ count($category->articles) }} {{  __('articles')}}</p>
    <a class="link-btn" href="/admin/articles?category={{ $category->id }}">{{ __('to_articles')}}</a>
</div>
