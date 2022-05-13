<a href="/articles/article/{{ $article->id }}" class="card rounded-md justify-between">
    <div class="card__img m-1">
        <img src="{{ $article->img_src }}" alt="product-img" class="rounded-md">
    </div>
    <div class="card__content rounded-md m-1">
        <p class="card__title">{{ $article->title }}</p>
        <div class="flex justify-between items-center">
            <p>€ {{ sprintf("%.2f", $article->price) }}</p>
            <form action="/" method="post">
                @csrf
                <input type="hidden" name="article_id" id="article_id" value="{{ $article->id }}">
                <button type="submit" class="link-btn add-btn">Voeg toe</button>
            </form>
        </div>
    </div>  
</a>