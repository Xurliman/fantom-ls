<?php

use App\Models\Store;
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
        Schema::create('content_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Store::class);
            $table->string('path');
            $table->enum('status', ['pending_update', 'update_installed'])->default('pending_update');
            $table->dateTime('update_installed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_updates');
    }
};
