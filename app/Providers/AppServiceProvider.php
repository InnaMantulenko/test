<?php

namespace App\Providers;

use App\Services\Search\DataService;
use App\Services\Search\ElasticDataService;
use App\Services\Search\EloquentDataService;
use Illuminate\Support\ServiceProvider;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DataService::class, function () {
            // This is useful if we want to shut down our cluster or when deploying search to production
            if (!config('services.elasticsearch.enabled')) {
                return new EloquentDataService();
            }
            return new ElasticDataService(
                app()->make(Client::class)
            );
        });

        $this->bindSearchClient();
    }

    private function bindSearchClient()
    {
        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts($app['config']->get('services.elasticsearch.hosts'))
                ->build();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
