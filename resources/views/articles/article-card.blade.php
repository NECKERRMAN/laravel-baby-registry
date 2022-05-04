<a href="articles/article/{{ $article->id }}" class="card rounded-md">
    <div class="card__img m-1">
        <img src="{{ $article->img_src }}" alt="product-img" class="rounded-md">
    </div>
    <div class="card__content rounded-md m-1">
        <p class="card__title">{{ $article->title }}</p>
        <p>€ {{ sprintf("%.2f", $article->price) }}</p>
    </div>  
</a>