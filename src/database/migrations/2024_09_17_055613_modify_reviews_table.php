<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            // 既存の外部キー制約を削除
            $table->dropForeign(['reservation_id']);

            // 外部キー制約を再定義
            $table->foreign('reservation_id')
                ->references('id')->on('reservations')
                ->onDelete('restrict'); // または ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            // 外部キー制約を削除
            $table->dropForeign(['reservation_id']);

            // 元の外部キー制約を再定義（必要に応じて）
            $table->foreign('reservation_id')
                ->references('id')->on('reservations')
                ->onDelete('cascade');
        });
    }
}
