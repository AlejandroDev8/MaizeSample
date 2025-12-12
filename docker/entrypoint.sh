#!/usr/bin/env bash
set -euo pipefail

RUN_MIGRATIONS="${RUN_MIGRATIONS:-1}"
RUN_SEEDER="${RUN_SEEDER:-1}"
RUN_INEGI="${RUN_INEGI:-1}"
INEGI_FRESH="${INEGI_FRESH:-1}"

echo "▶️  Iniciando contenedor..."

# 0) Asegurar directorios críticos de Laravel (evita "valid cache path")
mkdir -p \
  storage/framework/cache \
  storage/framework/sessions \
  storage/framework/views \
  bootstrap/cache

# 1) Asegurar .env (dentro del contenedor)
if [[ ! -f ".env" && -f ".env.example" ]]; then
  cp .env.example .env
  echo "✅ .env creado desde .env.example"
fi

# 2) Esperar DB (Postgres) - solo si hay DB_HOST
if [[ -n "${DB_HOST:-}" ]]; then
  echo "⏳ Esperando DB en ${DB_HOST}:${DB_PORT:-5432}..."
  for i in {1..30}; do
    php -r '
      try {
        $host=getenv("DB_HOST"); $port=getenv("DB_PORT") ?: "5432";
        $db=getenv("DB_DATABASE"); $user=getenv("DB_USERNAME"); $pass=getenv("DB_PASSWORD");
        new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
        exit(0);
      } catch (Throwable $e) { exit(1); }
    ' && break

    echo "   ...aún no (${i}/30)"
    sleep 2
    if [[ $i -eq 30 ]]; then
      echo "❌ DB no respondió a tiempo."
      exit 1
    fi
  done
  echo "✅ DB lista"
fi

# 3) APP_KEY (si falta)
if [[ -f ".env" ]]; then
  if ! grep -qE '^APP_KEY=.+$' .env; then
    echo "🔑 Generando APP_KEY..."
    php artisan key:generate --force --no-interaction
  fi
else
  echo "⚠️ No existe .env y no hay .env.example; APP_KEY no se pudo generar."
fi

# 4) Migraciones y seed
if [[ "$RUN_MIGRATIONS" == "1" ]]; then
  echo "🗄️  Ejecutando migraciones..."
  php artisan migrate --force --no-interaction

  if [[ "$RUN_SEEDER" == "1" ]]; then
    echo "🌱 Ejecutando seeders..."
    php artisan db:seed --force --no-interaction
  fi
fi

# 5) Import INEGI
if [[ "$RUN_INEGI" == "1" ]]; then
  if [[ "$INEGI_FRESH" == "1" ]]; then
    echo "🧹 Import INEGI (fresh)..."
    php artisan inegi:import --fresh
  else
    echo "▶️  Import INEGI..."
    php artisan inegi:import
  fi
fi

# 6) Storage link (ignorar si ya existe)
php artisan storage:link --no-interaction || true

echo "✅ Listo. Ejecutando: $*"
exec "$@"
