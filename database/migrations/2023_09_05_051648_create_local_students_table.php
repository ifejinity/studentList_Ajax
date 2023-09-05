<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLocalStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('local_students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('student_type', 200);
            $table->integer('id_number');
            $table->string('names', 200);
            $table->integer('age');
            $table->string('city', 200);
            $table->string('mobile_number', 12);
            $table->decimal('grades', 30, 15)->nullable();
            $table->string('email', 200);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->unique(array('id_number', 'names', 'mobile_number'), 'idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('local_students');
    }
}
