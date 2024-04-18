<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_mantri
 * @property integer $nomor_sertifikasi
 * @property string $bukti
 * @property boolean $is_accepted
 * @property Individual $individual
 */
class Sertifikasi extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sertifikasi';

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
    protected $fillable = ['individuals_id', 'nomor_sertifikasi', 'bukti', 'is_accepted', 'tanggal_pembuatan', 'tanggal_expired'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function individual()
    {
        return $this->belongsTo(Individuals::class, 'individuals_id');
    }
}
