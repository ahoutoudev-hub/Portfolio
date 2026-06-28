<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CvLangue extends Model {
    protected $table = 'cv_langues';
    protected $fillable = ['user_id','langue','niveau','ordre'];

    const NIVEAUX = [
        'debutant'      => ['label'=>'Débutant',       'stars'=>1],
        'elementaire'   => ['label'=>'Élémentaire',    'stars'=>2],
        'intermediaire' => ['label'=>'Intermédiaire',  'stars'=>3],
        'avance'        => ['label'=>'Avancé',         'stars'=>4],
        'courant'       => ['label'=>'Courant',        'stars'=>5],
        'natif'         => ['label'=>'Langue natale',  'stars'=>5],
    ];

    public function getNiveauLabelAttribute(): string {
        return self::NIVEAUX[$this->niveau]['label'] ?? $this->niveau;
    }
    public function getNiveauStarsAttribute(): int {
        return self::NIVEAUX[$this->niveau]['stars'] ?? 3;
    }
}
