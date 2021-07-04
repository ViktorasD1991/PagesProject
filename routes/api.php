<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PagesController;
use App\Http\Controllers\Api\RowController;
use App\Http\Controllers\Api\ColumnController;
use App\Http\Controllers\Api\ImageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'pages'], function () {
    Route::get('/', [PagesController::class, 'get'])->name('pages.get');
    Route::get('{pageId}', [PagesController::class, 'getSingle'])->middleware('check.page')->name('pages.get.single');
    Route::post('/', [PagesController::class, 'create'])->name('pages.create');
    Route::patch('{pageId}', [PagesController::class, 'update'])->middleware('check.page')->name('pages.update');

    Route::group(['prefix' => '{pageId}/rows', 'middleware' => 'check.page'], function () {
        Route::get('/', [RowController::class, 'get'])->name('row.get');
        Route::get('{rowId}', [RowController::class, 'getSingle'])->middleware('check.row')->name('row.get.single');
        Route::post('/', [RowController::class, 'create'])->name('row.create');
        Route::patch('{rowId}', [RowController::class, 'update'])->middleware('check.row')->name('row.update');
        Route::delete('{rowId}', [RowController::class, 'delete'])->middleware('check.row')->name('row.delete');

        Route::group(['prefix' => '{rowId}/columns', 'middleware' => 'check.row'], function () {
            Route::get('/', [ColumnController::class, 'get'])->name('column.get');
            Route::get('{columnId}', [ColumnController::class, 'getSingle'])->name('column.get.single');
            Route::post('/', [ColumnController::class, 'create'])->name('column.create');
            Route::patch('{columnId}', [ColumnController::class, 'update'])->name('column.update');
            Route::delete('{columnId}', [ColumnController::class, 'delete'])->name('column.delete');

            Route::group(['prefix' => '{columnId}/elements'], function () {
                Route::post('/', [ColumnController::class, 'addElement'])->name('element.create');
                Route::delete('{elementId}', [ColumnController::class, 'removeElement'])->name('element.delete');
            });
        });
    });
});

Route::group(['prefix' => 'images'], function () {
    Route::get('/', [ImageController::class, 'get'])->name('images.get');
    Route::post('/', [ImageController::class, 'upload'])->name('images.upload');
    Route::delete('{imageId}', [ImageController::class, 'delete'])->middleware('check.image')->name('images.delete');
});
