<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table='companies';

    protected $primaryKey='id';

    public $timestamps = false;

    protected $fillable=['name','address','logo'];

    public function employees(): BelongsTo
    {
        return $this->hasMany(Employee::class);
    }
}
