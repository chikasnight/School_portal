<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = [
        'user_id',
        'student_name',
        'teacher_name',
        'subject',
        'ca',
        'exams',
        'total'
    ];
    
    // relationship of user & record is one to many;
    public function user(){
        return $this->belongsTo(User::class);
    }
}
