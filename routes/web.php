<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\StockHistoryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\LanguageController;


/*
    |--------------------------------------------------------------------------
    | Language
    |--------------------------------------------------------------------------
    */       

    Route::get('/language/{locale}',[LanguageController::class, 'switch'])
        ->name('language.switch');


Route::middleware(['auth','locale',])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Products
    |--------------------------------------------------------------------------
    */

    Route::resource('products', ProductController::class)
        ->middleware('role:director,manager');

    /*
    |--------------------------------------------------------------------------
    | Customers
    |--------------------------------------------------------------------------
    */

    Route::resource('customers', CustomerController::class)
        ->middleware('role:director,manager');

    /*
    |--------------------------------------------------------------------------
    | Orders
    |--------------------------------------------------------------------------
    */

    Route::resource('orders', OrderController::class)
        ->middleware('role:director,manager');

    Route::get('/orders/{order}/excel',
        [OrderController::class, 'exportExcel'])
        ->name('orders.excel');
/*
|--------------------------------------------------------------------------
| Notifications
|--------------------------------------------------------------------------
*/

Route::get('/notifications/latest', function () {

    $user = auth()->user();

    $notifications = $user
        ->unreadNotifications()
        ->latest()
        ->take(5)
        ->get()
        ->map(function ($notification) {

            return [
                'id' => $notification->id,

                'title' =>
                    $notification->data['title']
                    ?? 'Order Status Changed',

                'message' =>
                    $notification->data['message']
                    ?? '',

                'order_id' =>
                    $notification->data['order_id']
                    ?? null,

                'order_number' =>
                    $notification->data['order_number']
                    ?? '',

                'driver_name' =>
                    $notification->data['driver_name']
                    ?? '',

                'old_status' =>
                    $notification->data['old_status']
                    ?? '',

                'new_status' =>
                    $notification->data['new_status']
                    ?? '',

                'created_at' =>
                    $notification->created_at
                        ->diffForHumans(),
            ];

        });

    return response()->json([

        'notifications' => $notifications,

        'unread_count' =>
            $user->unreadNotifications()->count(),

    ]);

})->name('notifications.latest');


/*
|--------------------------------------------------------------------------
| Delete notification
|--------------------------------------------------------------------------
|
| Notification-ը ջնջվում է միայն × կոճակով
|
*/

Route::delete(
    '/notifications/{notification}',
    function ($notification) {

        $user = auth()->user();

        $user->notifications()
            ->where('id', $notification)
            ->delete();

        return response()->json([
            'success' => true
        ]);

    }
)->name('notifications.delete');

/*
|--------------------------------------------------------------------------
| Mark notification as read
|--------------------------------------------------------------------------
*/

Route::patch(
    '/notifications/{notification}/read',
    function ($notification) {

        $user = auth()->user();

        $notification =
            $user->notifications()
                ->where('id', $notification)
                ->firstOrFail();

        $notification->markAsRead();

        return response()->json([
            'success' => true
        ]);

    }
)->name('notifications.read');   
        










        
    /*
    |--------------------------------------------------------------------------
    | Users
    |--------------------------------------------------------------------------
    */

    Route::resource('users', UserController::class)
        ->middleware('role:director');

    /*
    |--------------------------------------------------------------------------
    | Reports
    |--------------------------------------------------------------------------
    */

    Route::get('/reports',
        [ReportController::class, 'index'])
        ->name('reports.index');

    Route::get('/reports/sales',
        [ReportController::class, 'sales'])
        ->name('reports.sales')
        ->middleware('role:director,manager');

    Route::get('/reports/monthly',
        [ReportController::class, 'monthly'])
        ->name('reports.monthly');

    Route::get('/reports/monthly/pdf',
        [ReportController::class, 'monthlyPdf'])
        ->name('reports.monthly.pdf');
    

    /*
    |--------------------------------------------------------------------------
    | Driver
    |--------------------------------------------------------------------------
    */

    Route::middleware('driver')->group(function () {

        Route::get('/driver',
            [DriverController::class, 'index'])
            ->name('driver.index');

        Route::patch('/driver/orders/{order}/start',
            [DriverController::class, 'start'])
            ->name('driver.orders.start');

        Route::patch('/driver/orders/{order}/complete',
            [DriverController::class, 'complete'])
            ->name('driver.orders.complete');

    });

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile',
        [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile',
        [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile',
        [ProfileController::class, 'destroy'])
        ->name('profile.destroy');



    /*
    |--------------------------------------------------------------------------
    | Stock
    |--------------------------------------------------------------------------
    */

    Route::get('/stock-history',[StockHistoryController::class, 'index'])
            ->middleware('role:director,manager')
            ->name('stock-history.index');

    Route::get('/stock-history/excel',
        [StockHistoryController::class, 'exportExcel'])
        ->name('stock-history.excel');

    Route::get('/stock-history/pdf',
        [StockHistoryController::class, 'exportPdf'])
        ->name('stock-history.pdf');



    /*
    |--------------------------------------------------------------------------
    | Payment
    |--------------------------------------------------------------------------
    */

    Route::resource('payments', PaymentController::class)
    ->middleware('role:director,manager');


     /*
    |--------------------------------------------------------------------------
    | Invoice
    |--------------------------------------------------------------------------
    */

    Route::get('/orders/{order}/invoice',[OrderController::class, 'invoice'])
        ->name('orders.invoice');

    

    

});

require __DIR__.'/auth.php';