<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'total_votes_casted', 'polling_unit_id', 'ward_id', 'party_id','lga_id', 'state_id', 'user_id'];
}
