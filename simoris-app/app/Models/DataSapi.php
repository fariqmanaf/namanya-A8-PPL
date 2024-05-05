<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property integer $id
 * @property integer $id_jenis
 * @property integer $id_peternak
 * @property string $detail
 * @property JenisSapi $jenisSapi
 * @property Individual $individual
 * @property LaporanIb[] $laporanIbs
 */
class DataSapi extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $guarded = 'id';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['jenis_sapi_id', 'individuals_id', 'detail'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jenisSapi()
    {
        return $this->belongsTo(JenisSapi::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function individual()
    {
        return $this->belongsTo(Individuals::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function laporanIb()
    {
        return $this->hasMany(LaporanIb::class);
    }
}
