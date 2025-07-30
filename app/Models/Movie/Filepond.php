<?php


namespace App\Models\Movie;

use App\Models\User\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Filepond extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = 'fileponds';

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean'
    ];




    protected static function boot()
    {
        parent::boot();
        static::forceDeleting(function (Model $model) {
            /** @var self $model */
            if ( File::isDirectory(storage_path('app/'.dirname($model->filepath))) and $model->filepath )
            File::deleteDirectory(storage_path('app/'.dirname($model->filepath)));
        });
    }
    public function scopeOwned($query)
    {
        $query->when(auth()->check(), function ($query) {
            $query->where($this->getTable().'.created_by', auth()->id());
        });
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
