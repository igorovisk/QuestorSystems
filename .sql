-- =====================================================
-- Script SQL para QuestorSystem
-- Banco de Dados: PostgreSQL
-- =====================================================
-- 
-- Ordem de execução:
-- 1. Execute este script SQL para criar o banco de dados
-- 2. Configure o .env com as credenciais do banco
-- 3. Execute as migrations: php artisan migrate
-- 4. Execute este script SQL novamente (ou apenas a parte de índices/comentários)
-- 5. Execute os seeders se necessário: php artisan db:seed
-- 6. Configure QUEUE_CONNECTION=redis no .env
-- 7. Certifique-se de que o Redis está rodando
-- =====================================================

-- =====================================================
-- 1. CRIAR BANCO DE DADOS
-- =====================================================
-- 
-- IMPORTANTE: Execute este comando ANTES de rodar as migrations
-- Ajuste o nome do banco conforme necessário
-- =====================================================

-- Criar banco de dados (se não existir)
-- Nota: No PostgreSQL, você precisa estar conectado como superusuário
-- ou ter permissões para criar bancos de dados
CREATE DATABASE questor_system
    WITH 
    OWNER = postgres
    ENCODING = 'UTF8'
    LC_COLLATE = 'en_US.utf8'
    LC_CTYPE = 'en_US.utf8'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1;

-- Comentário no banco de dados
COMMENT ON DATABASE questor_system IS 'Banco de dados do sistema Questor System - Gerenciamento de cobranças';

-- =====================================================
-- 2. CONECTAR AO BANCO CRIADO
-- =====================================================
-- 
-- Após criar o banco, você precisa se conectar a ele
-- antes de executar as migrations ou o restante deste script
-- 
-- No psql:
--   \c questor_system
-- 
-- Ou configure o .env com:
--   DB_DATABASE=questor_system
-- =====================================================

-- IMPORTANTE: Este script contém apenas otimizações e
-- documentação que NÃO são criadas pelas migrations.
--
-- As tabelas devem ser criadas primeiro via migrations:
--   php artisan migrate
--
-- Depois, execute este script para adicionar:
--   - Índices adicionais de otimização
--   - Comentários de documentação nas tabelas
-- =====================================================

-- =====================================================
-- 3. ÍNDICES ADICIONAIS (Otimização)
-- =====================================================
-- 
-- Nota: As migrations criam índices automaticamente para
-- foreign keys, mas estes índices adicionais melhoram
-- a performance em consultas frequentes.
-- =====================================================

-- Índices para filtrar parcelas por status de envio
CREATE INDEX IF NOT EXISTS parcelas_enviado_email_index ON parcelas(enviado_email);
CREATE INDEX IF NOT EXISTS servicos_cobranca_parcelas_geradas_index ON servicos_cobranca(parcelas_geradas);

-- =====================================================
-- 4. COMENTÁRIOS NAS TABELAS (Documentação)
-- =====================================================

-- Tabelas de Negócio
COMMENT ON TABLE clientes IS 'Armazena os clientes do sistema';
COMMENT ON TABLE bancos IS 'Armazena os bancos cadastrados';
COMMENT ON TABLE boletos IS 'Armazena os boletos de cobrança';
COMMENT ON TABLE servicos_cobranca IS 'Armazena os serviços de cobrança parcelados';
COMMENT ON TABLE parcelas IS 'Armazena as parcelas geradas para cada serviço de cobrança';

-- Tabelas do Laravel
COMMENT ON TABLE job_batches IS 'Armazena informações sobre lotes de jobs (usado com Redis)';
COMMENT ON TABLE failed_jobs IS 'Armazena jobs que falharam durante o processamento';
COMMENT ON TABLE sessions IS 'Sessões de usuários do Laravel';
COMMENT ON TABLE cache IS 'Cache do Laravel';
COMMENT ON TABLE cache_locks IS 'Locks do sistema de cache do Laravel';
