<?php

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OwnerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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

Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/thanks', [RegisterController::class, 'thanks'])->name('thanks');

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'Login']);

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verifyEmail');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/');
    })->middleware(['auth', 'signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'ご登録のメールアドレスに認証リンクを送信しました。メールをご確認ください。');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
});


// 利用者
Route::middleware(['auth', 'role:user', 'verified'])->group(function () {
    Route::get('/', [ShopController::class, 'index'])->name('index');
    Route::get('/detail/{shop_id}', [ShopController::class, 'detail'])->name('detail');
    Route::get('/search', [ShopController::class, 'search'])->name('search');

    Route::post('/shop/{shop}/favorite', [FavoriteController::class, 'addFavorite'])->name('shop.favorite.add');
    Route::delete('/shop/{shop}/favorite', [FavoriteController::class, 'removeFavorite'])->name('shop.favorite.remove');

    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage');
    Route::get('/edit/{id}', [MypageController::class, 'edit'])->name('editBooking');
    Route::post('/update/{id}', [MypageController::class, 'update'])->name('updateBooking');

    Route::post('/reservations/{shop_id}', [ReservationController::class, 'store'])->name('reservations.store');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservation.destroy');
    Route::get('/complete', [ReservationController::class, 'complete'])->name('complete');

    Route::get('/review/thanks/{shop_id}', [ReviewController::class, 'complete'])->name('reviewThanks');
    Route::get('/review/{reservation_id}', [ReviewController::class, 'index'])->name('review');
    Route::post('/review/{reservation_id}', [ReviewController::class, 'store'])->name('review.store');
    // Route::delete('/review/delete/{review_id}', [ReviewController::class, 'destroy'])->name('review.destroy');
});

//ゲストと認証済みユーザー共通のルート
Route::get('/', [ShopController::class, 'index'])->name('index');
Route::get('/detail/{shop_id}', [ShopController::class, 'detail'])->name('detail');
Route::get('/search', [ShopController::class, 'search'])->name('search');

// 管理者
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/index', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/create', [AdminController::class, 'createOwner'])->name('admin.create.owner');
    Route::get('/admin/owner', [AdminController::class, 'storeOwner'])->name('admin.store.owner');
});

// 店舗代表者
Route::middleware(['auth', 'role:shop_owner'])->group(function () {
    Route::get('/owner/index', [OwnerController::class, 'index'])->name('owner.index');
    Route::post('/owner/shop', [OwnerController::class, 'store'])->name('owner.store');
    Route::get('/owner/shop/{shop}/edit', [OwnerController::class, 'edit'])->name('owner.edit');
    Route::put('/owner/shop/{shop}', [OwnerController::class, 'update'])->name('owner.update');
    Route::get('/owner/reservations', [OwnerController::class, 'reservations'])->name('owner.reservations,index');
});
