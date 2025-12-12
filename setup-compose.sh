#!/usr/bin/env bash
set -euo pipefail

COMPOSE="docker compose"
APP_SERVICE="laravel.test"
DB_SERVICE="pgsql"

# =========================
# Config INEGI
# =========================
INEGI_RUN="${INEGI_RUN:-1}"        # 1 = ejecutar import, 0 = saltar
INEGI_FRESH="${INEGI_FRESH:-1}"    # 1 = usar --fresh, 0 = sin --fresh

pause() { echo; read -r -p "Presiona ENTER para continuar..."; }
title() {
  echo
  echo "============================================================"
  echo "$1"
  echo "============================================================"
}

title "0) Pre-chequeos"

if ! command -v docker >/dev/null 2>&1; then
  echo "❌ Docker no está instalado o no está en PATH."
  exit 1
fi

if ! $COMPOSE version >/dev/null 2>&1; then
  echo "❌ Docker Compose v2 no está disponible (usa: docker compose)."
  exit 1
fi

if [[ ! -f "compose.yaml" && ! -f "docker-compose.yml" && ! -f "docker-compose.yaml" ]]; then
  echo "❌ No encontré compose.yaml / docker-compose.yml en este directorio."
  echo "   Ejecuta este script desde la raíz del proyecto."
  exit 1
fi

if ! $COMPOSE config --services | grep -qx "$APP_SERVICE"; then
  echo "❌ No existe el servicio '$APP_SERVICE' en tu compose."
  echo "Servicios encontrados:"
  $COMPOSE config --services | sed 's/^/ - /'
  exit 1
fi

echo "✅ Docker + Compose OK. Servicio app: $APP_SERVICE"
pause

title "1) Preparando .env"

if [[ ! -f ".env" ]]; then
  if [[ -f ".env.example" ]]; then
    cp .env.example .env
    echo "✅ Creado .env desde .env.example"
  else
    echo "❌ No existe .env ni .env.example."
    exit 1
  fi
else
  echo "✅ .env ya existe (no se modificó)."
fi

# Ajustes mínimos para Sail + Postgres
if grep -qE '^DB_CONNECTION=' .env; then
  sed -i 's/^DB_CONNECTION=.*/DB_CONNECTION=pgsql/' .env || true
else
  echo "DB_CONNECTION=pgsql" >> .env
fi

if grep -qE '^DB_HOST=' .env; then
  sed -i 's/^DB_HOST=.*/DB_HOST=pgsql/' .env || true
else
  echo "DB_HOST=pgsql" >> .env
fi

echo "✅ DB_CONNECTION=pgsql y DB_HOST=pgsql (Sail/Postgres)."
pause

title "2) Levantando contenedores"
$COMPOSE up -d
echo "✅ Contenedores arriba."
pause

title "3) Esperando a Postgres (pg_isready)"
for i in {1..30}; do
  if $COMPOSE exec -T "$DB_SERVICE" pg_isready -q >/dev/null 2>&1; then
    echo "✅ Postgres listo."
    break
  fi

  echo "⏳ Postgres aún no está listo... ($i/30)"
  sleep 2

  if [[ $i -eq 30 ]]; then
    echo "❌ Postgres no respondió a tiempo."
    echo "   Revisa logs: docker compose logs -f $DB_SERVICE"
    exit 1
  fi
done
pause

title "4) Instalando dependencias PHP (composer install)"
$COMPOSE exec -T "$APP_SERVICE" composer install --no-interaction
echo "✅ Composer install listo."
pause

title "5) Generando APP_KEY (solo si falta)"
if grep -qE '^APP_KEY=$' .env || ! grep -qE '^APP_KEY=' .env; then
  $COMPOSE exec -T "$APP_SERVICE" php artisan key:generate --no-interaction
  echo "✅ APP_KEY generado."
else
  echo "✅ APP_KEY ya existe, no se tocó."
fi
pause

title "6) Migraciones y seeds"
$COMPOSE exec -T "$APP_SERVICE" php artisan migrate --seed --no-interaction
echo "✅ Migraciones/seed completados."
pause

title "7) Importar catálogo INEGI (San Luis Potosí únicamente)"

if [[ "$INEGI_RUN" == "1" ]]; then
  if [[ "$INEGI_FRESH" == "1" ]]; then
    echo "🧹 Ejecutando: php artisan inegi:import --fresh"
    $COMPOSE exec -T "$APP_SERVICE" php artisan inegi:import --fresh
  else
    echo "▶️ Ejecutando: php artisan inegi:import"
    $COMPOSE exec -T "$APP_SERVICE" php artisan inegi:import
  fi
  echo "✅ Import INEGI completado."
else
  echo "⏭️ INEGI import desactivado (INEGI_RUN=0)."
fi
pause

title "8) Storage link"
$COMPOSE exec -T "$APP_SERVICE" php artisan storage:link --no-interaction || true
echo "✅ storage:link listo (si ya existía, se ignoró)."
pause

title "9) Instalando dependencias frontend (npm install)"
$COMPOSE exec -T "$APP_SERVICE" npm install
echo "✅ npm install listo."
pause

title "10) Ejecutando Vite (npm run dev)"
echo "⚠️ Este comando se queda corriendo. CTRL+C para detenerlo."
echo "   App:  http://localhost:${APP_PORT:-80}"
echo "   Vite: http://localhost:${VITE_PORT:-5173}"
pause

$COMPOSE exec "$APP_SERVICE" npm run dev -- --host 0.0.0.0
