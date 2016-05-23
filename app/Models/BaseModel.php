<?php

namespace Project\Models;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Str;

/**
 * Project\Models\BaseModel
 *
 * @property-read mixed $slug
 * @method static \Illuminate\Database\Query\Builder|\Project\Models\BaseModel toSubQuery($key, $returnExpression = false)
 * @method static \Illuminate\Database\Query\Builder|\Project\Models\BaseModel whereInSubQuery($column, $subQuery, $subQueryColumn)
 * @method static \Illuminate\Database\Query\Builder|\Project\Models\BaseModel whereNotInSubQuery($column, $subQuery, $subQueryColumn)
 * @method static \Illuminate\Database\Query\Builder|\Project\Models\BaseModel like($column, $value, $before = '%', $after = '%', $andWhere = true)
 * @method static \Illuminate\Database\Query\Builder|\Project\Models\BaseModel unlike($column, $value, $before = '%', $after = '%', $andWhere = true)
 * @method static \Illuminate\Database\Query\Builder|\Project\Models\BaseModel whereRelation($relation, $tableColumn, $values = null, $operator = '=', $countOperator = '>=', $count = 1, $andWhere = true)
 * @method static \Illuminate\Database\Query\Builder|\Project\Models\BaseModel whereNotRelation($relation, $tableColumn, $values = null, $operator = '=', $andWhere = true)
 * @method static \Illuminate\Database\Query\Builder|\Project\Models\BaseModel whereRelationPK($relation, $values, $operator = '=', $countOperator = '>=', $count = 1, $andWhere = true)
 * @method static \Illuminate\Database\Query\Builder|\Project\Models\BaseModel whereNotRelationPK($relation, $values, $operator = '=', $andWhere = true)
 * @mixin \Eloquent
 */
class BaseModel extends Model
{
    public $timestamps = true;
    public $incrementing = false;

    const DEFAULT_CACHE_REMEMBER_TIME = 60;

    // -----------------------------------------------------------------------------------------------------------------

    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            /** @var BaseModel $model */
            $model->eventCreating($model);
        });
        static::created(function ($model) {
            /** @var BaseModel $model */
            $model->eventCreated($model);
        });
        static::updating(function ($model) {
            /** @var BaseModel $model */
            $model->eventUpdating($model);
        });
        static::updated(function ($model) {
            /** @var BaseModel $model */
            $model->eventUpdated($model);
        });
        static::saving(function ($model) {
            /** @var BaseModel $model */
            $model->eventSaving($model);
        });
        static::saved(function ($model) {
            /** @var BaseModel $model */
            $model->eventUniversal($model);
            $model->eventSaved($model);
        });
        static::deleting(function ($model) {
            /** @var BaseModel $model */
            $model->eventDeleting($model);
        });
        static::deleted(function ($model) {
            /** @var BaseModel $model */
            $model->eventUniversal($model);
            $model->eventDeleted($model);
        });
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @param static|BaseModel $model
     *
     * @return bool
     */
    public static function eventCreating($model)
    {
        $pk = $model->getKeyName();
        if (is_string($pk) && $pk != '' && empty($model->getAttribute($pk))) {
            $model->setAttribute($pk, $model->generateIncrementingId());
        }
        return true;
    }

    /**
     * @param static|BaseModel $model
     */
    public static function eventCreated($model)
    {

    }

    /**
     * @param static|BaseModel $model
     *
     * @return bool
     */
    public static function eventUpdating($model)
    {
        return true;
    }

    /**
     * @param static|BaseModel $model
     */
    public static function eventUpdated($model)
    {

    }

    /**
     * @param static|BaseModel $model
     *
     * @return bool
     */
    public static function eventSaving($model)
    {
        return true;
    }

    /**
     * @param static|BaseModel $model
     */
    public static function eventSaved($model)
    {

    }

    /**
     * @param static|BaseModel $model
     *
     * @return bool
     */
    public static function eventDeleting($model)
    {
        return true;
    }

    /**
     * @param static|BaseModel $model
     */
    public static function eventDeleted($model)
    {

    }

    /**
     * @param static|BaseModel $model
     */
    public static function eventUniversal($model)
    {

    }

    // -----------------------------------------------------------------------------------------------------------------

    public function getSlugAttribute()
    {
        if (array_key_exists('name', $this->attributes)) {
            return Str::slug($this->attributes['name']);
        }
        return '';
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @author Umair
     *
     * @return integer
     */
    public function generateIncrementingId()
    {
        return \DB::table($this->table)->max($this->primaryKey) + 1;
    }

    /**
     * @author Umair
     *
     * @param EloquentBuilder|QueryBuilder|BaseModel|BaseModel $query
     * @param bool $getId
     * @param bool $returnQuery
     * @param bool $singleModel
     *
     * @return mixed
     */
    public static function generateQueryOutput($query, $getId, $returnQuery, $singleModel = false)
    {
        if ($returnQuery) {
            return $query;
        }
        $models = $query->get();
        if ($getId) {
            if ($models->count() == 0) {
                return $singleModel ? 0 : array();
            } elseif ($singleModel) {
                return $models->first()->getKey();
            } else {
                return $models->pluck($models->first()->getKeyName())->all();
            }
        } else {
            return $singleModel ? $models->first() : $models;
        }
    }

    /**
     * @param string $needle
     * @param string $replace
     * @param string $haystack
     *
     * @return string string
     */
    private function replaceFirst($needle, $replace, $haystack)
    {
        $pos = strpos($haystack, $needle);
        if ($pos !== false) {
            return substr_replace($haystack, $replace, $pos, strlen($needle));
        }
        return $haystack;
    }

    /**
     * Gets fully qualified field name
     *
     * @param string $name
     *
     * @return string
     */
    public static function getField($name = '*')
    {
        /** @var Model $instance */
        $instance = new static;
        return $instance->getTable() . '.' . $name;
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public static function getTableName()
    {
        /** @var Model $instance */
        $instance = new static;
        return $instance->getTable();
    }

    /**
     * Gets fully qualified field name
     *
     * @param bool $includeTableName
     *
     * @return string
     */
    public static function getPK($includeTableName = true)
    {
        /** @var Model $instance */
        $instance = new static;
        return $includeTableName ? $instance->getQualifiedKeyName() : $instance->getKey();
    }

    // -----------------------------------------------------------------------------------------------------------------

    protected function conditionsArrayGetValue($data)
    {
        if ($data instanceof BaseModel) {
            return $data->getKey();
        } elseif ($data instanceof Collection) {
            return $data->modelKeys();
        } else {
            return $data;
        }
    }

    /**
     * @author Umair
     *
     * @param EloquentBuilder|QueryBuilder|BaseModel $query
     * @param array $conditions
     */
    protected function conditionsArrayHandler($query, $conditions)
    {
        foreach ($conditions as $condition) {
            if (!empty($condition)) {
                if (is_array($condition)) {
                    $condition[2] = array_key_exists(2, $condition) ? $condition[2] : '=';
                    $condition[1] = $this->conditionsArrayGetValue($condition[1]);
                    if (is_array($condition[1])) {
                        if (count($condition[1]) == 0) {
                            continue;
                        }
                        switch ($condition[2]) {
                            case '=':
                                $query->whereIn($condition[0], $condition[1]);
                                break;
                            case '!=':
                                $query->whereNotIn($condition[0], $condition[1]);
                                break;
                            case 'b':
                                $query->whereBetween($condition[0], array(
                                    $this->conditionsArrayGetValue($condition[1][0]),
                                    $this->conditionsArrayGetValue($condition[1][1])
                                ));
                                break;
                            case '!b':
                                $query->whereNotBetween($condition[0], array(
                                    $this->conditionsArrayGetValue($condition[1][0]),
                                    $this->conditionsArrayGetValue($condition[1][1])
                                ));
                                break;
                            case 'like':
                                $query->like($condition[0], $condition[1]);
                                break;
                            case 'unlike':
                                $query->unlike($condition[0], $condition[1]);
                        }
                    } else {
                        $query->where($condition[0], $condition[2], $condition[1]);
                    }
                } elseif ($condition instanceof BaseModel) {
                    $query->where($condition->getQualifiedKeyName(), '=', $condition->getKey());
                } elseif ($condition instanceof Collection) {
                    $query->whereIn($condition->first()->getQualifiedKeyName(), $condition->modelKeys());
                } elseif ($condition instanceof \Closure) {
                    call_user_func($condition, $query);
                }
            }
        }
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @param EloquentBuilder|QueryBuilder|BaseModel $query
     * @param string $key
     * @param bool $returnExpression
     *
     * @return string
     */
    public function scopeToSubQuery($query, $key, $returnExpression = false)
    {
        $index = 0;
        $bindings = array();
        if(!Str::contains($key, '.')) {
            /** @var BaseModel $model */
            $model = $query->getModel();
            $key = $model->getField($key);
        }
        $sql = $query->select(array($key))->toSql();
        foreach ($query->getBindings() as $binding) {
            $bindings[] = is_array($binding) ? array_merge($bindings, $binding) : $binding;
        }
        while (Str::contains($sql, '?')) {
            $sql = $this->replaceFirst('?', $bindings[$index++], $sql);
        }
        $sql = "($sql)";
        return $returnExpression ? (new Expression($sql)) : $sql;
    }

    /**
     * @param EloquentBuilder|QueryBuilder|BaseModel $query
     * @param string $column
     * @param EloquentBuilder|QueryBuilder|BaseModel $subQuery
     * @param string $subQueryColumn
     *
     * @return QueryBuilder
     */
    public function scopeWhereInSubQuery($query, $column, $subQuery, $subQueryColumn)
    {
        if(!Str::contains($column, '.')) {
            /** @var BaseModel $model */
            $model = $query->getModel();
            $column = $model->getField($column);
        }
        $subQuery = $subQuery->toSubQuery($subQueryColumn, true);
        return $query->whereIn($column, $subQuery);
    }

    /**
     * @param EloquentBuilder|QueryBuilder|BaseModel $query
     * @param string $column
     * @param EloquentBuilder|QueryBuilder|BaseModel $subQuery
     * @param string $subQueryColumn
     *
     * @return QueryBuilder
     */
    public function scopeWhereNotInSubQuery($query, $column, $subQuery, $subQueryColumn)
    {
        $subQuery = $subQuery->toSubQuery($subQueryColumn, true);
        return $query->whereNotIn($column, $subQuery);
    }

    /**
     * @author Umair
     *
     * @param EloquentBuilder|QueryBuilder|BaseModel $query
     * @param string $column
     * @param mixed $value
     * @param string $before
     * @param string $after
     * @param bool $andWhere
     *
     * @return EloquentBuilder|QueryBuilder|BaseModel
     */
    public function scopeLike($query, $column, $value, $before = '%', $after = '%', $andWhere = true)
    {
        $value = $before . $value . $after;
        return $query->where($column, 'LIKE', $value, $andWhere ? 'and' : 'or');
    }

    /**
     * @author Umair
     *
     * @param \Illuminate\Database\Eloquent\Builder|QueryBuilder $query
     * @param string $column
     * @param mixed $value
     * @param string $before
     * @param string $after
     * @param bool $andWhere
     *
     * @return EloquentBuilder|QueryBuilder|BaseModel
     */
    public function scopeUnlike($query, $column, $value, $before = '%', $after = '%', $andWhere = true)
    {
        $value = $before . $value . $after;
        return $query->where($column, 'NOT LIKE', $value, $andWhere ? 'and' : 'or');
    }

    /**
     * -----------------------------------------------------------------------------------------------------------------
     * Function whereRelation()
     * -----------------------------------------------------------------------------------------------------------------
     * Applies the whereHas relational condition in a more easier and versatile way. This allows applying multiple
     * whereIn and simple where conditions without declaring a closure and getting into the trouble of dealing with
     * lexical variable rules.
     * -----------------------------------------------------------------------------------------------------------------
     * Examples
     * -----------------------------------------------------------------------------------------------------------------
     * > Single Condition Mode
     * - Minimum Syntax
     *      Persona::whereRelation('products', 'product.product_id', 1);
     * - Full Syntax
     *      Persona::whereRelation('products', 'product.product_id', 1, '=', '>=', 1, true);
     *
     * > Multiple Condition Mode
     * - Minimum Syntax
     *      Persona::whereRelation('products', array(array('product.product_id', 1), array('product.name', 'Hemp'));
     * - Full Syntax
     *      Persona::whereRelation('products', array(
     *          array('product.product_id', 1, '='),
     *          array('product.name', 'Hemp', '=')
     *      ), null, null, '>=', 1, true);
     * -----------------------------------------------------------------------------------------------------------------
     *
     * @author Umair
     *
     * @param string $relation                              Name of function which returns the relation in the model
     *
     * @param string|array $tableColumn                     - Single Condition Mode -
     *                                                      Contains tableName.columnName string
     *                                                      - Multiple Conditions Mode -
     *                                                      Contains an array of conditions
     *
     * @param mixed $values                                 Array of values (for whereIn) or a single value (where) for single condition
     *
     * @param string $operator                              Operator for a single condition mode
     *
     * @param string $countOperator                         Operator or relation count
     * @param integer $count                                Count condition on relation
     * @param boolean|string $andWhere                      Operator between previous where condition
     * @param EloquentBuilder|QueryBuilder|BaseModel $query - Internal Variable -
     *
     * @return EloquentBuilder|QueryBuilder|BaseModel
     */
    public function scopeWhereRelation(
        $query,
        $relation,
        $tableColumn,
        $values = null,
        $operator = '=',
        $countOperator = '>=',
        $count = 1,
        $andWhere = true
    ) {
        $andWhere = $andWhere ? 'and' : 'or';
        if (!is_array($tableColumn)) {
            $tableColumn = array(array($tableColumn, $values, $operator));
        }
        return $query->has($relation, $countOperator, $count, $andWhere, function ($q) use ($tableColumn) {
            $this->conditionsArrayHandler($q, $tableColumn);
        });
    }

    /**
     * @param EloquentBuilder|QueryBuilder|BaseModel $query
     * @param string $relation
     * @param string|array $tableColumn
     * @param mixed $values
     * @param string $operator
     * @param bool $andWhere
     *
     * @return mixed
     */
    public function scopeWhereNotRelation(
        $query,
        $relation,
        $tableColumn,
        $values = null,
        $operator = '=',
        $andWhere = true
    ) {
        return $query->whereRelation($relation, $tableColumn, $values, $operator, '<', 1, $andWhere);
    }

    /**
     * -----------------------------------------------------------------------------------------------------------------
     * Function whereRelationPK()
     * -----------------------------------------------------------------------------------------------------------------
     * This extends the whereRelation function to make it calculate the table name and primary key of the related model
     * internally. Thus the frequent scenarios in which the single condition on the relation involves the primary key
     * of
     * the related model can be handled more easily and in an OOP way.
     *
     * Limitations: Nested relations and multiple primary keys on related model are not supported.
     *
     * -----------------------------------------------------------------------------------------------------------------
     * Examples
     * -----------------------------------------------------------------------------------------------------------------
     * - Minimum Syntax
     *      Persona::whereRelation('products', 'product.product_id', 1);
     *
     * - Full Syntax
     *      Persona::whereRelation('products', 1, '=', '>=', 1, true);
     * -----------------------------------------------------------------------------------------------------------------
     *
     * @author Umair
     *
     * @param string $relation                              Name of function which returns the relation in the model
     * @param mixed $values                                 Array of values (for whereIn) or a single value (where)
     * @param string $operator                              Operator for a single condition mode
     * @param string $countOperator                         Operator for relation count
     * @param integer $count                                Count condition on relation
     * @param boolean $andWhere                             Operator between previous where condition
     * @param EloquentBuilder|QueryBuilder|BaseModel $query - Internal Variable -
     *
     * @return EloquentBuilder|QueryBuilder|BaseModel
     */
    public function scopeWhereRelationPK(
        $query,
        $relation,
        $values,
        $operator = '=',
        $countOperator = '>=',
        $count = 1,
        $andWhere = true
    ) {
        $pk = $query->getRelation($relation)->getRelated()->getQualifiedKeyName();
        return $query->whereRelation($relation, $pk, $values, $operator, $countOperator, $count, $andWhere);
    }

    /**
     * @param EloquentBuilder|QueryBuilder|BaseModel $query
     * @param string $relation
     * @param mixed $values
     * @param string $operator
     * @param bool $andWhere
     *
     * @return mixed
     */
    public function scopeWhereNotRelationPK(
        $query,
        $relation,
        $values,
        $operator = '=',
        $andWhere = true
    ) {
        return $query->whereRelationPK($relation, $values, $operator, '<', 1, $andWhere);
    }
} 