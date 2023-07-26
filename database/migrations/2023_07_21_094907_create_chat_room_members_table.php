<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatRoomMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        // Add private room column to ChatRoom
        Schema::table('chat_rooms', function (Blueprint $table) {
            $table->boolean('is_private');
        });

        Schema::create('chat_room_members', function (Blueprint $table) {
            $table->id();
            $table->integer('chat_room_id');
            $table->integer('user_id');
            $table->boolean('is_admin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_room_members');

        Schema::table('chat_rooms', function (Blueprint $table) {
            $table->dropColumn('is_private');
        });
    }
}
