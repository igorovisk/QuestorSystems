<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('servicos_cobranca', function (Blueprint $table) {
            $table->id();
            $table->string('nome_servico');
            $table->decimal('valor_total', 10, 2);
            $table->integer('quantidade_parcelas');
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('banco_id')->constrained('bancos')->onDelete('cascade');
            $table->boolean('parcelas_geradas')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicos_cobranca');
    }
};
