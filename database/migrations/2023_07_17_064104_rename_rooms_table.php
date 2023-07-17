<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameRoomsTable extends Migration
{
    public $currentTableName = 'rooms';
    public $newTableName = 'chat_rooms';

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
