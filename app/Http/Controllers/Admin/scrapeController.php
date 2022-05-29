<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Goutte\Client;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use stdClass;

class scrapeController extends Controller
{
    // Function to check if user is an Admin
    private function checkAdmin(){
        // Get current user role
        $user_role = Auth::user()->user_role;
        // If role != 1 (ADMIN) return back
        if($user_role !== 1){
            return redirect()->back();
        }
    }

    // Show the scrape fields/ page
    public function show(){
        $this->checkAdmin();

        // Set shops and keys
        $shops = [
            'babyco' => 'Babyenco',
            'ikea' => 'Ikea Baby',
            'ptitchou' => 'P\'Tit Chou'
        ];

        // Get all categories
        $allCategories = Category::all();

        return view('scrape.scrape-form', compact('shops', 'allCategories'));
    }

    // Scrape categories
    public function scrapeCategories(Request $req){
        // Switch based on shops with correct scraper
        switch($req->shop){
            case 'babyco':
                $this->scrapeBabyCoCategories($req->url);
                break;
            case 'ikea':
                $this->scrapeIkeaCategories($req->url);
                break;
            case 'ptitchou':
                $this->scrapePtitCategories($req->url);
                break;
        }
    }

    // Scrape articles
    public function scrapeArticles(Request $req){
        // Switch based on shops with correct scraper
        switch($req->shop){
            case 'babyenco':
                return $this->scrapeBabyCoArticles($req);
                break;
            case 'ikea':
                $this->scrapeIkeaArticles($req);
                break;
            case 'ptitchou':
                $this->scrapePtitArticles($req);
                break;
        }
    }

    // 1. Baby and Co
    // Scrape categories
    private function scrapeBabyCoCategories($url){
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $categories = $crawler->filter('#search_filters > aside:nth-child(1) .facet-type-checkbox li')
            ->each(function($node){
                $title = $node->filter('a')->text();
                $url = $node->filter('a')->attr('href');

                $cat = new stdClass();
                // Title contains number of products -> remove with mb_substr
                $cat->title = mb_substr($title, 0, -5);
                $cat->url = $url;
                $cat->store_name = 'babyenco';
                $cat->store_id = 1;
                return $cat; 
            });

        foreach($categories as $scrapeCategory){
            // Does it yet exist? 
            $exists = Category::where('url', $scrapeCategory->url)->count();
            if($exists > 0) continue;

            // Create or add category to db
            $categoryEntity = new Category();
            $categoryEntity->title = $scrapeCategory->title;
            $categoryEntity->url = $scrapeCategory->url;
            $categoryEntity->store_name = $scrapeCategory->store_name;
            $categoryEntity->store_id = $scrapeCategory->store_id;

            $categoryEntity->save();
        }    
    }

    // SCrape the articles and get correct url for every product
    private function scrapeBabyCoArticles($req){
        $client = new Client();
        $crawler = $client->request('GET', $req->url);

        // Scrape the page for every article url
        $articles = $this->scrapeBabyCoData($crawler);

        // Empty array to store the articles in
        $article_arr = [];
        // Loop over articles 
        foreach ($articles as $article) {
            // Go to detail page and fetch data
            $art = $this->scrapeBabyCoProductData($article->url);
            // FIll array with data
            $article_arr[] = $art;
        }

        // Loop over the article array 
        foreach ($article_arr as $item) {
            $exists = Article::where('slug', $item->slug)->count();
            if($exists > 0) continue;
            // Store the image in the storage
            $image_link = $this->storeImage($item, 'babyenco');

            // Create or add article to db
            $articleEntity = new Article();
            $articleEntity->title = $item->title;
            $articleEntity->slug = $item->slug;
            $articleEntity->product_code = $item->product_code;
            $articleEntity->description = $item->description;
            $articleEntity->price = $item->price;
            $articleEntity->img_src = $item->img_src;
            $articleEntity->img_int = $image_link;
            $articleEntity->category_id = $req->category_id;
            $articleEntity->store_id = 1;
            $articleEntity->save();
        }

        return view('scrape.scrape-result')->with(compact('product_arr'));
    }
    // Scrape the page for the article url
    private function scrapeBabyCoData($crawler){
       return $crawler->filter('div.js-product-miniature-wrapper')->each(function($node){
            $article = new stdClass();
            $article->url = $node->filter('article.product-miniature div.thumbnail-container a')->attr('href');
              return $article;
        });
    }

    // Get the article details
    private function scrapeBabyCoProductData($url){
        $client = new Client();
        $crawler = $client->request('GET', $url);
        // Created here to use substr to remove the hardcoded euro sign
        $price = $crawler->filter('#col-product-info > div.product_header_container.clearfix > div.product-prices.js-product-prices > div:nth-child(3) > div > span > span')->text();

        $article = new stdClass();
        $article->title = $crawler->filter('#col-product-info > div.product_header_container.clearfix > h1 > span')->text();
        $article->product_code = $crawler->filter('#col-product-info > div.product_header_container.clearfix > div.product-prices.js-product-prices > div.product-reference > span')->text();
        $article->price = floatval(substr($price, 5));
        $article->description = $crawler->filter('.product-information .rte-content.product-description')->text();
        $article->slug = $url;
        $article->img_src = $crawler->filter('#product-images-large > div.swiper-wrapper > div.product-lmage-large > img')->first()->attr('content');

        return $article;
    }



    // 2. IKEA
    // Scrape the page categories
    private function scrapeIkeaCategories($url){
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $categories = $crawler->filter('.plp-navigation-slot-wrapper .vn-carousel .vn__wrapper .vn__nav a')
            ->each(function($node){
                $title = $node->filter('.vn__nav__title')->text();
                $url = $node->attr('href');

                $cat = new stdClass();
                $cat->title = $title;
                $cat->url = $url;
                $cat->store_name = 'ikea';
                $cat->store_id = 2;
                return $cat; 
            });
        // Loop over the categories to store in DB
        foreach($categories as $scrapeCategory){
            // Does it yet exist? 
            $exists = Category::where('url', $scrapeCategory->url)->count();
            if($exists > 0) continue;

            // Create or add category to db
            $categoryEntity = new Category();
            $categoryEntity->title = $scrapeCategory->title;
            $categoryEntity->url = $scrapeCategory->url;
            $categoryEntity->store_name = $scrapeCategory->store_name;
            $categoryEntity->store_id = $scrapeCategory->store_id;


            $categoryEntity->save();
        }
        return view('scrape.scrape-form');

    }

    // Scrape the articles
    private function scrapeIkeaArticles($req){
        $client = new Client();
        $crawler = $client->request('GET', $req->url);
        // Scrape the article url
        $articles = $this->scrapeIkeaData($crawler);
        // Empty array to store the articles
        $article_array = [];
        // Loop over articles
        foreach ($articles as $article) {
            // fetch the correct details
           $art = $this->scrapeIkeaProductData($article->url);
           // Store the details
           $article_array[] = $art;
        }
        // Loop to add to db
        foreach ($article_array as $item) {
           $exists = Article::where('slug', $item->slug)->count();
           if($exists > 0) continue;
            // Store images
           $image_link = $this->storeImage($item, 'ikea');

            // Create or add category to db
            $articleEntity = new Article();
            $articleEntity->title = $item->title;
            $articleEntity->slug = $item->slug;
            $articleEntity->product_code = $item->product_code;
            $articleEntity->description = $item->description;
            $articleEntity->price = $item->price;
            $articleEntity->img_src = $item->img_src;
            $articleEntity->img_int = $image_link;
            $articleEntity->category_id = $req->category_id;
            $articleEntity->store_id = 2;
            $articleEntity->save();
       }

        return view('scrape.scrape-result')->with(compact('product_arr'));
    }

    // Scrape article URL
    private function scrapeIkeaData($crawler){
        $test = $crawler->filter('.plp-product-list__products .plp-fragment-wrapper .pip-product-compact')->each(function($node){
            $article = new stdClass();
            $article->url = $node->filter('a')->attr('href');
            return $article;
        });
        return $test;
    }

    // Scrape articles detail
    private function scrapeIkeaProductData($url){
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $article = new stdClass();
        $article->title = $crawler->filter('.pip-header-section .pip-header-section__title--big')->text();
        $article->product_code = $crawler->filter('.pip-product-identifier__value')->text();
        $article->description = $crawler->filter('.pip-product-summary__description')->text();
        $article->price = $crawler->filter('.pip-price__integer')->text();
        $article->slug = $url;
        $article->img_src = $crawler->filter('.pip-media-grid__media-container ')->first()->filter('.pip-media-grid__media-image .pip-aspect-ratio-image__image')->attr('src');
        return $article;
    }


    //3. P'TIT CHOU
    // SCrape categories
    private function scrapePtitCategories($url){
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $categories = $crawler->filter('.row.products .product--excerpt')
            ->each(function($node){
                $title = $node->filter('.woocommerce-loop-category__title')->text();
                $url = $node->filter('a')->attr('href');
                // Store the data in class object
                $cat = new stdClass();
                $cat->title = $title;
                $cat->url = $url;
                $cat->store_name = 'ptitchou';
                $cat->store_id = '3';
                return $cat; 
            });
        // Loop the categories to add to DB
        foreach($categories as $scrapeCategory){
            // Does it yet exist? 
            $exists = Category::where('url', $scrapeCategory->url)->count();
            if($exists > 0) continue;
            // Create or add category to db
            $categoryEntity = new Category();
            $categoryEntity->title = $scrapeCategory->title;
            $categoryEntity->url = $scrapeCategory->url;
            $categoryEntity->store_name = $scrapeCategory->store_name;
            $categoryEntity->store_id = $scrapeCategory->store_id;

            $categoryEntity->save();
        }
    }

    // SCrape the articles
    private function scrapePtitArticles($req){
        $client = new Client();
        $crawler = $client->request('GET', $req->url);
        // Scrape the url's
        $articles = $this->scrapePtitData($crawler);
        // Empty array to store articles
        $article_arr = [];
        // Loop over articles to scrape data
        foreach ($articles as $article) {
            // Scrape details
            $product = $this->scrapePtitProductData($article->url);
            $article_arr[] = $product;
        }
        // Looop over articles to store in DB
        foreach ($article_arr as $item) {
            $exists = Article::where('slug', $item->slug)->count();
            if($exists > 0) continue;
            // Store images
            $image_link = $this->storeImage($item, 'ptitchou');

            // Create or add category to db
            $articleEntity = new Article();
            $articleEntity->title = $item->title;
            $articleEntity->slug = $item->slug;
            $articleEntity->product_code = $item->product_code;
            $articleEntity->description = $item->description;
            $articleEntity->price = $item->price;
            $articleEntity->img_src = $item->img_src;
            $articleEntity->img_int = $image_link;
            $articleEntity->category_id = $req->category_id;
            $articleEntity->store_id = 3;
            $articleEntity->save();
        }

        return view('scrape.scrape-result', compact('product_arr'));
    }
    // Scrape the article url
    private function scrapePtitData($crawler){
       return $crawler->filter('.row.products .product--excerpt')->each(function($node){
            $article = new stdClass();
            $article->url = $node->filter('a')->attr('href');
            return $article;
        });
    }
    // Scrape the article data
    private function scrapePtitProductData($url){
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $article = new stdClass();
        $article->title = $crawler->filter('.product_title.entry-title')->text();
        $article->product_code = $crawler->filter('form input[name=gtm4wp_sku]')->attr('value');
        $article->price = $crawler->filter('form input[name=gtm4wp_price]')->attr('value');
        if($crawler->filter('#description')->count() > 0){
            $article->description = $crawler->filter('#description')->text();
        } else {
            $article->description = 'No description available...';
        }
        $article->slug = $url;
        $article->img_src = $crawler->filter('.wp-post-image')->first()->attr('src');
        return $article;
    }

    // Function to store images
    private function storeImage($item, $store){
        // Random ID, some pictures have the same name (ikea)
        $randomId = rand(0,99999);
        $info = pathinfo($item->img_src);
        $extension = Str::substr($info['extension'], 0, 3);

        $image = file_get_contents($item->img_src);
        $slug = Str::slug($item->title);
        $fileLocation = 'images/' . $store . '/' . $slug . '-' . $randomId . '.' . $extension;
        file_put_contents(storage_path('app/public/' . $fileLocation), $image);

        return $fileLocation;
    }



}

