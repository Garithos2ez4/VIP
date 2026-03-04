-- ===========================================================================
--  VIP2CARS – Anonymous Surveys Schema (Part 1: ER Model)
--  Generated for the technical test
--  Compatible with: MySQL 8+ / MariaDB 10.6+ / SQLite 3.35+
-- ===========================================================================

-- ── surveys ──────────────────────────────────────────────────────────────────
CREATE TABLE surveys (
    id          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    title       VARCHAR(200)    NOT NULL,
    description TEXT            NULL,
    is_active   TINYINT(1)      NOT NULL DEFAULT 1,
    starts_at   DATETIME        NULL,
    ends_at     DATETIME        NULL,
    created_at  DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── questions ─────────────────────────────────────────────────────────────────
-- Each survey has one or more questions.
-- type: 'single' = one option, 'multiple' = many options, 'text' = free text
CREATE TABLE questions (
    id            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    survey_id     BIGINT UNSIGNED NOT NULL,
    question_text TEXT            NOT NULL,
    type          ENUM('single','multiple','text') NOT NULL DEFAULT 'single',
    `order`       SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    is_required   TINYINT(1) NOT NULL DEFAULT 1,
    created_at    DATETIME   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at    DATETIME   NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    CONSTRAINT fk_questions_survey
        FOREIGN KEY (survey_id) REFERENCES surveys(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── options ───────────────────────────────────────────────────────────────────
-- Predefined choices for 'single' and 'multiple' type questions.
CREATE TABLE options (
    id           BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    question_id  BIGINT UNSIGNED NOT NULL,
    option_text  VARCHAR(255)    NOT NULL,
    `order`      SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    created_at   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    CONSTRAINT fk_options_question
        FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── responses ─────────────────────────────────────────────────────────────────
-- One row per survey submission. No link to a users table → fully anonymous.
-- anonymous_token: UUID generated per submission to prevent double-submit.
CREATE TABLE responses (
    id              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    survey_id       BIGINT UNSIGNED NOT NULL,
    anonymous_token CHAR(36)        NOT NULL,   -- UUID v4
    submitted_at    DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created_at      DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_responses_token (anonymous_token),
    CONSTRAINT fk_responses_survey
        FOREIGN KEY (survey_id) REFERENCES surveys(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── answers ───────────────────────────────────────────────────────────────────
-- Each answer belongs to a response and a question.
-- For 'single'/'multiple': option_id is set, answer_text is NULL.
-- For 'text': option_id is NULL, answer_text holds the free-text reply.
CREATE TABLE answers (
    id          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    response_id BIGINT UNSIGNED NOT NULL,
    question_id BIGINT UNSIGNED NOT NULL,
    option_id   BIGINT UNSIGNED NULL,
    answer_text TEXT NULL,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    CONSTRAINT fk_answers_response
        FOREIGN KEY (response_id) REFERENCES responses(id) ON DELETE CASCADE,
    CONSTRAINT fk_answers_question
        FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE,
    CONSTRAINT fk_answers_option
        FOREIGN KEY (option_id) REFERENCES options(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===========================================================================
--  VIP2CARS – Vehicles & Clients Schema (Part 2: CRUD)
-- ===========================================================================

-- ── clients ───────────────────────────────────────────────────────────────────
CREATE TABLE clients (
    id              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre          VARCHAR(100)    NOT NULL,
    apellidos       VARCHAR(150)    NOT NULL,
    nro_documento   VARCHAR(20)     NOT NULL,
    correo          VARCHAR(150)    NOT NULL,
    telefono        VARCHAR(20)     NOT NULL,
    created_at      DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at      DATETIME        NULL,        -- soft delete
    PRIMARY KEY (id),
    UNIQUE KEY uq_clients_documento (nro_documento),
    UNIQUE KEY uq_clients_correo    (correo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── vehicles ──────────────────────────────────────────────────────────────────
CREATE TABLE vehicles (
    id               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    placa            VARCHAR(20)     NOT NULL,
    marca            VARCHAR(80)     NOT NULL,
    modelo           VARCHAR(100)    NOT NULL,
    anio_fabricacion SMALLINT        NOT NULL,
    client_id        BIGINT UNSIGNED NOT NULL,
    created_at       DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at       DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at       DATETIME        NULL,        -- soft delete
    PRIMARY KEY (id),
    UNIQUE KEY uq_vehicles_placa (placa),
    INDEX idx_vehicles_marca  (marca),
    CONSTRAINT fk_vehicles_client
        FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
