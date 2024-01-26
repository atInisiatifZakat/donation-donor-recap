<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donation_recap_templates', static function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('disk', 50);
            $table->string('suffix_file_path');
            $table->string('prefix_file_path');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('donation_recaps', static function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignId('template_id')
                ->constrained('donation_recap_templates')
                ->restrictOnUpdate()
                ->restrictOnDelete();
            $table->date('start_at');
            $table->date('end_at');
            $table->unsignedInteger('count_total')->default(0);
            $table->unsignedInteger('count_progress')->default(0);
            $table->timestamp('last_send_at')->nullable();
            $table->string('state', 100);
            $table->timestamps();
        });

        Schema::create('donation_recap_details', static function (Blueprint $table): void {
            $table->uuid('id')->primary();

            $table->foreignUuid('donation_recap_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->date('donation_transaction_date');

            $table->string('donation_identification_number');
            $table->string('donation_funding_category_id');
            $table->string('donation_funding_category_name');
            $table->string('donation_funding_type_name');
            $table->string('donation_program_name')->nullable();

            $table->decimal('donation_amount', 18);

            $table->foreignUuid('donor_id')
                ->constrained('donors')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignUuid('donation_id')
                ->constrained('donations')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('donation_recap_histories', static function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('donation_recap_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignUuid('donor_id')
                ->nullable()
                ->constrained('donors')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->longText('description')->nullable();
            $table->timestamps();
        });

        Schema::create('donation_recap_donors', static function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('donation_recap_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignUuid('donor_id')
                ->constrained('donors')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('donor_name');
            $table->string('donor_identification_number', 36);
            $table->string('donor_phone_number', 100)->nullable();
            $table->string('donor_tax_number', 100)->nullable();
            $table->text('donor_address')->nullable();
            $table->string('state', 100)->nullable();
            $table->string('disk', 20)->nullable();
            $table->string('file_path')->nullable();
            $table->string('result_disk')->nullable();
            $table->string('result_file_path')->nullable();
            $table->timestamp('sms_sending_at')->nullable();
            $table->timestamp('email_sending_at')->nullable();
            $table->timestamp('whatsapp_sending_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donation_recap_donors');
        Schema::dropIfExists('donation_recap_histories');
        Schema::dropIfExists('donation_recap_details');
        Schema::dropIfExists('donation_recaps');
        Schema::dropIfExists('donation_recap_templates');
    }
};
