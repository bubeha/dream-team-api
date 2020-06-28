<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class AddReviewAttributesTable
 */
class AddReviewAttributesTable extends Migration // @codingStandardsIgnoreLine
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('review_attributes', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('value');
            $table->foreignId('review_id')
                ->references('id')
                ->on('reviews')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('review_attributes');
    }
}
