<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property integer $id
 * @property string $kecamatan
 * @property Alamat[] $alamats
 * @property StokSb[] $stokSbs
 */
class Kecamatan extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'kecamatan';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['kecamatan'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function alamat()
    {
        return $this->hasMany(Alamat::class);
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
    public function wilayah_kerja()
    {
        return $this->hasMany(WilayahKerja::class);
    }
}
