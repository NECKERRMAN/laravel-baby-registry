@extends('layouts.app')

@section('content')
    
<div class="page-wrapper">
    <div class="row py-5">
        <div class="col-sm-8 offset-sm-2">
            <h1>Scrape data</h1>
            <h2>1. Select correct store and enter category url</h2>
            
            <form action="{{ route('scrape.categories')}}" method="post">
                @csrf
                <div class="py-2 w-full">
                    <div class="w-1/2">
                        <label class="block" for="shop">Webshop</label>
                        <select name="shop" id="shop" class="w-full">
                            @foreach ($shops as $key => $shop)
                            <option value="{{ $key }}">
                                {{ $shop }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="py-2 w-full">
                    <div class="w-1/2">
                        <label class="block" for="url">
                            Collection URL
                        </label>
                        <input class="w-full rounded border-[#9EC4C5] border-1" type="url" name="url" id="url" placeholder="e.g. https://babyenco.be/nl/baby-s-feestmaaltijd">
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="link-btn">
                        Scrape Categories!
                    </button>
                </div>
            </form>
            <h2>2. Scrape articles</h2>
            <table class="mx-0 my-2 w-full">
                @foreach ($allCategories as $category)
                <tr class="bg-[#9ec4c526] border-2">
                    <td class="w-2/3">
                        {{ $category->id }} - {{ $category->title}}
                    </td>
                    <td class="w-1/3">
                        <form method="POST" action="{{ route('scrape.articles') }}">
                            @csrf
                            <input type="hidden" name="category_id" value="{{ $category->id }}">
                            <input type="hidden" name="url" value="{{ $category->url}}">
                            <input type="hidden" name="shop" value="{{ $category->store_name }}">
                            <button type="submit" class="link-btn w-full">Scrape all articles</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
@endsection