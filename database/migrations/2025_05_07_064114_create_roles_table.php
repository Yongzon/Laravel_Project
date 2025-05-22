<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->String('name');
            $table->timestamps();
        });

        $roles = [
            ['name' => 'Employee'],
            ['name' => 'Evaluator'],
            ['name' => 'Hr Manager'],
            ['name' => 'Admin'],
        ];

        foreach($roles as $role) {
            Role::create($role);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
