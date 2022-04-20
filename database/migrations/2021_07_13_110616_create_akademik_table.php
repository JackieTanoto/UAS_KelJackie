<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAkademikTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nim',30)->unique()->nullable();
            $table->string('nidn',30)->unique()->nullable();
            $table->string('phone',13)->unique()->nullable();
            $table->string('email')->unique();
            $table->string('name',150);
            $table->string('place_birth')->nullable();
            $table->date('date_birth')->nullable();
            $table->string('religion')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->longText('address')->nullable();
            $table->string('photo')->nullable();
            $table->integer('class_id')->default(0);
            $table->enum('gender',['l','p'])->nullable();
            $table->enum('role',['a','g','s'])->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->longText('description');
            $table->integer('guru_id');
            $table->timestamps();
        });
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('year',4);
            $table->timestamps();
        });
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('course_id');
            $table->integer('class_id');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->longtext('url');
            $table->timestamps();
        });
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->integer('schedule_id');
            $table->integer('siswa_id');
            $table->timestamp('present_at');
            $table->enum('st',['a','h']);
            $table->timestamps();
        });
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('schedule_id');
            $table->string('title');
            $table->longText('description');
            $table->string('file');
            $table->timestamp('due_at');
            $table->timestamps();
        });
        Schema::create('progress', function (Blueprint $table) {
            $table->id();
            $table->integer('task_id');
            $table->integer('siswa_id');
            $table->string('file');
            $table->timestamp('uploaded_at');
        });
        Schema::create('raport', function (Blueprint $table) {
            $table->id();
            $table->integer('courses_id');
            $table->integer('kelas_id');
            $table->integer('siswa_id');
            $table->string('kehadiran',4);
            $table->string('tugas',4);
            $table->string('uts',4);
            $table->string('uas',4);
            $table->timestamp('created_at');
        });
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
    }
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('class');
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('progress');
        Schema::dropIfExists('raport');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('failed_jobs');
    }
}
