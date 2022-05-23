<a href="/articles/article/{{ $article->id }}" class="card rounded-md justify-between">
    <div class="card__img m-1">
        <img src="/storage/{{ $article->img_int }}" alt="product-img" class="rounded-md">
    </div>
    <div class="card__content rounded-md m-1">
        <p class="card__title">{{ $article->title }}</p>
        <div class="flex justify-between items-center">
            <p>€ {{ sprintf("%.2f", $article->price) }}</p>
            @if (in_array($article->id, $id_array))
            <p class="py-2 px-4  rounded bg-green-100">{{ ucfirst(__('added')) }}</p>  
            @else
            <form action="{{ route('registry.addOne')}}" method="post">
                @csrf
                <input type="hidden" name="reg_id" value="{{ $reg_id }}">
                <input type="hidden" name="article_id" id="article_id" value="{{ $article->id }}">
                <button type="submit" class="link-btn add-btn">{{ ucfirst(__('add')) }}</button>
            </form>
            @endif
        </div>
    </div>  
</a>