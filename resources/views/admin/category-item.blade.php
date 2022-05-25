<div class="p-4 rounded border-2 border-[#9EC4C5]">
    <h2>{{ $category->title }}</h2>
    <p>{{ count($category->articles) }} {{  __('articles')}}</p>
    <a class="link-btn" href="/admin/articles?filter_categories={{ $category->id }}">{{ __('to_articles')}}</a>
</div>
