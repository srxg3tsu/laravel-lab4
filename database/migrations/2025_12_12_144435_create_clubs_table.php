<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_clubs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClubsTable extends Migration
{
    public function up()
    {
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();
            $table->string('name');                          // Название клуба
            $table->string('league');                        // Лига/страна
            $table->string('image_path')->nullable();        // Путь к логотипу
            $table->text('short_description');               // Краткое описание
            $table->text('full_description')->nullable();    // Полное описание
            $table->string('stadium')->nullable();           // Стадион
            $table->year('founded_year')->nullable();        // Год основания
            $table->text('titles')->nullable();              // Достижения
            $table->timestamps();
            $table->softDeletes();                           // Мягкое удаление
        });
    }

    public function down()
    {
        Schema::dropIfExists('clubs');
    }
}