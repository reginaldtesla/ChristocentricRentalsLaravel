<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminAccountController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\NewsletterController as AdminNewsletterController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PageSettingsController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SiteSettingsController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\NewsletterUnsubscribeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ShopController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/{product:slug}', [ShopController::class, 'show'])->name('shop.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart/{key}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{key}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::post('/cart/quote', [CartController::class, 'quote'])->name('cart.quote');

Route::get('/compare', [CompareController::class, 'index'])->name('compare.index');
Route::post('/compare', [CompareController::class, 'store'])->name('compare.store');
Route::delete('/compare', [CompareController::class, 'clear'])->name('compare.clear');
Route::delete('/compare/{slug}', [CompareController::class, 'destroy'])->name('compare.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/pickup/{order}', [CheckoutController::class, 'pickup'])->name('checkout.pickup');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel/{order}', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
    Route::get('/checkout/demo/{order}', [CheckoutController::class, 'demoPay'])->name('checkout.demo-pay');
    Route::post('/checkout/demo/{order}', [CheckoutController::class, 'completeDemoPay'])->name('checkout.demo-pay.complete');
});

Route::get('/checkout/callback', [CheckoutController::class, 'callback'])->name('checkout.callback');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [PasswordResetController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'edit'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'update'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->prefix('account')->name('account.')->group(function () {
    Route::get('/profile', [AccountController::class, 'edit'])->name('profile');
    Route::put('/profile', [AccountController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [AccountController::class, 'updatePassword'])->name('profile.password');
    Route::get('/orders', [AccountController::class, 'orders'])->name('orders');
    Route::get('/orders/{orderNumber}', [AccountController::class, 'showOrder'])->name('orders.show');
});

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/help', [PageController::class, 'help'])->name('help');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('/newsletter', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{token}', NewsletterUnsubscribeController::class)->name('newsletter.unsubscribe');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login']);
    });

    Route::post('/logout', [AdminAuthController::class, 'logout'])->middleware('auth')->name('logout');

    Route::middleware(['auth', EnsureUserIsAdmin::class])->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('products', AdminProductController::class)->except(['show']);
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('newsletters', AdminNewsletterController::class)->except(['show']);
        Route::post('/newsletters/{newsletter}/send', [AdminNewsletterController::class, 'send'])->name('newsletters.send');

        Route::get('/subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');
        Route::get('/subscribers/export', [SubscriberController::class, 'export'])->name('subscribers.export');
        Route::delete('/subscribers/{subscriber}', [SubscriberController::class, 'destroy'])->name('subscribers.destroy');

        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');
        Route::post('/orders/{order}/items/{item}/return', [AdminOrderController::class, 'markItemReturned'])->name('orders.items.return');

        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');

        Route::get('/settings/contact', [SiteSettingsController::class, 'contact'])->name('settings.contact');
        Route::put('/settings/contact', [SiteSettingsController::class, 'updateContact'])->name('settings.contact.update');
        Route::get('/settings/newsletter', [SiteSettingsController::class, 'newsletter'])->name('settings.newsletter');
        Route::put('/settings/newsletter', [SiteSettingsController::class, 'updateNewsletter'])->name('settings.newsletter.update');
        Route::get('/settings/homepage', [SiteSettingsController::class, 'homepage'])->name('settings.homepage');
        Route::put('/settings/homepage', [SiteSettingsController::class, 'updateHomepage'])->name('settings.homepage.update');
        Route::get('/settings/footer', [SiteSettingsController::class, 'footer'])->name('settings.footer');
        Route::put('/settings/footer', [SiteSettingsController::class, 'updateFooter'])->name('settings.footer.update');
        Route::get('/settings/payments', [SiteSettingsController::class, 'payments'])->name('settings.payments');
        Route::get('/settings/rental', [SiteSettingsController::class, 'rental'])->name('settings.rental');
        Route::put('/settings/rental', [SiteSettingsController::class, 'updateRental'])->name('settings.rental.update');
        Route::get('/settings/pages', [PageSettingsController::class, 'index'])->name('settings.pages');
        Route::get('/settings/pages/{page}', [PageSettingsController::class, 'edit'])->name('settings.pages.edit');
        Route::put('/settings/pages/{page}', [PageSettingsController::class, 'update'])->name('settings.pages.update');
        Route::get('/settings/account', [AdminAccountController::class, 'edit'])->name('settings.account');
        Route::put('/settings/account', [AdminAccountController::class, 'update'])->name('settings.account.update');
    });
});
