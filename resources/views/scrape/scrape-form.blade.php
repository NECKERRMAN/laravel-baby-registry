<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row py-5">
            <div class="col-sm-8 offset-sm-2">
                <h1>Scrape data</h1>
                <form action="{{ route('scrape.categories')}}" method="post">
                @csrf
                <div class="form-group">
                    <div>
                        <label for="shop">Webshop</label>
                    </div>
                    <select name="shop" id="shop" class="form-control">
                        @foreach ($shops as $key => $shop)
                            <option value="{{ $key }}">
                                {{ $shop }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group py-3">
                    <div>
                        <label for="url">
                            Collection URL
                        </label>
                        <input class="form-control" type="url" name="url" id="url" placeholder="e.g. http://bol.com/">
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        Scrape Categories!
                    </button>
                </div>
            </form>
            <table class="table table-striped">
                @foreach ($allCategories as $category)
                <tr>
                    <td>
                        {{ $category->title}}
                    </td>
                    <td>
                        <form method="POST" action="{{ route('scrape.articles') }}">
                            @csrf
                            <input type="hidden" name="category_id" value="{{ $category->id }}">
                            <input type="hidden" name="url" value="{{ $category->url}}">
                            <input type="hidden" name="shop" value="{{ $category->store_name }}">
                            <button type="submit" class="btn btn-warning">Scrape all articles</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>