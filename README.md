## 🚀 Como Executar o Projeto

### Pré-requisitos

1. **PHP 8.2+**
2. **Composer** (gerenciador de dependências PHP)
3. **PostgreSQL** (banco de dados)
4. **Redis** (para filas)
5. **Node.js** (para frontend)

### Passo a Passo

#### 1. Instalar Dependências

```bash
composer install
npm install
```

#### 2. Configurar Ambiente

```bash
cp .env.example .env
php artisan key:generate
```

**Editar `.env`**:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=questor_system
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha

QUEUE_CONNECTION=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

#### 3. Criar Banco de Dados

```sql
CREATE DATABASE questor_system;
```

#### 4. Executar Migrations

```bash
php artisan migrate
```

#### 5. Popular Banco (Opcional)

```bash
php artisan db:seed
```

#### 6. Iniciar Servidor

```bash
php artisan serve
```

#### 7. Iniciar Horizon (Processa Jobs)

```bash
php artisan horizon
```

**O que faz**: Processa jobs da fila (gera parcelas e envia emails)

**Acesse**: `http://localhost:8000/horizon` para monitorar

> **Nota**: Horizon substitui `queue:work` e oferece interface web para monitoramento.

#### 8. Iniciar Scheduler (Executa Comandos Agendados)

```bash
php artisan schedule:work
```

**O que faz**: Executa comandos agendados (dispara jobs à meia-noite)

**Importante**: Este comando é necessário para que os emails sejam enviados à meia-noite conforme requisito.

---

### ✅ Comandos que DEVEM estar rodando:

1. **Servidor Web**: `php artisan serve` (ou Apache/Nginx)
2. **Horizon**: `php artisan horizon` (processa jobs)
3. **Scheduler**: `php artisan schedule:work` (executa à meia-noite)

---

Acesse: `http://localhost:8000`
