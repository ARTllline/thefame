<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ServiceCategory extends Model implements Sortable, HasMedia
{
    use HasFactory, HasTranslations;
    use SortableTrait;
    use InteractsWithMedia;

    protected $fillable = ['title', 'code', 'description', 'order'];
    public $translatable = ['title', 'description'];

    protected $casts = [
        'description' => 'array',
        'title' => 'array',
    ];

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];
    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('webp')
            ->width(500)
            ->height(500)
            ->format(Manipulations::FORMAT_WEBP);
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('main')->singleFile()->useDisk('categories');
    }
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }

}
