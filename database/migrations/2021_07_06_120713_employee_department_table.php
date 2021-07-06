<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EmployeeDepartmentTable extends Migration
{
    public function up()
    {
        Schema::create('employee_department', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignId('employee_id')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade');

            $table->foreignId('department_id')
                ->references('id')
                ->on('departments')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee_department');
    }
}
