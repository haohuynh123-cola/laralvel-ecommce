<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

abstract class BaseObserver
{
    public function creating(Model $model): void {}

    public function created(Model $model): void {}

    public function updating(Model $model): void {}

    public function updated(Model $model): void {}

    public function deleting(Model $model): void {}

    public function deleted(Model $model): void {}
}
