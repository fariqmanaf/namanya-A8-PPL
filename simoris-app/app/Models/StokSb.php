<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property integer $id
 * @property integer $id_kecamatan
 * @property integer $id_jenis
 * @property integer $jumlah
 * @property integer $used
 * @property Kecamatan $kecamatan
 * @property JenisSeman $jenisSeman
 */
class StokSb extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'stok_sb';

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
    protected $fillable = ['kecamatan_id', 'jenis_semen_id', 'jumlah', 'used', 'periode', 'status'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jenis_sapi()
    {
        return $this->belongsTo(JenisSemen::class, 'jenis_semen_id');
    }
}
