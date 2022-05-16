<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Goutte\Client;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;

use stdClass;

class scrapeController extends Controller
{

    public function checkAdmin(){
        $user_role = auth()->user()->user_role;

        if($user_role !== 1){
            return redirect()->back();
        }
    }

    public function show(){
        $this->checkAdmin();

        $shops = [
            'dreambaby' => 'Dreambaby',
            'ikea' => 'Ikea Baby',
            'ptitchou' => 'P\'Tit Chou'
        ];

        $allCategories = Category::all();

        return view('scrape.scrape-form', compact('shops', 'allCategories'));
    }

    public function scrapeCategories(Request $req){
        switch($req->shop){
            case 'dreambaby':
                $this->scrapeDreamBabyCategories($req->url);
                break;
            case 'ikea':
                $this->scrapeIkeaCategories($req->url);
                break;
            case 'ptitchou':
                $this->scrapePtitCategories($req->url);
                break;
        }
    }

    public function scrapeArticles(Request $req){
        switch($req->shop){
            case 'dreambaby':
                return $this->scrapeDreambabyArticles($req);
                break;
            case 'ikea':
                $this->scrapeIkeaArticles($req);
                break;
            case 'ptitchou':
                $this->scrapePtitArticles($req);
                break;
        }
    }

    private function scrapeDreamBabyCategories($url){
        $client = new Client();
        $crawler = $client->request('GET', $url);
        // #categories_block_left .block_content
        $categories = $crawler->filter('.content .content_section .section_list ul li a')
            ->each(function($node){
                $title = $node->filter('.facetCountContainer .facetName')->text();
                $url = $node->attr('href');

                $cat = new stdClass();
                $cat->title = $title;
                $cat->url = $url;
                $cat->store_name = 'dreambaby';
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

    private function scrapeDreambabyArticles($req){
        $client = new Client();
        $crawler = $client->request('GET', $req->url);

        $articles = $this->scrapeDreamBabyData($crawler);
        dd($articles);
        $product_arr = [];
        foreach ($articles as $article) {
            $product = $this->scrapeDreamBabyProductData($article->url);
            $product_arr[] = $product;
        }

        foreach ($product_arr as $item) {
            $exists = Article::where('slug', $item->slug)->count();
            if($exists > 0) continue;

            $image_link = $this->storeImage($item, 'dreambaby');

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

        return view('scrape.scrape-result')->with(compact('articles'));
    }

    private function scrapeDreamBabyData($crawler){
       return $crawler->filter('.product')->each(function($node){
            $article = new stdClass();
            $article->url = $node->filter('.product_info a')->attr('href');
              return $article;
        });
    }

    private function scrapeDreamBabyProductData($url){
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $article = new stdClass();
        $article->title = $crawler->filter('.top.namePartPriceContainer h1.main_header')->text();
        $article->product_code = $crawler->filter('.top.namePartPriceContainer .sku')->text();
        $article->price = $crawler->filter('.product_price .price .value')->text();
        $article->description = $crawler->filter('.product_text')->text();
        $article->slug = $url;
        $article->img_src = $crawler->filter('.image_container #productMainImage')->first()->attr('src');

        return $article;
    }



    // IKEA
    private function scrapeIkeaCategories($url){
        $client = new Client();
        $crawler = $client->request('GET', $url);
        // #categories_block_left .block_content
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

    private function scrapeIkeaArticles($req){
        $client = new Client();
        $crawler = $client->request('GET', $req->url);

        $articles = $this->scrapeIkeaData($crawler);
        $product_arr = [];
        foreach ($articles as $article) {
           $product = $this->scrapeIkeaProductData($article->url);
           $product_arr[] = $product;
        }

        foreach ($product_arr as $item) {
           $exists = Article::where('slug', $item->slug)->count();
           if($exists > 0) continue;

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

       //dd($product_arr);
        return view('scrape.scrape-result')->with(compact('product_arr'));
    }

    private function scrapeIkeaData($crawler){
        $test = $crawler->filter('.plp-product-list__products .plp-fragment-wrapper .pip-product-compact')->each(function($node){
            $article = new stdClass();
            $article->url = $node->filter('a')->attr('href');
            return $article;
        });
        return $test;
    }

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


    // P'TIT CHOU
    private function scrapePtitCategories($url){
        $client = new Client();
        $crawler = $client->request('GET', $url);
        // #categories_block_left .block_content
        $categories = $crawler->filter('.row.products .product--excerpt')
            ->each(function($node){
                $title = $node->filter('.woocommerce-loop-category__title')->text();
                $url = $node->filter('a')->attr('href');

                $cat = new stdClass();
                $cat->title = $title;
                $cat->url = $url;
                $cat->store_name = 'ptitchou';
                $cat->store_id = '3';
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

    private function scrapePtitArticles($req){
        $client = new Client();
        $crawler = $client->request('GET', $req->url);

        $articles = $this->scrapePtitData($crawler);
        $product_arr = [];
        foreach ($articles as $article) {
            $product = $this->scrapePtitProductData($article->url);
            $product_arr[] = $product;
        }
        
        foreach ($product_arr as $item) {
            $exists = Article::where('slug', $item->slug)->count();
            if($exists > 0) continue;

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

        //dd($product_arr);
        return view('scrape.scrape-result', compact('product_arr'));
    }

    private function scrapePtitData($crawler){
       return $crawler->filter('.row.products .product--excerpt')->each(function($node){
            $article = new stdClass();
            $article->url = $node->filter('a')->attr('href');
            return $article;
        });
    }

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

    private function storeImage($item, $store){
        // Random ID, some pictures have the same name
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

