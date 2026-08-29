-- Banco de dados
CREATE DATABASE IF NOT EXISTS jm_informatica
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE jm_informatica;

-- Tabela de usuários
CREATE TABLE user (
    id_user BIGINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    ativo TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

-- Tabela de serviços
CREATE TABLE service (
    id_service BIGINT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(45) NOT NULL,
    price DECIMAL(11,3) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    finished_at DATETIME DEFAULT NULL,
    commission_user DECIMAL(11,3) DEFAULT NULL,
    user_id BIGINT NOT NULL,

    CONSTRAINT fk_service_user
        FOREIGN KEY (user_id)
        REFERENCES user(id_user)
) ENGINE=InnoDB;

-- Usuários para teste do sistema
INSERT INTO user (
    name,
    email,
    password,
    created_at,
    updated_at,
    ativo
) VALUES
(
    'Administrador JM',
    'admin@jminformatica.com',
    '$2y$10$j0qyJei/MKYYLXDrDhyQUOwZKNmucP1tiqpBK9hS4iH2ziL46fM0W',
    NOW(),
    NOW(),
    1
),
(
    'Técnico Teste',
    'tecnico@jminformatica.com',
    '$2y$10$eq9bOAlQ2IsZWvNGSX9f2.d3a3RQZnmEmB0bHuxPPQnXHTVu0T6DW',
    NOW(),
    NOW(),
    1
);

-- Serviços de exemplo
INSERT INTO service (
    description,
    price,
    created_at,
    updated_at,
    finished_at,
    commission_user,
    user_id
) VALUES
(
    'Formatação de notebook',
    250.000,
    '2026-08-20 09:00:00',
    '2026-08-20 09:00:00',
    NULL,
    NULL,
    1
),
(
    'Instalação de rede Wi-Fi',
    480.500,
    '2026-08-22 14:30:00',
    '2026-08-22 14:30:00',
    NULL,
    NULL,
    2
),
(
    'Manutenção de servidor',
    1500.000,
    '2026-08-15 10:00:00',
    '2026-08-24 17:45:00',
    '2026-08-24 17:45:00',
    150.000,
    1
);