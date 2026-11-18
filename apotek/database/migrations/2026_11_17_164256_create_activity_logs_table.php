<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('user_name', 150)->nullable();
            $table->string('username', 100)->nullable();

            $table->unsignedBigInteger('branch_id')->nullable();

            $table->string('module', 50);
            $table->string('activity', 30);
            $table->string('description', 255);

            $table->string('subject_type', 150)->nullable();
            $table->string('subject_id', 100)->nullable();

            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->json('properties')->nullable();

            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();

            $table->string('request_id', 64)->nullable();
            $table->string('route', 255)->nullable();
            $table->string('method', 10)->nullable();

            $table->string('status', 20)->default('SUCCESS');

            $table->timestamp('created_at')->useCurrent();

            $table->index(['user_id', 'created_at']);
            $table->index(['branch_id', 'created_at']);
            $table->index(['module', 'created_at']);
            $table->index(['activity', 'created_at']);
            $table->index(['subject_type', 'subject_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
}
