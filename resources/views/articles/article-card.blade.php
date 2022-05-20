<div {{-- href="/articles/article/{{ $article->id }}" --}} class="card rounded-md justify-between">
    <div class="card__img m-1">
        <img src="{{ $article->img_src }}" alt="product-img" class="rounded-md">
    </div>
    <div class="card__content rounded-md m-1">
        <p class="card__title">{{ $article->title }}</p>
        <div class="flex justify-between items-center">
            <p>€ {{ sprintf("%.2f", $article->price) }}</p>
            @if (!in_array($article->id, $check_array))
            <form action="{{ route('visitor.add')}}" method="post">
                @csrf
                <input type="hidden" name="article_id" value="{{ $article->id }}">
                <button class="link-btn add-btn">{{ __('add')}}</button>
            </form>
            @endif
        </div>
    </div>  
</div>