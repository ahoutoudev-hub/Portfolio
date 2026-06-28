#!/bin/bash
# Script de déploiement — À exécuter via le Terminal cPanel
# Chemin: ~/public_html/ahoutou.orthogonal.ci/

echo "=== Déploiement Portfolio AHOUTOU ==="

# 1. Installer les dépendances PHP (sans dev)
echo "[1/6] Installation des dépendances Composer..."
composer install --no-dev --optimize-autoloader --no-interaction

# 2. Copier le .env de production (si pas déjà fait)
if [ ! -f .env ]; then
  cp .env.production .env
  echo "[2/6] Fichier .env créé — PENSE À REMPLIR LES VARIABLES DB !"
else
  echo "[2/6] .env déjà présent."
fi

# 3. Générer la clé app (si vide)
php artisan key:generate --no-interaction

# 4. Optimiser pour la production
echo "[3/6] Optimisation Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Lien symbolique storage → public/storage
echo "[4/6] Création du lien storage..."
php artisan storage:link

# 6. Permissions dossiers d'écriture
echo "[5/6] Permissions..."
chmod -R 775 storage bootstrap/cache

echo ""
echo "=== Déploiement terminé ! ==="
echo "⚠  N'oublie pas d'importer portfolio.sql dans la base de données cPanel."
