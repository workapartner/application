<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Company
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $description
 * @property string $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'phone',
        'user_id',
    ];


    /**
     * @return mixed
     */
    public function user(): mixed
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id')->withTrashed();
    }
}
