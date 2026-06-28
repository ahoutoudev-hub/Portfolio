<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class CvQualite extends Model {
    protected $table = 'cv_qualites';
    protected $fillable = ['user_id','qualite','icone','ordre'];
}
