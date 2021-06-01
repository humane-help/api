<?php

namespace App\Providers;

use App\Repositories\ArticleRepository;
use App\Repositories\Contracts\ArticleRepository as ArticleRepositoryInterface;
use App\Repositories\ImageRepository;
use App\Repositories\Contracts\ImageRepository as  ImageRepositoryInterface;
use App\Repositories\NewspaperRepository;
use App\Repositories\TagRepository;
use App\Repositories\Contracts\UserRepository as UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Services\ArticleService;
use App\Services\Contracts\ArticleService as ArticleServiceInterface;
use App\Services\NewspaperService;
use App\Services\Contracts\NewspaperService as NewspaperServiceInterface;
use App\Services\TagService;
use App\Services\Contracts\TagService as TagServiceInterface;
use App\Services\Contracts\UserService as UserServiceInterface;
use App\Services\ImageService;
use App\Services\UserService;
use App\Services\TechService;
use App\Repositories\TechRepository;
use App\Repositories\Contracts\TechRepository as TechRepositoryInterface;
use App\Services\Contracts\TechService as TechServiceInterface;
use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\CategoryService as CategoryServiceInterface;
use App\Repositories\Contracts\CategoryRepository as CategoryRepositoryInterface;
use App\Repositories\Contracts\NewspaperRepository as NewspaperRepositoryInterface;
use App\Repositories\Contracts\TagRepository as TagRepositoryInterface;
use App\Services\Contracts\ImageService as ImageServiceInterface;
use App\Services\CategoryService;
use App\Repositories\CategoryRepository;
use App\Services\TelegramService;
use App\Services\Contracts\TelegramService as TelegramServiceInterface;

/**
 * Class AppServiceProvider
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Category
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        // User
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        // Article
        $this->app->bind(ArticleServiceInterface::class, ArticleService::class);
        $this->app->bind(ArticleRepositoryInterface::class, ArticleRepository::class);
        // Newspaper
        $this->app->bind(NewspaperServiceInterface::class, NewspaperService::class);
        $this->app->bind(NewspaperRepositoryInterface::class, NewspaperRepository::class);
        // Tech
        $this->app->bind(TechServiceInterface::class, TechService::class);
        $this->app->bind(TechRepositoryInterface::class, TechRepository::class);
        // Tag
        $this->app->bind(TagServiceInterface::class, TagService::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
        // Image
        $this->app->bind(ImageServiceInterface::class, ImageService::class);
        $this->app->bind(ImageRepositoryInterface::class, ImageRepository::class);

        //Telegram
        $this->app->bind(TelegramServiceInterface::class, TelegramService::class);
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
