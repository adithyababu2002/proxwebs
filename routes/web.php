<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ContactSubmissionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsletterSubscriberController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\VisitorLogController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/images/{file}', function (string $file) {
    $path = resource_path('images/' . basename($file));

    abort_unless(is_file($path), 404);

    return response()->file($path);
})->where('file', '[\w.\-]+');

Route::get('/', function () {
    return view('onix-vue');
});

Route::get('/onix', function () {
    return redirect('/');
});

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('/newsletter', [NewsletterController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('newsletter.store');
Route::post('/chat', [ChatController::class, 'store'])
    ->middleware('throttle:30,1')
    ->name('chat.store');
Route::post('/chat/translate', [ChatController::class, 'translate'])
    ->middleware('throttle:20,1')
    ->name('chat.translate');
Route::post('/chat/speak', [ChatController::class, 'speak'])
    ->middleware('throttle:40,1')
    ->name('chat.speak');
Route::get('/api/team', [TeamController::class, 'index'])->name('team.index');
Route::post('/api/analytics/heartbeat', [AnalyticsController::class, 'heartbeat'])
    ->middleware('throttle:120,1')
    ->name('analytics.heartbeat');
Route::post('/api/analytics/event', [AnalyticsController::class, 'event'])
    ->middleware('throttle:60,1')
    ->name('analytics.event');
Route::post('/api/analytics/identify', [AnalyticsController::class, 'identify'])
    ->middleware('throttle:30,1')
    ->name('analytics.identify');

Route::prefix('webuser/api')->group(function () {
    Route::post('/login', [AdminAuthController::class, 'login'])
        ->middleware('throttle:10,1')
        ->name('admin.login');

    Route::middleware('auth')->group(function () {
        Route::get('/me', [AdminAuthController::class, 'me'])->name('admin.me');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
        Route::get('/dashboard', DashboardController::class)->name('admin.dashboard');
        Route::get('/contacts', [ContactSubmissionController::class, 'index'])->name('admin.contacts.index');
        Route::get('/contacts/{contact}', [ContactSubmissionController::class, 'show'])->name('admin.contacts.show');
        Route::delete('/contacts/{contact}', [ContactSubmissionController::class, 'destroy'])->name('admin.contacts.destroy');
        Route::get('/subscribers', [NewsletterSubscriberController::class, 'index'])->name('admin.subscribers.index');
        Route::delete('/subscribers/{subscriber}', [NewsletterSubscriberController::class, 'destroy'])->name('admin.subscribers.destroy');

        Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
        Route::post('/users', [AdminUserController::class, 'store'])->name('admin.users.store');
        Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

        Route::get('/team-members', [TeamMemberController::class, 'index'])->name('admin.team.index');
        Route::post('/team-members', [TeamMemberController::class, 'store'])->name('admin.team.store');
        Route::get('/team-members/{teamMember}', [TeamMemberController::class, 'show'])->name('admin.team.show');
        Route::match(['put', 'post'], '/team-members/{teamMember}', [TeamMemberController::class, 'update'])->name('admin.team.update');
        Route::delete('/team-members/{teamMember}', [TeamMemberController::class, 'destroy'])->name('admin.team.destroy');

        Route::get('/logs', [VisitorLogController::class, 'index'])->name('admin.logs.index');
        Route::get('/logs/{log}', [VisitorLogController::class, 'show'])->name('admin.logs.show');
        Route::delete('/logs/{log}', [VisitorLogController::class, 'destroy'])->name('admin.logs.destroy');
    });
});

Route::view('/webuser/{any?}', 'admin')->where('any', '.*')->name('admin');

Route::view('/services', 'onix-vue');
Route::view('/features', 'onix-vue');
Route::view('/features/{slug}', 'onix-vue')->where('slug', '[\w\-]+');
Route::view('/designs', 'onix-vue');
Route::view('/about', 'onix-vue');
Route::view('/team', 'onix-vue');
Route::view('/zelo', 'onix-vue');
Route::view('/portfolio', 'onix-vue');
Route::view('/videos', 'onix-vue');
Route::view('/contact', 'onix-vue');
Route::view('/overview', 'onix-vue');
