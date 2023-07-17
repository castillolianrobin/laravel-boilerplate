<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameMessagesTable extends Migration
{
    public $currentTableName = 'messages';
    public $newTableName = 'chat_room_messages';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename($this->currentTableName, $this->newTableName);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename($this->newTableName, $this->currentTableName);
    }
}
