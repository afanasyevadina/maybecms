<?php

use Altenic\MaybeCms\Models\PostType;
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
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('attachable_id')->nullable();
            $table->string('attachable_type', 255)->nullable();
            $table->foreignIdFor(PostType::class)->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('type', 255)->nullable();
            $table->string('slug', 255)->nullable();
            $table->string('title', 255)->nullable();
            $table->text('content')->nullable();
            $table->text('query')->nullable();
            $table->boolean('active')->default(1);
            $table->integer('order')->default(1);
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
        Schema::dropIfExists('blocks');
    }
};
