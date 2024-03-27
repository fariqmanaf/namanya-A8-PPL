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
    public function totalIbs()
    {
        return $this->hasMany('App\Models\TotalIb', 'id_semen');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stokMantris()
    {
        return $this->hasMany('App\Models\StokMantri', 'id_semen');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stokSbs()
    {
        return $this->hasMany('App\Models\StokSb', 'id_jenis');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pengajuanSbs()
    {
        return $this->hasMany('App\Models\PengajuanSb', 'id_jenis');
    }
}
