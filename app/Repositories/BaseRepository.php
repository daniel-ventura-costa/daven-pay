<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository
{
    protected $table = null;

    public function getById($id)
    {
        $model = DB::table($this->table)->find($id);
        return (is_null($model)) ? null : (array) $model;
    }

    public function insert(array $values): bool
    {
        $model = DB::table($this->table)->insert($values);
        return $model;
    }
}
