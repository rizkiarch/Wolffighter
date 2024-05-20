<?php

use App\Models\Jabatan;
use App\Models\Jenis;
use App\Models\Korlap;
use App\Models\Organisasi;
use App\Models\Region;
use App\Models\SubRegion;
use App\Models\Wilayah;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('no')->nullable();
            $table->string('nik')->nullable();
            $table->string('name')->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('desa')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('address')->nullable();

            $table->foreignIdFor(Jabatan::class)->nullable()
                ->constrained()
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignIdFor(Jenis::class)->nullable()
                ->constrained()
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignIdFor(Region::class)->nullable()
                ->constrained()
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignIdFor(SubRegion::class)->nullable()
                ->constrained()
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignIdFor(Organisasi::class)->nullable()
                ->constrained()
                ->onUpdate('cascade')->onDelete('cascade');
            // $table->foreignIdFor(Korlap::class)->nullable()
            //     ->constrained()
            //     ->onUpdate('cascade')->onDelete('cascade');


            $table->foreignIdFor(Wilayah::class, 'desa_id')->nullable()
                ->constrained('_wilayah_nkri')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->string('jk')->nullable();
            $table->string('username')->nullable();
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();

            // $table->foreignIdFor(\App\Models\Branch::class)
            //     ->onUpdate('cacade');
            $table->boolean('is_active')->default(true);


            $table->rememberToken();
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
