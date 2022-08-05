<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmitAssignment extends Model
{
    protected $fillable = [
        'user_id',
        'submit_assignments',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }

}
