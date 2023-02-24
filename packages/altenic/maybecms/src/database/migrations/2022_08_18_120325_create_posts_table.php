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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->foreignIdFor(PostType::class)->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('slug', 255)->nullable();
            $table->string('title', 255)->nullable();
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('posts');
    }
};
