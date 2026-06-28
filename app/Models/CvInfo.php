<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CvInfo extends Model {
    protected $table = 'cv_infos';
    protected $fillable = [
        'user_id','date_naissance','lieu_naissance','genre',
        'nationalite','situation_matrimoniale','permis',
        'adresse_complete','titre_professionnel','resume',
    ];
    protected $casts = ['date_naissance' => 'date'];
    public function user() { return $this->belongsTo(User::class); }

    public function getAgeAttribute(): ?int {
        return $this->date_naissance?->age;
    }
}
