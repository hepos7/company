<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table='employees';

    protected $primaryKey='id';

    public $timestamps = false;

    protected $fillable=['name','email','password','company_id','image'];

    public function company(): HasOne
    {
        return $this->belongsTo(Company::class);
    }
}
