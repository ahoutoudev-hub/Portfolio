<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class CvInteret extends Model {
    protected $table = 'cv_interets';
    protected $fillable = ['user_id','interet','icone','ordre'];
}
