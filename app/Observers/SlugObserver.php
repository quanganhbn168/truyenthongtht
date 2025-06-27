<?php
namespace App\Observers;

use Illuminate\Support\Str;

class SlugObserver
{
    public function saved($model)
    {
        if (!$model->slug) {
            $slugBase = Str::slug($model->name ?? $model->title);
            $slug = $slugBase;
            $i = 1;
            while (\App\Models\Slug::where('slug', $slug)->exists()) {
                $slug = $slugBase . '-' . $i++;
            }

            $model->slug()->create(['slug' => $slug]);
        }
    }

    public function deleting($model)
    {
        $model->slug()->delete();
    }
}
