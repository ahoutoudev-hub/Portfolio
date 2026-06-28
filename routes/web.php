<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Admin\ProjetController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\CompetenceController;
use App\Http\Controllers\Admin\CertificatController;
use App\Http\Controllers\Admin\StatController;
use App\Http\Controllers\Admin\ParametreController;
use App\Http\Controllers\Admin\TableauDeBordController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\TemoignageController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\CvLettreController;
use App\Http\Controllers\Admin\MaintenanceController;

use App\Http\Controllers\AccueilController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/',           [AccueilController::class, 'accueil'] )->name('accueil');
Route::get('/about',      [AccueilController::class, 'apropos'] )->name('apropos');
Route::get('/projets',    [AccueilController::class, 'projets'] )->name('client.projets');
Route::get('/projets/{slug}', [AccueilController::class, 'projetDetail'])->name('projet.detail');
Route::get ('/contact', fn() => redirect(route('accueil') . '#contact'))->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store')->middleware('throttle:5,1');

// ── Authentification ──────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/connexion',    [AuthController::class, 'Connexion'])->name('auth.connexion');
    Route::post('/SeConnecter', [AuthController::class, 'SeConnecter'])->name('auth.SeConnecter');

    // Mot de passe oublié
    Route::get('/mot-de-passe-oublie',  [PasswordResetController::class, 'showForgot'])->name('password.request');
    Route::post('/mot-de-passe-oublie', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reinitialiser/{token}', [PasswordResetController::class, 'showReset'])->name('password.reset');
    Route::post('/reinitialiser',        [PasswordResetController::class, 'reset'])->name('password.update');
});

// Déconnexion (POST)
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');

// ── Admin ─────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/TableauDeBord', [TableauDeBordController::class, 'index'])->name('TableauDeBord');

    // ── Projets ───────────────────────────────────────────
    Route::get   ('/projets',                  [ProjetController::class, 'index']        )->name('projets.index');
    Route::get   ('/projets/create',           [ProjetController::class, 'create']       )->name('projets.create');
    Route::post  ('/projets',                  [ProjetController::class, 'store']        )->name('projets.store');
    Route::get   ('/projets/{projet}/edit',    [ProjetController::class, 'edit']         )->name('projets.edit');
    Route::post  ('/projets/{projet}/update',  [ProjetController::class, 'update']       )->name('projets.update');
    Route::post  ('/projets/{projet}/delete',  [ProjetController::class, 'destroy']      )->name('projets.destroy');
    Route::post  ('/projets/{projet}/vedette', [ProjetController::class, 'toggleVedette'])->name('projets.vedette');
    
    Route::get   ('/experiences',                    [ExperienceController::class, 'index']      )->name('experiences.index');
    Route::get   ('/experiences/create',             [ExperienceController::class, 'create']     )->name('experiences.create');
    Route::post  ('/experiences',                    [ExperienceController::class, 'store']      )->name('experiences.store');
    Route::get   ('/experiences/{experience}/edit',  [ExperienceController::class, 'edit']       )->name('experiences.edit');
    Route::post  ('/experiences/{experience}/update',[ExperienceController::class, 'update']     )->name('experiences.update');
    Route::post  ('/experiences/{experience}/delete',[ExperienceController::class, 'destroy']    )->name('experiences.destroy');
    Route::post  ('/experiences/{experience}/toggle',[ExperienceController::class, 'toggleActif'])->name('experiences.toggle');

    // ── Compétences ───────────────────────────────────────────────
    Route::get   ('/competences',                        [CompetenceController::class, 'index']          )->name('competences.index');
    Route::get   ('/competences/create',                 [CompetenceController::class, 'create']         )->name('competences.create');
    Route::post  ('/competences',                        [CompetenceController::class, 'store']          )->name('competences.store');
    Route::get   ('/competences/{competence}/edit',      [CompetenceController::class, 'edit']           )->name('competences.edit');
    Route::post  ('/competences/{competence}/update',    [CompetenceController::class, 'update']         )->name('competences.update');
    Route::post  ('/competences/{competence}/delete',    [CompetenceController::class, 'destroy']        )->name('competences.destroy');
    Route::post  ('/competences/{competence}/niveau',    [CompetenceController::class, 'updateNiveau']   )->name('competences.niveau');
 
    // ── Catégories de compétences ─────────────────────────────────
    Route::get   ('/competences/categories',                           [CompetenceController::class, 'indexCategories']  )->name('competences.categories');
    Route::post  ('/competences/categories',                           [CompetenceController::class, 'storeCategorie']   )->name('competences.categories.store');
    Route::post  ('/competences/categories/{categorieCompetence}/update', [CompetenceController::class, 'updateCategorie'])->name('competences.categories.update');
    Route::post  ('/competences/categories/{categorieCompetence}/delete', [CompetenceController::class, 'destroyCategorie'])->name('competences.categories.destroy');

    // ── Certificats ───────────────────────────────────────────────
    Route::get   ('/certificats',                      [CertificatController::class, 'index']      )->name('certificats.index');
    Route::get   ('/certificats/create',               [CertificatController::class, 'create']     )->name('certificats.create');
    Route::post  ('/certificats',                      [CertificatController::class, 'store']      )->name('certificats.store');
    Route::get   ('/certificats/{certificat}/edit',    [CertificatController::class, 'edit']       )->name('certificats.edit');
    Route::post  ('/certificats/{certificat}/update',  [CertificatController::class, 'update']     )->name('certificats.update');
    Route::post  ('/certificats/{certificat}/delete',  [CertificatController::class, 'destroy']    )->name('certificats.destroy');
    Route::post  ('/certificats/{certificat}/toggle',  [CertificatController::class, 'toggleActif'])->name('certificats.toggle');

    // ── Statistiques ──────────────────────────────────────────────
    Route::get('/stats', [StatController::class, 'index'])->name('stats.index');

    // ── Paramètres ────────────────────────────────────────────────
    Route::get ('/parametres',        [ParametreController::class, 'index']    )->name('parametres.index');
    Route::post('/parametres',        [ParametreController::class, 'update']   )->name('parametres.update');
    Route::post('/parametres/one',    [ParametreController::class, 'updateOne'])->name('parametres.update-one');

    // ── Messages ──────────────────────────────────────────────────
    Route::get   ('/messages',                      [MessageController::class, 'index']         )->name('messages.index');
    Route::get   ('/messages/{message}',            [MessageController::class, 'show']          )->name('messages.show');
    Route::post  ('/messages/{message}/delete',     [MessageController::class, 'destroy']       )->name('messages.destroy');
    Route::post  ('/messages/{message}/lu',         [MessageController::class, 'marquerLu']     )->name('messages.lu');
    Route::post  ('/messages/{message}/important',  [MessageController::class, 'toggleImportant'])->name('messages.important');
    Route::post  ('/messages/{message}/repondu',    [MessageController::class, 'marquerRepondu'])->name('messages.repondu');
    Route::post  ('/messages/tous-lus',             [MessageController::class, 'marquerTousLus'])->name('messages.tous-lus');
    Route::post  ('/messages/delete-multiple',      [MessageController::class, 'destroyMultiple'])->name('messages.destroy-multiple');

    // ── Témoignages ───────────────────────────────────────────────
    Route::get   ('/temoignages',                        [TemoignageController::class, 'index']      )->name('temoignages.index');
    Route::get   ('/temoignages/create',                 [TemoignageController::class, 'create']     )->name('temoignages.create');
    Route::post  ('/temoignages',                        [TemoignageController::class, 'store']      )->name('temoignages.store');
    Route::get   ('/temoignages/{temoignage}/edit',      [TemoignageController::class, 'edit']       )->name('temoignages.edit');
    Route::post  ('/temoignages/{temoignage}/update',    [TemoignageController::class, 'update']     )->name('temoignages.update');
    Route::post  ('/temoignages/{temoignage}/delete',    [TemoignageController::class, 'destroy']    )->name('temoignages.destroy');
    Route::post  ('/temoignages/{temoignage}/toggle',    [TemoignageController::class, 'toggleActif'])->name('temoignages.toggle');

    // ── Tags ──────────────────────────────────────────────────────
    Route::get   ('/tags',                  [TagController::class, 'index']  )->name('tags.index');
    Route::post  ('/tags',                  [TagController::class, 'store']  )->name('tags.store');
    Route::post  ('/tags/{tag}/update',     [TagController::class, 'update'] )->name('tags.update');
    Route::post  ('/tags/{tag}/delete',     [TagController::class, 'destroy'])->name('tags.destroy');

    // ── Profil ────────────────────────────────────────────────────
    Route::get   ('/profil',              [ProfilController::class, 'index']        )->name('profil.index');
    Route::put   ('/profil/infos',        [ProfilController::class, 'updateInfos']  )->name('profil.infos');
    Route::put   ('/profil/password',     [ProfilController::class, 'updatePassword'])->name('profil.password');
    Route::post  ('/profil/avatar',       [ProfilController::class, 'updateAvatar'] )->name('profil.avatar');
    Route::delete('/profil/avatar',       [ProfilController::class, 'deleteAvatar'] )->name('profil.avatar.delete');

    // ── Profil CV ─────────────────────────────────────────────────
    Route::post  ('/profil/cv',        [ProfilController::class, 'uploadCv']  )->name('profil.cv.upload');
    Route::get   ('/profil/cv',        [ProfilController::class, 'downloadCv'])->name('profil.cv.download');
    Route::delete('/profil/cv',        [ProfilController::class, 'deleteCv']  )->name('profil.cv.delete');

    Route::post('/upload/image', [UploadController::class, 'image'])->name('upload.image');

    // ── Maintenance ───────────────────────────────────────────────
    Route::post('/maintenance/toggle', [MaintenanceController::class, 'toggle'])->name('maintenance.toggle');

    Route::prefix('cv-lettre')->name('admin.cv-lettre.')->group(function () {
    Route::get ('/',                        [CvLettreController::class, 'index']          )->name('index');
    Route::get ('/cv/download',             [CvLettreController::class, 'downloadCv']     )->name('cv.download');
    Route::get ('/cv/preview',              [CvLettreController::class, 'previewCv']      )->name('cv.preview');
    Route::post('/cv/infos',                  [CvLettreController::class, 'saveInfos']     )->name('cv.infos.save');
    Route::post('/lettre/generer',          [CvLettreController::class, 'genererLettre']  )->name('lettre.generer');
    Route::get ('/lettre/{lettre}/preview', [CvLettreController::class, 'previewLettre']  )->name('lettre.preview');
    Route::get ('/lettre/{lettre}/pdf',     [CvLettreController::class, 'lettreHtml']     )->name('lettre.pdf-view');
    Route::get ('/lettre/{lettre}/download',[CvLettreController::class, 'downloadLettre'] )->name('lettre.download');
    Route::delete('/lettre/{lettre}',       [CvLettreController::class, 'destroyLettre']  )->name('lettre.destroy');
});

});