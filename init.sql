-- --------------------------------------------------------------
-- Script de criação da tabela 'users'
-- Esta tabela armazena informações básicas dos usuários do sistema
-- --------------------------------------------------------------

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Chave primária única que identifica cada usuário
    name VARCHAR(100) NOT NULL,        -- Nome do usuário (campo obrigatório)
    email VARCHAR(100) NOT NULL,       -- Endereço de email do usuário (campo obrigatório)
    situacao VARCHAR(50) NOT NULL,     -- Situação do usuário (Ativo/Inativo, por exemplo)
    data_admissao DATE NOT NULL,       -- Data de admissão do usuário (campo obrigatório)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Data e hora de criação do registro
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP -- Data e hora da última atualização
);

-- --------------------------------------------------------------
-- Fim do script de criação da tabela 'users'
-- --------------------------------------------------------------
