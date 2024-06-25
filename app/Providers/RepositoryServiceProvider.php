<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


use App\Domains\Permissions\Interfaces\PermissionRepositoryInterface;
use App\Domains\Permissions\Repositories\PermissionRepository;

use App\Domains\Images\Interfaces\ImageRepositoryInterface;
use App\Domains\Images\Repositories\ImageRepository;

use App\Domains\Settings\Interfaces\SettingsRepositoryInterface;
use App\Domains\Settings\Repositories\SettingsRepository;

use App\Domains\User\Interfaces\UserRepositoryInterface;
use App\Domains\User\Repositories\UserRepository;

use App\Domains\Roles\Interfaces\RolesRepositoryInterface;
use App\Domains\Roles\Repositories\RolesRepository;

use App\Domains\Customers\Interfaces\CustomersRepositoryInterface;
use App\Domains\Customers\Repositories\CustomersRepository;

use App\Domains\Categories\Interfaces\CategoriesRepositoryInterface;
use App\Domains\Categories\Repositories\CategoriesRepository;

use App\Domains\Themes\Interfaces\ThemesRepositoryInterface;
use App\Domains\Themes\Repositories\ThemesRepository;

use App\Domains\Paintings\Interfaces\PaintingsRepositoryInterface;
use App\Domains\Paintings\Repositories\PaintingsRepository;

use App\Domains\Styles\Interfaces\StylesRepositoryInterface;
use App\Domains\Styles\Repositories\StylesRepository;

use App\Domains\Colors\Interfaces\ColorsRepositoryInterface;
use App\Domains\Colors\Repositories\ColorsRepository;

use App\Domains\Locations\Interfaces\LocationsRepositoryInterface;
use App\Domains\Locations\Repositories\LocationsRepository;

use App\Domains\Addons\Interfaces\AddonsRepositoryInterface;
use App\Domains\Addons\Repositories\AddonsRepository;

use App\Domains\Addons\Interfaces\ItemsRepositoryInterface;
use App\Domains\Addons\Repositories\ItemsRepository;

use App\Domains\Certificates\Interfaces\CertificatesRepositoryInterface;
use App\Domains\Certificates\Repositories\CertificatesRepository;

use App\Domains\Artists\Interfaces\ArtistsRepositoryInterface;
use App\Domains\Artists\Repositories\ArtistsRepository;

use App\Domains\Vendors\Interfaces\VendorsRepositoryInterface;
use App\Domains\Vendors\Repositories\VendorsRepository;

use App\Domains\Suppliers\Interfaces\SuppliersRepositoryInterface;
use App\Domains\Suppliers\Repositories\SuppliersRepository;

use App\Domains\PurchaseOrders\Interfaces\PurchaseOrderRepositoryInterface;
use App\Domains\PurchaseOrders\Repositories\PurchaseOrderRepository;

use App\Domains\SalesOrders\Interfaces\SalesOrderRepositoryInterface;
use App\Domains\SalesOrders\Repositories\SalesOrderRepository;

use App\Domains\SalesOrders\Interfaces\ReturnOrderRepositoryInterface;
use App\Domains\SalesOrders\Repositories\ReturnOrderRepository;

use App\Domains\Rooms\Interfaces\RoomsRepositoryInterface;
use App\Domains\Rooms\Repositories\RoomsRepository;

use App\Domains\Courses\Interfaces\CourseRepositoryInterface;
use App\Domains\Courses\Repositories\CourseRepository;

use App\Domains\Courses\Interfaces\CourseCategoryRepositoryInterface;
use App\Domains\Courses\Repositories\CourseCategoryRepository;

use App\Domains\Assets\Interfaces\AssetCategoryRepositoryInterface;
use App\Domains\Assets\Repositories\AssetCategoryRepository;

use App\Domains\Assets\Interfaces\AssetRepositoryInterface;
use App\Domains\Assets\Repositories\AssetRepository;

use App\Domains\History\Interfaces\HistoryRepositoryInterface;
use App\Domains\History\Repositories\HistoryRepository;

use App\Domains\Blogs\Interfaces\PostsRepositoryInterface;
use App\Domains\Blogs\Repositories\PostsRepository;

use App\Domains\Pages\Interfaces\PagesRepositoryInterface;
use App\Domains\Pages\Repositories\PagesRepository;

use App\Domains\Slides\Interfaces\SlidesRepositoryInterface;
use App\Domains\Slides\Repositories\SlidesRepository;

use App\Domains\Coupons\Interfaces\CouponsRepositoryInterface;
use App\Domains\Coupons\Repositories\CouponsRepository;

use App\Domains\Customers\Interfaces\AddressesRepositoryInterface;
use App\Domains\Customers\Repositories\AddressesRepository;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(ImageRepositoryInterface::class, ImageRepository::class);
        $this->app->bind(SettingsRepositoryInterface::class, SettingsRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RolesRepositoryInterface::class, RolesRepository::class);
        $this->app->bind(CustomersRepositoryInterface::class, CustomersRepository::class);
        $this->app->bind(CategoriesRepositoryInterface::class, CategoriesRepository::class);
        $this->app->bind(ThemesRepositoryInterface::class, ThemesRepository::class);
        $this->app->bind(PaintingsRepositoryInterface::class, PaintingsRepository::class);
        $this->app->bind(StylesRepositoryInterface::class, StylesRepository::class);
        $this->app->bind(ColorsRepositoryInterface::class, ColorsRepository::class);
        $this->app->bind(LocationsRepositoryInterface::class, LocationsRepository::class);
        $this->app->bind(AddonsRepositoryInterface::class, AddonsRepository::class);
        $this->app->bind(ItemsRepositoryInterface::class, ItemsRepository::class);
        $this->app->bind(CertificatesRepositoryInterface::class, CertificatesRepository::class);
        $this->app->bind(ArtistsRepositoryInterface::class, ArtistsRepository::class);
        $this->app->bind(VendorsRepositoryInterface::class, VendorsRepository::class);
        $this->app->bind(SuppliersRepositoryInterface::class, SuppliersRepository::class);
        $this->app->bind(PurchaseOrderRepositoryInterface::class, PurchaseOrderRepository::class);
        $this->app->bind(SalesOrderRepositoryInterface::class, SalesOrderRepository::class);
        $this->app->bind(RoomsRepositoryInterface::class, RoomsRepository::class);
        $this->app->bind(CourseRepositoryInterface::class, CourseRepository::class);
        $this->app->bind(CourseCategoryRepositoryInterface::class,CourseCategoryRepository::class);
        $this->app->bind(ReturnOrderRepositoryInterface::class,ReturnOrderRepository::class);
        $this->app->bind(AssetRepositoryInterface::class, AssetRepository::class);
        $this->app->bind(AssetCategoryRepositoryInterface::class,AssetCategoryRepository::class);
        $this->app->bind(HistoryRepositoryInterface::class,HistoryRepository::class);
        $this->app->bind(PostsRepositoryInterface::class,PostsRepository::class);
        $this->app->bind(PagesRepositoryInterface::class,PagesRepository::class);
        $this->app->bind(SlidesRepositoryInterface::class,SlidesRepository::class);
        $this->app->bind(CouponsRepositoryInterface::class,CouponsRepository::class);
        $this->app->bind(AddressesRepositoryInterface::class,AddressesRepository::class);
        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
