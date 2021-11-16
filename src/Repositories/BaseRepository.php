<?php

namespace Pros\CodeBase\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Model;

/**
 * @method Model updateOrInsert($columns, $data)                                    update or create record in DB, depends on $columns's condition
 * @method Model updateOrCreate($columns, $data)                                    update or create record in DB, depends on $columns's condition
 * @method Model firstOrNew(array $test, array $params = [])                        get or create new Model with preset params
 * @method Model upsert(array $data, array $uniqueColumns, array $updatableColumns) insert massive data witch match the unique and/or primary columns
 */
class BaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * Determine whether the repository has model or not
     */
    protected $hasModel = true;

    /**
     * @var string
     */
    private $modelPath = "App\Models\\";

    public function __construct()
    {
        // auto setup $model variable
        if (empty($this->model) && $this->hasModel) {
            $search   = 'Repository';
            $repoName = class_basename($this);
            $position = strpos($repoName, $search);

            if ($position !== false) {
                $modelName = $this->modelPath . str_replace($search, '', $repoName);

                $this->model = resolve($modelName);
            }
        }
    }

    /**
     * This magic method to call function from model when it doesn't appear in BaseRepository class
     *
     * @param $name
     * @param $arguments
     * @return Model
     */
    public function __call($name, $arguments)
    {
        if (empty($this->model)) {
            throw new Exception('Method not found: ' . $name);
        }

        return $this->model->{$name}(...$arguments);
    }
}
