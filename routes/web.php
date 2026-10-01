<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeightLogController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get("/gallery", function () {
    $ant = "https://cdn3.movieweb.com/i/article/Oi0Q2edcVVhs4p1UivwyyseezFkHsq/1107:50/Ant-Man-3-Talks-Michael-Douglas-Update.jpg";
    $bird = "https://images.indianexpress.com/2021/03/falcon-anthony-mackie-1200.jpg";
    $cat = "https://www.sideshow.com/cdn-cgi/image/height=850,quality=90,f=auto/https://www.sideshow.com/storage/product-images/910233/black-panther-deluxe_marvel_gallery_61eb5a329c25b.jpg";
    $god = "https://www.blackoutx.com/wp-content/uploads/2021/04/Thor.jpg";
    $spider = "https://i.redd.it/n9ohicnpiskb1.jpg";

    return view("test/index", compact("ant", "bird", "cat", "god", "spider"));
});



Route::get("/gallery/ant", function () {
    $ant = "https://cdn3.movieweb.com/i/article/Oi0Q2edcVVhs4p1UivwyyseezFkHsq/1107:50/Ant-Man-3-Talks-Michael-Douglas-Update.jpg";
    return view("test/ant", compact("ant"));
});

Route::get("/gallery/bird", function () {
    $bird = "https://images.indianexpress.com/2021/03/falcon-anthony-mackie-1200.jpg";
    return view("test/bird", compact("bird"));
});

Route::get("/gallery/cat", function () {
    $cat = "https://www.sideshow.com/cdn-cgi/image/height=850,quality=90,f=auto/https://www.sideshow.com/storage/product-images/910233/black-panther-deluxe_marvel_gallery_61eb5a329c25b.jpg";
    return view("test/cat", compact("cat"));
});
Route::get('/active/index', function () {
    return view('active/index');
})->name('index');

Route::get('/active/about', function () {
    return view('active/about');
})->name('about');
Route::get('/active/services', function () {
    return view('active/services');
})->name('services');
Route::get('/active/portfolio', function () {
    return view('active/portfolio');
})->name('portfolio');
Route::get('/active/team', function () {
    return view('active/team');
})->name('team');
Route::get('/active/blog', function () {
    return view('active/blog');
})->name('blog');
Route::get('/active/contact', function () {
    return view('active/contact');
})->name('contact');

require __DIR__.'/auth.php';


Route::get('/', function () {
    return redirect()->route('weights.index');
});

// Resource Routes สำหรับระบบติดตามน้ำหนัก
Route::get('/weights', [WeightLogController::class, 'index'])->name('weights.index');
Route::post('/weights', [WeightLogController::class, 'store'])->name('weights.store');
Route::put('/weights/{weightLog}', [WeightLogController::class, 'update'])->name('weights.update');
Route::delete('/weights/{weightLog}', [WeightLogController::class, 'destroy'])->name('weights.destroy');
Route::get('/about-me', function () {
    return view('project.about-me');
});