<?php

namespace Project\Models;

/**
 * Project\Models\Badge
 *
 * @property integer $badge_id
 * @property integer $rule_id
 * @property string $name
 * @property string $description
 * @property string $logo
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Project\Models\Rule $rule
 * @property-read \Illuminate\Database\Eloquent\Collection|\Project\Models\User[] $users
 * @property-read mixed $slug
 * @method static \Illuminate\Database\Query\Builder|\Project\Models\Badge whereBadgeId($value)
 * @method static \Illuminate\Database\Query\Builder|\Project\Models\Badge whereRuleId($value)
 * @method static \Illuminate\Database\Query\Builder|\Project\Models\Badge whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Project\Models\Badge whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Project\Models\Badge whereLogo($value)
 * @method static \Illuminate\Database\Query\Builder|\Project\Models\Badge whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Project\Models\Badge whereUpdatedAt($value)
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
class Badge extends BaseModel
{
    protected $table = 'badges';
    protected $primaryKey = 'badge_id';
    protected $fillable = [
        'name',
        'logo',
        'description'
    ];
    protected $guarded = [
        'rule_id',
    ];

    public function rule()
    {
        return $this->hasOne(Rule::class, 'rule_id', 'rule_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_badges', 'badge_id', 'user_id')
            ->withPivot(array('related_id', 'related_type'))
            ->withTimestamps();
    }

} 