<?php

namespace App\Providers;

use App\Repositories\ColumnRepository;
use App\Repositories\Eloquent\EloquentColumnRepository;
use App\Repositories\Eloquent\EloquentImageRepository;
use App\Repositories\Eloquent\EloquentRowRepository;
use App\Repositories\ImageRepository;
use App\Repositories\RowRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\PagesRepository;
use App\Repositories\Eloquent\EloquentPagesRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PagesRepository::class, EloquentPagesRepository::class);
        $this->app->bind(RowRepository::class, EloquentRowRepository::class);
        $this->app->bind(ColumnRepository::class, EloquentColumnRepository::class);
        $this->app->bind(ImageRepository::class, EloquentImageRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
