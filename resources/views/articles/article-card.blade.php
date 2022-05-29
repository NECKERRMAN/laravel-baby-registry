@if ($article['status'] !== 1)
    <div class="card rounded-md justify-between">
        <div class="card__img m-1">
            <img src="{{ $article[0]->img_src }}" alt="product-img" class="rounded-md">
        </div>
        <div class="card__content rounded-md m-1">
            <p class="card__title">{{ $article[0]->title }}</p>
            <p>{{ $article[0]->store->name }}</p>
            <a class="underline" href="{{ $article[0]->slug }}" target="_blank" rel="noreferrer noopener">{{ ucfirst(__('website'))}}</a>
            <div class="flex justify-between items-center">
                <p>€ {{ sprintf("%.2f", $article[0]->price) }}</p>
                    @if (!in_array($article[0]->id, $check_array))
                    <form action="{{ route('visitor.add')}}" method="post">
                        @csrf
                        <input type="hidden" name="article_id" value="{{ $article[0]->id }}">
                        <button class="link-btn add-btn">{{ __('add')}}</button>
                    </form>
                    @endif
            </div>
        </div>  
    </div>
@else 
    <div class="card rounded-md justify-between opacity-50">
        <div class="card__img m-1">
            <img src="{{ $article[0]->img_src }}" alt="product-img" class="rounded-md">
        </div>
        <div class="card__content rounded-md m-1">
            <p class="card__title">{{ $article[0]->title }}</p>
        </div>  
    </div>
@endif