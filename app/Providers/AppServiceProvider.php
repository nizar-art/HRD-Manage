<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserActivity;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::created(function ($model) {
            $this->logUserActivity($model, 'create', 'Created a new ' . class_basename($model));
        });

        Model::updated(function ($model) {
            $changes = $model->getChanges(); // Ambil perubahan data
            $description = 'Updated ' . class_basename($model) . ' fields: ' . implode(', ', array_keys($changes));

            $this->logUserActivity($model, 'update', $description);
        });

        Model::deleted(function ($model) {
            $this->logUserActivity($model, 'delete', 'Deleted ' . class_basename($model));
        });
    }

    /**
     * Log aktivitas pengguna.
     */
    protected function logUserActivity($model, $action, $description)
    {
        if (Auth::check()) {
            UserActivity::create([
                'user_id' => Auth::id(),
                'activity' => $this->getActivityDescription($model, $action),
                'type' => $action,
                'description' => $description,
                'activity_date' => now(),
            ]);
        }
    }

    /**
     * Dapatkan deskripsi aktivitas berdasarkan model dan tindakan.
     */
    protected function getActivityDescription($model, $action)
    {
        $modelName = class_basename($model); // Ambil nama model seperti 'User', 'Product', dll.
        $primaryKey = $model->getKey(); // Dapatkan primary key dari instance model.

        return match ($action) {
            'create' => "Created a new {$modelName} with ID {$primaryKey}",
            'update' => "Updated {$modelName} with ID {$primaryKey}",
            'delete' => "Deleted {$modelName} with ID {$primaryKey}",
            default => "Performed an action on {$modelName} with ID {$primaryKey}",
        };
    }
}
