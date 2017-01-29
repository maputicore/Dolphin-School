<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeLessonsstudentsColumnTeacheridToLessonid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lessons_students', function (Blueprint $table) {
            $table->renameColumn('teacher_id', 'lesson_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lessons_students', function (Blueprint $table) {
            $table->dropColumn('lesson_id');
        });
    }
}
