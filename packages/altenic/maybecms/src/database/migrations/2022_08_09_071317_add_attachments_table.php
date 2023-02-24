<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->foreignIdFor(\Altenic\MaybeCms\Models\File::class)->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('attachable_id')->nullable();
            $table->string('attachable_type', 255)->nullable();
            $table->string('role', 255)->nullable();
            $table->string('alt', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attachments');
    }
};
