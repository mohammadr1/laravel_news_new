
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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('on_titr')->nullable();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->string('content_type')->nullable(); // یا بعد از هر ستون دیگری که مدنظرت هست
            $table->string('image')->nullable();
            $table->text('body')->nullable();
            $table->string('meta_description')->nullable();
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->timestamp('published_at')->nullable();
            $table->json('tags')->nullable(); // ✅ فیلد تگ‌ها به صورت JSON
            $table->enum('position', ['slider', 'slider_side', 'slider_bottom'])->default('slider_bottom');
            $table->boolean('status')->default(1);
            $table->enum('position', ['slider', 'slider_side', 'slider_bottom'])->default('slider_bottom');
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
