<?php

use App\Enums\Notification\NotificationTypes;
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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('sub_title');
            $table->string('url')->nullable();
            $table->string('image')->nullable();
            $table->string('body')->nullable();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->timestamp('read_at')->nullable();
           $table->string('notification_type'//, NotificationTypes::toArray()
        );
            $table->timestamps();
            /*    $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable(); */
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
