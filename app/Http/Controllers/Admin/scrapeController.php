<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Goutte\Client;
use Illuminate\Http\Request;
use stdClass;

class scrapeController extends Controller
{
    public function show(){
        $shops = [
            'dreambaby' => 'Dreambaby',
            'ikea' => 'Ikea Baby'
        ];

        $allCategories = Category::all();

        return view('scrape.scrape-form', compact('shops', 'allCategories'));
    }

    public function scrapeCategories(Request $req){
        //dd($req->all());
        switch($req->shop){
            case 'dreambaby':
                $this->scrapeDreamBabyCategories($req->url);
                break;
            case 'ikea':
                $this->scrapeIkeaCategories($req->url);
                break;
        }
    }

    public function scrapeArticles(Request $req){
        switch($req->shop){
            case 'dreambaby':
                return $this->scrapeDreambabyArticles($req->url);
                break;
            case 'ikea':
                $this->scrapeIkeaArticles($req);
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

            $categoryEntity->save();
        }    
    }

    private function scrapeDreambabyArticles($url){
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $articles = $this->scrapeDreamBabyData($crawler);
        for ($i=0; $i <= 10 ; $i++) { 
            $crawler = $this->getNextFlaminogPage($crawler);
            if(!$crawler) break;
            $articles = array_merge($articles, $this->scrapeFlamingoPageData($crawler));
        }
        dd($articles);
        return view('scrape.scrape-result', compact('articles'));
    }

    private function scrapeDreamBabyData($crawler){
       return $crawler->filter('.product')->each(function($node){
            $article = new stdClass();
            $article->title = $node->filter('.product_info a .product_name')->text();
            $article->url = $node->filter('.product_info a')->attr('href');
            $article->price = $node->filter('.product_info .product_price .product_price .price .value')->text();
            $article->image = $node->filter('.product_info a .product_image .image img')->attr('src');
            return $article;
        });
    }

    private function getNextFlaminogPage( $crawler ){
        $linkTag = $crawler->filter('.pagination__ajax')->selectLink('Toon meer items');
        if($linkTag->count() <= 0) return;
        $link = $linkTag->link();
        
        if(!$link) return;

        $client = new Client();
        $nextCrawler = $client->click($link);

        return $nextCrawler;
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


            $categoryEntity->save();
        }
        return view('scrape-form');

    }

    private function scrapeIkeaArticles($req){
        $client = new Client();
        $crawler = $client->request('GET', $req->url);

        $articles = $this->scrapeIkeaData($crawler);
        $product_arr = [];
        foreach ($articles as $article) {
           $product = $this->scrapeProductData($article->url);
           $product_arr[] = $product;
        }

        foreach ($product_arr as $item) {
           $exists = Article::where('slug', $item->slug)->count();

           if($exists > 0) continue;

            // Create or add category to db
            $articleEntity = new Article();
            $articleEntity->title = $item->title;
            $articleEntity->slug = $item->slug;
            $articleEntity->product_code = $item->product_code;
            $articleEntity->description = $item->description;
            $articleEntity->price = $item->price;
            $articleEntity->img_src = $item->img_src;
            $articleEntity->category_id = $req->category_id;
            $articleEntity->store_id = 1;
            $articleEntity->save();
       }

       //dd($product_arr);
        return view('scrape.scrape-result', compact('product_arr'));
    }

    private function scrapeIkeaData($crawler){
        $test = $crawler->filter('.plp-product-list__products .plp-fragment-wrapper .pip-product-compact')->each(function($node){
            $article = new stdClass();
            $article->url = $node->filter('a')->attr('href');
            return $article;
        });
        return $test;
    }

    private function scrapeProductData($url){
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

    private function getNextIkeaPage( $crawler ){
        $linkTag = $crawler->filter('.plp-btn .plp-btn--small .plp-btn--secondary')->selectLink('Toon meer');
        if($linkTag->count() <= 0) return;
        $link = $linkTag->link();
        
        if(!$link) return;

        $client = new Client();
        $nextCrawler = $client->click($link);

        return $nextCrawler;
    }
}

