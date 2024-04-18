<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property integer $id
 * @property integer $id_kabupaten
 * @property integer $id_kecamatan
 * @property integer $id_kelurahan
 * @property string $detail
 * @property Kabupaten $kabupaten
 * @property Kecamatan $kecamatan
 * @property Kelurahan $kelurahan
 * @property Individual[] $individuals
 */
class Alamat extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     * 
     * @var string
     */

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
    protected $fillable = ['id_kabupaten', 'id_kecamatan', 'id_kelurahan', 'detail'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function individuals()
    {
        return $this->hasMany(Individuals::class);
    }
}
