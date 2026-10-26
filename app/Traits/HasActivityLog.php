<?php

namespace App\Traits;

use App\Models\UserActivity;
use Illuminate\Support\Facades\Auth;

trait HasActivityLog
{
    protected static function bootHasActivityLog()
    {
        static::created(function ($model) {
            self::logActivity($model, 'added');
        });

        static::updated(function ($model) {
            self::logActivity($model, 'edited');
        });

        static::deleted(function ($model) {
            self::logActivity($model, 'deleted');
        });
    }

    protected static function logActivity($model, $action)
    {
        if (Auth::check()) {
            UserActivity::create([
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'action' => $action,
                'module' => class_basename($model),
                'model_name' => get_class($model),
                'model_id' => $model->id,
                'description' => self::getActivityDescription($model, $action),
            ]);
        }
    }

    protected static function getActivityDescription($model, $action)
    {
        $name = $model->name 
            ?? $model->title 
            ?? $model->invoice_number 
            ?? $model->slip_number 
            ?? $model->batch_number 
            ?? $model->description
            ?? "ID: {$model->id}";
        return "User " . Auth::user()->name . " {$action} " . class_basename($model) . ": {$name}";
    }
}
