<?php

declare(strict_types=1);

use App\Jobs\ImportProductsJob;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});
Route::get('/update-products-from-api', function () {
    ImportProductsJob::dispatch();
    return response()->json(['message' => 'Products update initiated'], 200);
});


require __DIR__ . '/auth.php';
