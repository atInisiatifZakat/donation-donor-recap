<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donors', function (Blueprint $table): void {
            $table->uuid('id');
            $table->uuid('employee_id');
            $table->uuid('branch_id');
            $table->uuid('partner_id')->nullable();
            $table->string('identification_number', '36')->unique();
            $table->string('name', 145);
            $table->string('email', 145)->nullable();
            $table->string('address', 255)->nullable();
            $table->integer('regency_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('province_id')->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->integer('donor_phone_id')->nullable();
            $table->integer('edonation_id')->nullable();
            $table->json('notification_channels')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->primary('id');
        });

        Schema::create('donor_phones', function (Blueprint $table): void {
            $table->increments('id');
            $table->uuid('donor_id');
            $table->char('number', 25);
            $table->string('type', 15);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('branches', function (Blueprint $table): void {
            $table->uuid('id');
            $table->string('name', 191);
            $table->string('address')->nullable();
            $table->unsignedInteger('regency_id')->nullable();
            $table->unsignedInteger('city_id')->nullable();
            $table->unsignedInteger('province_id')->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->string('phone_number', 25)->nullable();
            $table->boolean('is_head_office')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->primary('id');
        });

        Schema::create('employees', function (Blueprint $table): void {
            $table->uuid('id');
            $table->uuid('branch_id');
            $table->uuid('partner_id')->nullable();
            $table->string('name', 145);
            $table->string('email', 145);
            $table->string('address', 255);
            $table->integer('regency_id');
            $table->integer('city_id');
            $table->integer('province_id');
            $table->string('postal_code', 10);
            $table->integer('employee_phone_id')->nullable();
            $table->boolean('is_marketer');
            $table->softDeletes();
            $table->timestamps();

            $table->primary('id');
        });
    }

    public function down(): void
    {
        // Schema::dropIfExists('donors');
    }
};
