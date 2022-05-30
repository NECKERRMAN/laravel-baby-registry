<?php

namespace App\Exports;

use App\Models\Article;
use App\Models\Registry;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class RegistryExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }

    public function view(): View
    {
        // Get all registry articles
        $registry_articles = $this->registry->articles;
        // Empty array to store combined data
        $articles = [];
        $total = 0;
        // Loop over articles
        foreach($registry_articles as $article){
            $art = Article::find($article['id']);
            // Add full article, status and customer name to array
            $articles[] = [$art, 'status' => $article['status'], 'ordered_by' => $article['ordered_by']];
            // Update total price
            if($article['status'] === 1 ){
                $total += $art->price;
            }
        }

        return view('registry.export', [
                'articles' => $articles,
                'total' => $total
        ]);
    }
}
