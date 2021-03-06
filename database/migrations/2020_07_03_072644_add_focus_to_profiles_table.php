<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class AddFocusToProfilesTable
 */
class AddFocusToProfilesTable extends Migration // @codingStandardsIgnoreLine
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('profiles', static function (Blueprint $table) {
            $table->string('focus')->nullable();
            $table->float('rating')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('profiles', static function (Blueprint $table) {
            $table->dropColumn('focus');
            $table->dropColumn('rating');
        });
    }
}
