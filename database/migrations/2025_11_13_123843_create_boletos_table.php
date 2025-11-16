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
        Schema::create('boletos', function (Blueprint $table) {
            $table->id();
            $table->string('nome_pagador');
            $table->string('cpf_cnpj_pagador');
            $table->string('nome_beneficiario');
            $table->string('cpf_cnpj_beneficiario');
            $table->decimal('valor', 10, 2);
            $table->date('data_vencimento');
            $table->text('observacao')->nullable();
            $table->foreignId('banco_id')->constrained('bancos')->onDelete('cascade');
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boletos');
    }
};
