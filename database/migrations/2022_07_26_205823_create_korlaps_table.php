<?php

use App\Models\Organisasi;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('korlaps', function (Blueprint $table) {
            $table->id();
            $table->string('no');
            $table->string('nik');
            $table->string('nama');
            $table->foreignIdFor(Organisasi::class)->nullable()->constrained()->onUpdate('cascade');
            $table->foreignIdFor(User::class)->nullable()->constrained()->onUpdate('cascade');
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
        Schema::dropIfExists('korlaps');
    }
};
