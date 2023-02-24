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
        Schema::create('block_posts', function (Blueprint $table) {
            $table->id();
            $table->integer('block_id')->nullable();
            $table->integer('post_id')->nullable();
            $table->foreignIdFor(PostType::class)->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('block_posts');
    }
};
