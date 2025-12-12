-- Archivo SQL generado desde las migraciones de Laravel
-- Sistema de inventariado para la recolección de muestras de maíz
-- Crear tabla users
CREATE TABLE
    users (
        id BIGSERIAL PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        email_verified_at TIMESTAMP NULL,
        password VARCHAR(255) NOT NULL,
        remember_token VARCHAR(100) NULL,
        role VARCHAR(13) DEFAULT 'Recolector' CHECK (role IN ('Administrador', 'Recolector')),
        phone VARCHAR(255) NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    );

-- Crear tabla password_reset_tokens
CREATE TABLE
    password_reset_tokens (
        email VARCHAR(255) PRIMARY KEY,
        token VARCHAR(255) NOT NULL,
        created_at TIMESTAMP NULL
    );

-- Crear tabla sessions
CREATE TABLE
    sessions (
        id VARCHAR(255) PRIMARY KEY,
        user_id BIGINT NULL,
        ip_address VARCHAR(45) NULL,
        user_agent TEXT NULL,
        payload TEXT NOT NULL,
        last_activity INTEGER NOT NULL
    );

CREATE INDEX sessions_user_id_index ON sessions (user_id);

CREATE INDEX sessions_last_activity_index ON sessions (last_activity);

-- Crear tabla cache
CREATE TABLE
    cache (
        key VARCHAR(255) PRIMARY KEY,
        value TEXT NOT NULL,
        expiration INTEGER NOT NULL
    );

-- Crear tabla cache_locks
CREATE TABLE
    cache_locks (
        key VARCHAR(255) PRIMARY KEY,
        owner VARCHAR(255) NOT NULL,
        expiration INTEGER NOT NULL
    );

-- Crear tabla jobs
CREATE TABLE
    jobs (
        id BIGSERIAL PRIMARY KEY,
        queue VARCHAR(255) NOT NULL,
        payload TEXT NOT NULL,
        attempts SMALLINT NOT NULL,
        reserved_at INTEGER NULL,
        available_at INTEGER NOT NULL,
        created_at INTEGER NOT NULL
    );

CREATE INDEX jobs_queue_index ON jobs (queue);

-- Crear tabla job_batches
CREATE TABLE
    job_batches (
        id VARCHAR(255) PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        total_jobs INTEGER NOT NULL,
        pending_jobs INTEGER NOT NULL,
        failed_jobs INTEGER NOT NULL,
        failed_job_ids TEXT NOT NULL,
        options TEXT NULL,
        cancelled_at INTEGER NULL,
        created_at INTEGER NOT NULL,
        finished_at INTEGER NULL
    );

-- Crear tabla failed_jobs
CREATE TABLE
    failed_jobs (
        id BIGSERIAL PRIMARY KEY,
        uuid VARCHAR(255) UNIQUE NOT NULL,
        connection TEXT NOT NULL,
        queue TEXT NOT NULL,
        payload TEXT NOT NULL,
        exception TEXT NOT NULL,
        failed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

-- Crear tabla states
CREATE TABLE
    states (
        id BIGSERIAL PRIMARY KEY,
        cve_ent CHAR(2) UNIQUE NOT NULL,
        name VARCHAR(100) NOT NULL,
        abbreviation VARCHAR(50) NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    );

CREATE INDEX states_name_index ON states (name);

-- Crear tabla municipalities
CREATE TABLE
    municipalities (
        id BIGSERIAL PRIMARY KEY,
        state_id BIGINT NOT NULL REFERENCES states (id) ON DELETE CASCADE,
        cve_mun CHAR(3) NOT NULL,
        cve_geo CHAR(5) NOT NULL,
        name VARCHAR(150) NOT NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL,
        UNIQUE (state_id, cve_mun)
    );

CREATE INDEX municipalities_state_id_cve_mun_index ON municipalities (state_id, cve_mun);

CREATE INDEX municipalities_cve_geo_index ON municipalities (cve_geo);

-- Crear tabla localities
CREATE TABLE
    localities (
        id BIGSERIAL PRIMARY KEY,
        municipality_id BIGINT NOT NULL REFERENCES municipalities (id) ON DELETE CASCADE,
        cve_loc CHAR(4) NOT NULL,
        cve_geo CHAR(9) NOT NULL,
        name VARCHAR(255) NOT NULL,
        urban_area BOOLEAN NULL,
        lat DECIMAL(10, 6) NULL,
        lng DECIMAL(10, 6) NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL,
        UNIQUE (municipality_id, cve_loc)
    );

CREATE INDEX localities_municipality_id_name_index ON localities (municipality_id, name);

CREATE INDEX localities_cve_geo_index ON localities (cve_geo);

-- Crear tabla farmers
CREATE TABLE
    farmers (
        id BIGSERIAL PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        phone VARCHAR(255) NULL,
        state_id BIGINT NOT NULL REFERENCES states (id) ON DELETE CASCADE,
        municipality_id BIGINT NOT NULL REFERENCES municipalities (id) ON DELETE CASCADE,
        locality_id BIGINT NOT NULL REFERENCES localities (id) ON DELETE CASCADE,
        address TEXT NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    );

-- Crear tabla maize_samples
CREATE TABLE
    maize_samples (
        id BIGSERIAL PRIMARY KEY,
        user_id BIGINT NOT NULL REFERENCES users (id) ON DELETE CASCADE,
        farmer_id BIGINT NOT NULL REFERENCES farmers (id) ON DELETE CASCADE,
        state_id BIGINT NOT NULL REFERENCES states (id) ON DELETE CASCADE,
        municipality_id BIGINT NOT NULL REFERENCES municipalities (id) ON DELETE CASCADE,
        locality_id BIGINT NOT NULL REFERENCES localities (id) ON DELETE CASCADE,
        sample_number INTEGER NULL,
        collection_date DATE NULL,
        latitude DECIMAL(10, 6) NULL,
        longitude DECIMAL(10, 6) NULL,
        variety_name VARCHAR(255) NULL,
        notes TEXT NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL,
        CONSTRAINT mx_sample_unique_idx UNIQUE (municipality_id, locality_id, sample_number)
    );

CREATE INDEX maize_samples_user_id_collection_date_index ON maize_samples (user_id, collection_date);

-- Crear tabla maize_sub_samples
CREATE TABLE
    maize_sub_samples (
        id BIGSERIAL PRIMARY KEY,
        maize_sample_id BIGINT NOT NULL REFERENCES maize_samples (id) ON DELETE CASCADE,
        subsample_number BIGINT NOT NULL,
        color_grano VARCHAR(255) NULL,
        color_olote VARCHAR(255) NULL,
        tipo_grano VARCHAR(255) NULL,
        forma_corona_grano VARCHAR(255) NULL,
        color_dorsal_grano VARCHAR(255) NULL,
        color_endospermo_grano VARCHAR(255) NULL,
        arreglo_hileras_grano VARCHAR(255) NULL,
        diametro_mazorca_mm DECIMAL(6, 2) NULL,
        largo_mazorca_mm DECIMAL(6, 2) NULL,
        peso_mazorca_g DECIMAL(7, 2) NULL,
        peso_grano_50_g DECIMAL(7, 2) NULL,
        num_hileras INTEGER NULL,
        num_granos_por_hilera INTEGER NULL,
        grosor_grano_mm DECIMAL(6, 2) NULL,
        ancho_grano_mm DECIMAL(6, 2) NULL,
        longitud_grano_mm DECIMAL(6, 2) NULL,
        indice_lgr_agr DECIMAL(6, 3) NULL,
        volumen_grano_50_ml DECIMAL(7, 2) NULL,
        image_path VARCHAR(255) NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    );

-- Crear tabla migrations (sistema Laravel)
CREATE TABLE
    migrations (
        id SERIAL PRIMARY KEY,
        migration VARCHAR(255) NOT NULL,
        batch INTEGER NOT NULL
    );

-- Insertar registros de migraciones
INSERT INTO
    migrations (migration, batch)
VALUES
    ('0001_01_01_000000_create_users_table', 1),
    ('0001_01_01_000001_create_cache_table', 1),
    ('0001_01_01_000002_create_jobs_table', 1),
    ('2025_11_02_225436_add_fields_to_users_table', 1),
    ('2025_11_02_233045_create_states_table', 1),
    (
        '2025_11_02_233151_create_municipalities_table',
        1
    ),
    ('2025_11_02_233311_create_localities_table', 1),
    ('2025_11_24_151720_create_farmers_table', 1),
    ('2025_11_24_155906_create_maize_samples_table', 1),
    (
        '2025_11_24_160254_create_maize_sub_samples_table',
        1
    );