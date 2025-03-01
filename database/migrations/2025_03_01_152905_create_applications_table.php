<?php

use App\Models\AcademicSession;
use App\Models\User;
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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(AcademicSession::class)->constrained()->onDelete('cascade');
            $table->enum('status', [
                'Pending',
                'Approved',
                'Rejected',
                'draft',
                'submitted',
                'declined',
                'under_review'
            ])->default('Pending');
            $table->string('application_number')->unique();
            $table->enum('payment_status', ['Pending', 'Successful', 'Failed'])->default('Pending');
            $table->dateTime('reviewed_at')->nullable();
            $table->text('rejected_reason')->nullable();
            $table->dateTime('submitted_at')->default(now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
