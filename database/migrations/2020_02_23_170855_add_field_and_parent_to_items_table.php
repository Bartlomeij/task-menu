<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldAndParentToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->unsignedInteger('menu_id')->nullable()->after('id');
            $table->unsignedInteger('parent_id')->nullable()->after('menu_id');
            $table->string('field')->nullable()->after('parent_id');
        });

        // not sure how to add foreign keys in Eloquent
//        Schema::table('items', function (Blueprint $table) {
//            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
//            $table->foreign('parent_id')->references('id')->on('items')->onDelete('cascade');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn(['field', 'parent_id', 'menu_id']);
        });
    }
}
