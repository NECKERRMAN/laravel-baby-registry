<?php

use App\Http\Controllers\Admin\scrapeController;
use App\Http\Controllers\Articles\ArticleController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Registry\RegistryController;
use App\Http\Controllers\User\UserController;
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

//Scrape
Route::get('/admin/scrape', [scrapeController::class, 'show']);
Route::post('/scrape/categories', [scrapeController::class, 'scrapeCategories'])->name('scrape.categories');
Route::post('/scrape/articles', [scrapeController::class, 'scrapeArticles'])->name('scrape.articles');

// User
Route::get('/my-account', [UserController::class, 'showUserDetails'])->middleware(['auth'])->name('user.account');

//Registry
Route::get('/my-lists', [RegistryController::class, 'index'])->middleware(['auth'])->name('my-lists');
Route::get('/registry/robin-27071998', [RegistryController::class, 'locked'])->name('locked');
Route::post('/registry/robin-27071998', [RegistryController::class, 'unlocked'])->name('unlocked');

// Articles
Route::get('/articles', [ArticleController::class, 'articles'])->name('articles.articles');
Route::get('/articles/article/{id}', [ArticleController::class, 'getArticle'])->name('articles.article');

require __DIR__.'/auth.php';
