<?php

use App\Http\Controllers\Admin\addStoreController;
use App\Http\Controllers\Admin\scrapeController;
use App\Http\Controllers\Articles\ArticleController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Registry\RegistryController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\WebhookController;
use App\Models\Registry;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// PAGE
Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/dashboard', [PageController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');

// User
Route::get('/my-account', [UserController::class, 'showUserDetails'])->middleware(['auth'])->name('user.account');

//Registry
// Secured registry routes
Route::group(['prefix' => 'registry', 'middleware' => 'auth'], function() {
    Route::get('all', [RegistryController::class, 'index'])->name('registry.all');
    Route::get('{id}/overview', [RegistryController::class, 'showOverview'])->name('registry.overview');
    Route::get('new', [RegistryController::class, 'new'])->name('registry.new');
    Route::post('new', [RegistryController::class, 'createRegistry'])->name('registry.create');
    Route::post('{id}/update', [RegistryController::class, 'update'])->name('registry.update');
    Route::get('{id}/all-articles', [RegistryController::class, 'allArticles'])->name('registry.addArticles');
    Route::post('{id}/delete-article', [RegistryController::class, 'deleteRegistryArticle'])->name('registry.deleteArticle');
    Route::get('{id}/filter-articles', [RegistryController::class, 'filterArticles'])->name('registry.filterArticles');
    Route::post('add-article', [RegistryController::class, 'addArticle'])->name('registry.addOne');
    Route::get('edit/{id}', [RegistryController::class, 'editRegistry'])->name('registry.edit');
});

// Unsecured registry routes
Route::prefix('registry')->group(function() {
    Route::get('{slug}', [RegistryController::class, 'locked'])->name('locked');
    Route::post('{slug}', [RegistryController::class, 'unlocked'])->name('unlocked');
});

// Articles
Route::get('/articles', [ArticleController::class, 'articles'])->name('articles.articles');
Route::get('/articles/article/{id}', [ArticleController::class, 'getArticle'])->name('articles.article');

// VISITOR
Route::post('/visitor/add-article', [ArticleController::class, 'add'])->name('visitor.add');
Route::post('/visitor/clear-cart', [ArticleController::class, 'clear'])->name('visitor.clear');
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::get('/checkout/succes', [CheckoutController::class, 'succes'])->name('checkout.success');
Route::post('/webhooks/mollie', [WebhookController::class, 'handle'])->name('webhooks.mollie');

// Admin
Route::group(['middleware' => ['auth', 'role:admin']], function(){
    Route::get('/admin/scrape', [scrapeController::class, 'show']);
    Route::post('/admin/scrape/store', [addStoreController::class, 'addStore'])->name('scrape.store');
    Route::post('/admin/scrape/categories', [scrapeController::class, 'scrapeCategories'])->name('scrape.categories');
    Route::post('/admin/scrape/articles', [scrapeController::class, 'scrapeArticles'])->name('scrape.articles');
    Route::get('/admin/articles', [ArticleController::class, 'all'])->name('admin.articles');
    Route::post('/admin/articles', [ArticleController::class, 'delete'])->name('admin.deleteArticle');
});

require __DIR__.'/auth.php';
