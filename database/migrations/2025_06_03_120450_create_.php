<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabela principal: Requisições de compra
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained('users')->onDelete('cascade');
            $table->string('description')->nullable();
            $table->date('date_delivery')->nullable();
            $table->tinyInteger('status_approval')->default(1)->comment('1: pendente, 2: aprovado, 3: rejeitado, 4: concluído');
            $table->text('observations')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        // Itens da requisição
        Schema::create('purchase_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_request_id')->constrained('purchase_requests')->onDelete('cascade');
            $table->string('code')->nullable();
            $table->string('name_item');
            $table->string('mark')->nullable();
            $table->text('description_details')->nullable();
            $table->text('specifications_techniques')->nullable();
            $table->string('photo')->nullable();
            $table->string('link_references')->nullable();
            $table->decimal('quantity', 10, 2);
            $table->string('unit')->default('un');
            $table->enum('priority', ['alta', 'media', 'baixa'])->default('media');
            $table->string('second_option')->nullable();
            $table->boolean('need_bugdet')->default(true);
            $table->decimal('price_predicted', 12, 2)->nullable();
            $table->text('justification')->nullable();
            $table->text('supplier_suggested')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Relacionamento entre usuários e requisição
        Schema::create('purchase_request_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_request_id')->constrained('purchase_requests')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        // Aprovações
        Schema::create('purchase_request_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_request_id')->constrained('purchase_requests')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->tinyInteger('aprovacao')->default(0); // 0 = pendente, 1 = aprovado, 2 = reprovado
            $table->text('comments')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->string('approval_type')->nullable();
            $table->string('approval_level')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Relação entre centro de custo e requisição
        Schema::create('purchase_request_center_sector', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cost_center_id')->constrained('cost_center')->onDelete('cascade');
            $table->foreignId('purchase_request_id')->constrained('purchase_requests')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        // Relação entre empresa e requisição
        Schema::create('purchase_request_company', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('company')->onDelete('cascade');
            $table->foreignId('purchase_request_id')->constrained('purchase_requests')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_request_company');
        Schema::dropIfExists('purchase_request_center_sector');
        Schema::dropIfExists('purchase_request_approvals');
        Schema::dropIfExists('purchase_request_user');
        Schema::dropIfExists('purchase_request_items');
        Schema::dropIfExists('purchase_requests');
    }
};
