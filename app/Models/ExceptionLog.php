<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class ExceptionLog extends Model
{
    use HasFactory;

    const TABLE_SUFFIX = '_exception_logs';

    public function setTableName(string $date): void
    {
        $tableName = $date . self::TABLE_SUFFIX;
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function ($table) {
                $table->id();
                $table->string('message', 100)->nullable();
                $table->string('request_id', 32)->nullable();
                $table->string('trace', 2000)->nullable();
                $table->string('exception', 200)->nullable();
                $table->timestamps();
            });
        }
        $this->setTable($tableName);
    }
}
