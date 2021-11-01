<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Base Repository
 */
abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }


    /**
     * Wrapper for DB::begin transaction
     *
     * @return void
     */
    public function beginTransaction()
    {
        DB::beginTransaction();
    }

    /**
     * Wrapper for DB::rollback transaction
     *
     * @return void
     */
    public function rollBack()
    {
        DB::rollBack();
    }

    /**
     * Wrapper for DB::commit transaction
     *
     * @return void
     */
    public function commit()
    {
        DB::commit();
    }


    /**
     * Wrapper for model find
     *
     * @param int $id
     * @return Model|null
     */
    public function find(int $id)
    {
        return $this->model->find($id);
    }


    /**
     * Wrapper for model where
     *
     * @param array $where = 
     * [
     *   ['field_1', '=', 'value_1'],
     *   ['field_2', '=', 'value_2']   
     * ]
     * @return collection
     */
    public function where(array $where)
    {
        return $this->model->where($where)->get();
    }


    /**
     * Wrapper for model where
     *
     * @param string $field
     * @param array $values
     * @return collection
     */
    public function whereIn(string $field, array $values)
    {
        return $this->model->whereIn($field, $values)->get();
    }    


    // add common repository methods as you go...

}