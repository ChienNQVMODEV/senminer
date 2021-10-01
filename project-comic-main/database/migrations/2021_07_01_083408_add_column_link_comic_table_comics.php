<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnLinkComicTableComics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comics', function (Blueprint $table) {
            $table->text('comic_link')->after('avatar');
            $table->integer('id_check')->after('avatar')->nullable();
            $table->integer('chapter_count')->after('avatar')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comics', function (Blueprint $table) {
            $table->dropColumn('comic_link');
            $table->dropColumn('id_check');
            $table->dropColumn('chapter_count');
        });
    }
}
