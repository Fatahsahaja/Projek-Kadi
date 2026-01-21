<?php

namespace App\Providers;

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> fix-login
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //
<<<<<<< HEAD
=======
=======
>>>>>>> 4c11faf2aa747796b3f8d69bd93de3cddd12f5ff
use App\Models\Transaction;
use App\Policies\TransactionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     */
    protected $policies = [
        Transaction::class => TransactionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();
<<<<<<< HEAD
>>>>>>> 4c11faf (first comm)
=======
>>>>>>> 4c11faf2aa747796b3f8d69bd93de3cddd12f5ff
=======
>>>>>>> fix-login
    }
}