<?php

declare(strict_types=1);

use App\Enums\Common\EnabledStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $statusValues = array_map(static fn (EnabledStatus $case) => $case->value, EnabledStatus::cases());

        Schema::create('store_income_fixed_expenses', static function (Blueprint $table) use ($statusValues): void {
            $table->id();
            $table->foreignId('store_id')->constrained()->cascadeOnDelete(); //親が削除されたら子も削除したいケースではcascadeOnDeleteを利用する
            $table->string('name', 32);
            $table->integer('default_amount')->default(0)->comment('フォーム入力時の初期値として利用する'); // カラム名だけでは用途が分かりにくいカラムにはコメント付与
            $table->enum('status', $statusValues)->default(EnabledStatus::ENABLED->value); // statusが増えたときのためbooleanは利用せずenumを利用している
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_income_fixed_expenses');
    }
};
