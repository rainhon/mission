<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class RequestLog extends Model
{
    use HasFactory;

    const TABLE_SUFFIX = '_request_logs';

    public function setTableName(string $date): void
    {
        $tableName = $date . self::TABLE_SUFFIX;
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function ($table) {
                $table->id();
                $table->string('method', 20)->nullable();
                $table->string('request_id', 32)->nullable();
                $table->string('request_path', 100)->nullable();
                $table->string('request_data', 500)->nullable();
                $table->string('response_data', 500)->nullable();
                $table->timestamps();
            });
        }
        $this->setTable($tableName);
    }
}
