<div class="card rounded-md justify-between">
    <div class="card__content rounded-md m-1">
        <p class="card__title">{{ $article->title }}</p>
        <p> Product code: <strong>{{ $article->product_code }}</strong></p>
        <p> Product store: {{ $article->store->name }}</p>
        <p> price: € {{ sprintf("%.2f", $article->price) }}</p>
        <div class="flex items-center mt-4">
            <a class="link-btn mr-4" href="{{ route('articles.article', ['id' =>  $article->id ])}}"> Detail</a>
            <form action="{{ route('admin.deleteArticle')}}" method="post">
                @csrf
                <input type="hidden" name="article_id" value="{{ $article->id }}">
                <button class="link-btn bg-red-500">{{ ucfirst(__('delete')) }}</button>
            </form>
        </div>
    </div>  
</div>