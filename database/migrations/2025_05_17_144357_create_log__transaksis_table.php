<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('log__transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('jenis_transaksi', ['tukar_sampah', 'tukar_voucher', 'tukar_rupiah']);
            $table->date('tanggal_transaksi');
            $table->integer('jumlah_koin');
            $table->unsignedBigInteger('reference_id');
            $table->string('reference_type'); // PenukaranSampah atau PenukaranKoin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log__transaksis');
    }
};
