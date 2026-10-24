<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\AdminAnalyticsController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminInventoryController;
use App\Http\Controllers\Admin\AdminMarketingController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminSubscriberController;
use App\Http\Controllers\NewsletterSubscriptionController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CheckoutController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', [StoreController::class, 'index'])->name('store.home');
Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AccountController::class, 'loginForm'])->name('login');
    Route::post('/login', [AccountController::class, 'login'])->middleware('throttle:5,1')->name('login.store');
    Route::get('/register', [AccountController::class, 'registerForm'])->name('register');
    Route::post('/register', [AccountController::class, 'register'])->middleware('throttle:5,1')->name('register.store');
    Route::get('/auth/google/redirect', [AccountController::class, 'redirectToGoogle'])
        ->middleware('throttle:10,1')
        ->name('google.redirect');
    Route::get('/auth/google/callback', [AccountController::class, 'handleGoogleCallback'])
        ->middleware('throttle:10,1')
        ->name('google.callback');
    Route::post('/demo-login', [AccountController::class, 'demoLogin'])
        ->middleware('throttle:10,1')
        ->name('demo.login');
});
Route::middleware('auth')->group(function (): void {
    Route::get('/account', [AccountController::class, 'show'])->name('account.show');
    Route::put('/account/profile', [AccountController::class, 'updateProfile'])->name('account.profile.update');
    Route::put('/account/password', [AccountController::class, 'updatePassword'])->name('account.password.update');
    Route::post('/logout', [AccountController::class, 'logout'])->name('logout');
});
Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::prefix('admin')->name('admin.')->middleware([EnsureUserIsAdmin::class])->group(function (): void {
    Route::get('/inventory-report.csv', [AdminDashboardController::class, 'export'])->name('report.export');
    Route::get('/inventory/export', [AdminInventoryController::class, 'exportCsv'])->name('inventory.export');
    Route::post('/inventory/bulk-stock', [AdminInventoryController::class, 'bulkStock'])->name('inventory.bulk');
    Route::get('/inventory', [AdminInventoryController::class, 'index'])->name('inventory.index');
    Route::patch('/inventory/{product}/stock', [AdminInventoryController::class, 'updateStock'])->name('inventory.update-stock');
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/export', [AdminCategoryController::class, 'exportCsv'])->name('categories.export');
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/export', [AdminProductController::class, 'exportCsv'])->name('products.export');
    Route::post('/products/bulk-action', [AdminProductController::class, 'bulkAction'])->name('products.bulk');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::post('/products/batch', [AdminProductController::class, 'storeBatch'])->name('products.batch');
    Route::post('/products/upload-image', [AdminProductController::class, 'uploadImage'])->name('products.upload-image');
    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::patch('/products/{product}/toggle-status', [AdminProductController::class, 'toggleStatus'])->name('products.toggle');
    Route::patch('/products/{product}/toggle-new', [AdminProductController::class, 'toggleNew'])->name('products.toggle-new');
    Route::post('/products/{product}/duplicate', [AdminProductController::class, 'duplicate'])->name('products.duplicate');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [AdminOrderController::class, 'store'])->name('orders.store');
    Route::get('/orders-export', [AdminOrderController::class, 'exportCsv'])->name('orders.export');
    Route::post('/orders/bulk-action', [AdminOrderController::class, 'bulkAction'])->name('orders.bulk');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('/subscribers', [AdminSubscriberController::class, 'index'])->name('subscribers.index');
    Route::delete('/subscribers/{subscriber}', [AdminSubscriberController::class, 'destroy'])->name('subscribers.destroy');
    Route::get('/customers/export', [AdminCustomerController::class, 'exportCsv'])->name('customers.export');
    Route::post('/customers/bulk-action', [AdminCustomerController::class, 'bulkAction'])->name('customers.bulk');
    Route::post('/customers', [AdminCustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers', [AdminCustomerController::class, 'index'])->name('customers.index');
    Route::put('/customers/{user}', [AdminCustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{user}', [AdminCustomerController::class, 'destroy'])->name('customers.destroy');
    Route::get('/analytics', [AdminAnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export/sales', [AdminReportController::class, 'exportSales'])->name('reports.export.sales');
    Route::get('/reports/export/inventory', [AdminReportController::class, 'exportInventory'])->name('reports.export.inventory');
    Route::get('/reports/export/orders', [AdminReportController::class, 'exportOrders'])->name('reports.export.orders');
    Route::get('/reports/export/customers', [AdminReportController::class, 'exportCustomers'])->name('reports.export.customers');
    Route::get('/marketing', [AdminMarketingController::class, 'index'])->name('marketing.index');
    Route::post('/marketing/broadcast', [AdminMarketingController::class, 'sendBroadcast'])->name('marketing.broadcast');
    Route::delete('/marketing/subscribers/{subscriber}', [AdminMarketingController::class, 'destroy'])->name('marketing.subscribers.destroy');
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::patch('/reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
    Route::patch('/reviews/{review}/reject', [AdminReviewController::class, 'reject'])->name('reviews.reject');
    Route::post('/reviews/{review}/reply', [AdminReviewController::class, 'reply'])->name('reviews.reply');
    Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::put('/settings/general', [AdminSettingController::class, 'updateGeneral'])->name('settings.general');
    Route::put('/settings/shipping', [AdminSettingController::class, 'updateShipping'])->name('settings.shipping');
    Route::put('/settings/payments', [AdminSettingController::class, 'updatePayments'])->name('settings.payments');
    Route::put('/settings/announcements', [AdminSettingController::class, 'updateAnnouncements'])->name('settings.announcements');
    Route::put('/settings/profile', [AdminSettingController::class, 'updateProfile'])->name('settings.profile');
    Route::post('/settings/reset', [AdminSettingController::class, 'resetDefaults'])->name('settings.reset');
});
Route::group([], function (): void {
    Route::redirect('/dashboard', '/admin')->name('dashboard');
    Route::redirect('/dashborad', '/admin')->name('dashboard.misspelled');
    Route::redirect('/AdminDashboardTest.php', '/admin')->name('dashboard.test-file-alias');
});
Route::get('/products', [StoreController::class, 'products'])->name('store.products');
Route::get('/products/{product}', [StoreController::class, 'show'])->name('store.products.show');
Route::get('/new-arrivals', [StoreController::class, 'newArrivals'])->name('store.new-arrivals');
Route::get('/categories', [StoreController::class, 'categories'])->name('store.categories');
Route::get('/about', [StoreController::class, 'about'])->name('store.about');
Route::get('/contact', [StoreController::class, 'contact'])->name('store.contact');
Route::post('/contact', [StoreController::class, 'submitContact'])
    ->middleware('throttle:10,1')
    ->name('store.contact.submit');
Route::get('/track-order', [StoreController::class, 'trackOrder'])->name('store.track-order');
Route::get('/api/search', [StoreController::class, 'searchApi'])->name('store.api.search');
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('store.checkout');
Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('store.checkout.place');
Route::get('/order-success/{order}', [CheckoutController::class, 'orderSuccess'])->name('store.order.success');
Route::post('/newsletter/subscribe', [NewsletterSubscriptionController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('newsletter.subscribe');

