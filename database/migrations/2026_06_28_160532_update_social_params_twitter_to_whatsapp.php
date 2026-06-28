<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Renommer social_twitter → social_whatsapp
        DB::table('parametres')
            ->where('cle', 'social_twitter')
            ->update(['cle' => 'social_whatsapp', 'valeur' => '', 'updated_at' => now()]);

        // Ajouter social_facebook s'il n'existe pas déjà
        if (!DB::table('parametres')->where('cle', 'social_facebook')->exists()) {
            DB::table('parametres')->insert([
                'cle'        => 'social_facebook',
                'valeur'     => '',
                'groupe'     => 'social',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('parametres')
            ->where('cle', 'social_whatsapp')
            ->update(['cle' => 'social_twitter', 'valeur' => '', 'updated_at' => now()]);

        DB::table('parametres')->where('cle', 'social_facebook')->delete();
    }
};
