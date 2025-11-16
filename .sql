-- =====================================================
-- Script SQL para QuestorSystem
-- Banco de Dados: PostgreSQL
-- =====================================================
-- 

-- Ordem de execução:
-- 1. Execute as migrations: php artisan migrate
-- 2. Execute este script SQL
-- 3. Execute os seeders se necessário: php artisan db:seed
-- 4. Configure o .env com as credenciais do banco
-- 5. Configure QUEUE_CONNECTION=redis no .env
-- 6. Certifique-se de que o Redis está rodando
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
-- 1. ÍNDICES ADICIONAIS (Otimização)
-- =====================================================
-- 
-- Nota: As migrations criam índices automaticamente para
-- foreign keys, mas estes índices adicionais melhoram
-- a performance em consultas frequentes.
-- =====================================================

-- Índices para filtrar parcelas por status de envio
CREATE INDEX IF NOT EXISTS parcelas_enviado_email_index ON parcelas(enviado_email);
CREATE INDEX IF NOT EXISTS servicos_cobranca_parcelas_geradas_index ON servicos_cobranca(parcelas_geradas);

-- Comentários nas tabelas
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
