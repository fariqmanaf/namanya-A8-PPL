<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property integer $id
 * @property string $jenis_semen
 * @property TotalIb[] $totalIbs
 * @property StokMantri[] $stokMantris
 * @property StokSb[] $stokSbs
 * @property PengajuanSb[] $pengajuanSbs
 */
class JenisSemen extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'jenis_semen';

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
    protected $fillable = ['jenis_semen'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dataSapi()
    {
        return $this->hasMany(DataSapi::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stokMantris()
    {
        return $this->hasMany(StokMantri::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stokSbs()
    {
        return $this->hasMany(StokSb::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detailPengajuan()
    {
        return $this->hasMany(DetailPengajuan::class);
    }
}
