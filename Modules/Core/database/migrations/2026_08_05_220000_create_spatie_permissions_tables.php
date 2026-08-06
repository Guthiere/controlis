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
        $this->createPermissionCrudTables();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Resetting the permission to default state
        Schema::dropIfExists('model_has_permissions');
        Schema::dropIfExists('model_has_roles');
        Schema::dropIfExists('model_permission_closures');
        Schema::dropIfExists('role_has_permissions');
        Schema::dropIfExists('role_has_model');
        Schema::dropIfExists('permission_has_roles');
        Schema::dropIfExists('permission_has_model');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }

    /**
     * Get a blueprint of the permission tables.
     */
    private function createPermissionCrudTables(): void
    {
        Schema::create('permission_has_role', function (Blueprint $table) {
            $table->string('permission');
            $table->string('role');
            $table->index(['permission', 'role'], 'permission_role_index');
            $table->index(['role', 'permission'], 'role_permission_index');
        });

        Schema::create('model_has_permissions', function (Blueprint $table) {
            $table->string('permission');
            $table->morphs('model');
            $table->index(['permission', 'model'], 'permission_model_index');
            $table->index(['model', 'permission'], 'model_permission_index');
        });

        Schema::create('model_has_roles', function (Blueprint $table) {
            $table->string('role');
            $table->morphs('model');
            $table->index(['role', 'model'], 'role_model_index');
            $table->index(['model', 'role'], 'model_role_index');
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create('role_has_permissions', function (Blueprint $table) {
            $table->integer('permission_id');
            $table->integer('role_id');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });

        Schema::create('permission_has_roles', function (Blueprint $table) {
            $table->integer('permission_id');
            $table->integer('role_id');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }
};
