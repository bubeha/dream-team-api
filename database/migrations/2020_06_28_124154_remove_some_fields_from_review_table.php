<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class RemoveSomeFieldsFromReviewTable
 */
class RemoveSomeFieldsFromReviewTable extends Migration // @codingStandardsIgnoreLine
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('reviews', static function (Blueprint $table) {
            $table->dropColumn('strong_personal_characteristics');
            $table->dropColumn('weak_sides');
            $table->dropColumn('other_comments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('reviews', static function (Blueprint $table) {
            $table->text('strong_personal_characteristics');
            $table->text('weak_sides');
            $table->text('other_comments');
        });
    }
}
