<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property integer $id
 * @property integer $id_mantri
 * @property integer $nomor_surat
 * @property string $bukti
 * @property boolean $is_accepted
 * @property Individual $individual
 */
class SuratIzin extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'surat_izin';

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
    protected $fillable = ['individuals_id', 'nomor_surat', 'bukti', 'is_accepted', 'tanggal_pembuatan', 'tanggal_expired'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function individual()
    {
        return $this->belongsTo(Individuals::class, 'individuals_id');
    }
}
