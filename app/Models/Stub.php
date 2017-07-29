<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Stub
 *
 * @property-read \App\Models\User $user
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property string $value
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stub whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stub whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stub whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stub whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stub whereValue($value)
 */
class Stub extends Model
{
    protected $fillable = [
        'value',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
