<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vat', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('code');
            $table->integer('value');
            $table->timestamps();
        });

        DB::table('vat')->insert([
            ['label' => 'VAT 23', 'code' => 'VAT_23', 'value' => 23],
            ['label' => 'VAT 8', 'code' => 'VAT_8', 'value' => 8],
            ['label' => 'VAT 16', 'code' => 'VAT_16', 'value' => 16],
            ['label' => 'VAT 0', 'code' => 'VAT_0', 'value' => 0],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vat');
    }
};
