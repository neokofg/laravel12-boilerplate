<?php

namespace App\Support\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method static Builder|static newModelQuery()
 * @method static Builder|static newQuery()
 * @method static Builder|static query()
 *
 * WHERE METHODS
 * @method static Builder|static where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder|static whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static Builder|static whereNotIn($column, $values, $boolean = 'and')
 * @method static Builder|static whereNull($column, $boolean = 'and', $not = false)
 * @method static Builder|static whereNotNull($column, $boolean = 'and')
 * @method static Builder|static whereBetween($column, array $values, $boolean = 'and', $not = false)
 * @method static Builder|static whereNotBetween($column, array $values, $boolean = 'and')
 * @method static Builder|static whereDate($column, $operator, $value = null, $boolean = 'and')
 * @method static Builder|static whereTime($column, $operator, $value = null, $boolean = 'and')
 * @method static Builder|static whereDay($column, $operator, $value = null, $boolean = 'and')
 * @method static Builder|static whereMonth($column, $operator, $value = null, $boolean = 'and')
 * @method static Builder|static whereYear($column, $operator, $value = null, $boolean = 'and')
 * @method static Builder|static whereColumn($first, $operator = null, $second = null, $boolean = 'and')
 * @method static Builder|static whereExists($callback, $boolean = 'and', $not = false)
 * @method static Builder|static whereNotExists($callback, $boolean = 'and')
 * @method static Builder|static whereHas($relation, $callback = null, $operator = '>=', $count = 1)
 * @method static Builder|static whereDoesntHave($relation, $callback = null)
 * @method static Builder|static withWhereHas($relation, $callback = null, $operator = '>=', $count = 1)
 * @method static Builder|static whereRelation($relation, $column, $operator = null, $value = null)
 * @method static Builder|static whereMorphRelation($relation, $types, $column, $operator = null, $value = null)
 * @method static Builder|static whereMorphedTo($relation, $model, $boolean = 'and')
 * @method static Builder|static whereBelongsTo($related, $relationshipName = null, $boolean = 'and')
 * @method static Builder|static orWhere($column, $operator = null, $value = null)
 * @method static Builder|static orWhereIn($column, $values)
 * @method static Builder|static orWhereNotIn($column, $values)
 * @method static Builder|static orWhereNull($column)
 * @method static Builder|static orWhereNotNull($column)
 * @method static Builder|static orWhereBetween($column, array $values)
 * @method static Builder|static orWhereNotBetween($column, array $values)
 * @method static Builder|static orWhereColumn($first, $operator = null, $second = null)
 * @method static Builder|static orWhereExists($callback)
 * @method static Builder|static orWhereNotExists($callback)
 * @method static Builder|static orWhereHas($relation, $callback = null, $operator = '>=', $count = 1)
 * @method static Builder|static orWhereDoesntHave($relation, $callback = null)
 *
 * SELECT METHODS
 * @method static Builder|static select($columns = ['*'])
 * @method static Builder|static selectRaw($expression, array $bindings = [])
 * @method static Builder|static addSelect($column)
 * @method static Builder|static distinct()
 * @method static Builder|static from($table, $as = null)
 *
 * JOIN METHODS
 * @method static Builder|static join($table, $first, $operator = null, $second = null, $type = 'inner', $where = false)
 * @method static Builder|static joinWhere($table, $first, $operator, $second, $type = 'inner')
 * @method static Builder|static joinSub($query, $as, $first, $operator = null, $second = null, $type = 'inner', $where = false)
 * @method static Builder|static leftJoin($table, $first, $operator = null, $second = null)
 * @method static Builder|static leftJoinWhere($table, $first, $operator, $second)
 * @method static Builder|static leftJoinSub($query, $as, $first, $operator = null, $second = null)
 * @method static Builder|static rightJoin($table, $first, $operator = null, $second = null)
 * @method static Builder|static rightJoinWhere($table, $first, $operator, $second)
 * @method static Builder|static rightJoinSub($query, $as, $first, $operator = null, $second = null)
 * @method static Builder|static crossJoin($table, $first = null, $operator = null, $second = null)
 * @method static Builder|static crossJoinSub($query, $as)
 *
 * GROUP BY / HAVING
 * @method static Builder|static groupBy(...$groups)
 * @method static Builder|static groupByRaw($sql, array $bindings = [])
 * @method static Builder|static having($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder|static havingBetween($column, array $values, $boolean = 'and', $not = false)
 * @method static Builder|static havingRaw($sql, array $bindings = [], $boolean = 'and')
 * @method static Builder|static orHaving($column, $operator = null, $value = null)
 * @method static Builder|static orHavingRaw($sql, array $bindings = [])
 *
 * ORDER BY / LIMIT
 * @method static Builder|static orderBy($column, $direction = 'asc')
 * @method static Builder|static orderByDesc($column)
 * @method static Builder|static orderByRaw($sql, $bindings = [])
 * @method static Builder|static reorder($column = null, $direction = 'asc')
 * @method static Builder|static inRandomOrder($seed = '')
 * @method static Builder|static skip($value)
 * @method static Builder|static offset($value)
 * @method static Builder|static take($value)
 * @method static Builder|static limit($value)
 * @method static Builder|static forPage($page, $perPage = 15)
 * @method static Builder|static forPageBeforeId($perPage = 15, $beforeId = null, $column = 'id')
 * @method static Builder|static forPageAfterId($perPage = 15, $afterId = null, $column = 'id')
 *
 * EAGER LOADING
 * @method static Builder|static with($relations)
 * @method static Builder|static without($relations)
 * @method static Builder|static withOnly($relations)
 * @method static Builder|static withCount($relations)
 * @method static Builder|static withMax($relation, $column)
 * @method static Builder|static withMin($relation, $column)
 * @method static Builder|static withSum($relation, $column)
 * @method static Builder|static withAvg($relation, $column)
 * @method static Builder|static withExists($relation)
 * @method static Builder|static withAggregate($relations, $column, $function = null)
 * @method static Builder|static has($relation, $operator = '>=', $count = 1, $boolean = 'and', $callback = null)
 * @method static Builder|static orHas($relation, $operator = '>=', $count = 1)
 * @method static Builder|static doesntHave($relation, $boolean = 'and', $callback = null)
 * @method static Builder|static orDoesntHave($relation)
 *
 * RESULTS
 * @method static static|null find($id, $columns = ['*'])
 * @method static static findOrFail($id, $columns = ['*'])
 * @method static static findOrNew($id, $columns = ['*'])
 * @method static static firstOrNew(array $attributes = [], array $values = [])
 * @method static static firstOrCreate(array $attributes, array $values = [])
 * @method static static updateOrCreate(array $attributes, array $values = [])
 * @method static static|null first($columns = ['*'])
 * @method static static firstOrFail($columns = ['*'])
 * @method static static sole($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Collection|static[] get($columns = ['*'])
 * @method static \Illuminate\Contracts\Pagination\LengthAwarePaginator paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Contracts\Pagination\Paginator simplePaginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Contracts\Pagination\CursorPaginator cursorPaginate($perPage = null, $columns = ['*'], $cursorName = 'cursor', $cursor = null)
 *
 * AGGREGATES
 * @method static int count($columns = '*')
 * @method static mixed min($column)
 * @method static mixed max($column)
 * @method static mixed sum($column)
 * @method static mixed avg($column)
 * @method static mixed average($column)
 * @method static mixed aggregate($function, $columns = ['*'])
 * @method static float|int numericAggregate($function, $columns = ['*'])
 * @method static bool exists()
 * @method static bool doesntExist()
 *
 * UTILITY
 * @method static mixed value($column)
 * @method static \Illuminate\Support\Collection pluck($column, $key = null)
 * @method static \Illuminate\Support\LazyCollection lazy($chunkSize = 1000)
 * @method static \Illuminate\Support\LazyCollection lazyById($chunkSize = 1000, $column = null, $alias = null)
 * @method static \Illuminate\Support\LazyCollection lazyByIdDesc($chunkSize = 1000, $column = null, $alias = null)
 *
 * CONDITIONAL
 * @method static Builder|static when($value, $callback, $default = null)
 * @method static Builder|static unless($value, $callback, $default = null)
 * @method static Builder|static tap($callback)
 *
 * MUTATIONS
 * @method static int insert(array $values)
 * @method static int upsert(array $values, $uniqueBy, $update = null)
 * @method static bool insertOrIgnore(array $values)
 * @method static static create(array $values)
 * @method static int update(array $values)
 * @method static int increment($column, $amount = 1, array $extra = [])
 * @method static int decrement($column, $amount = 1, array $extra = [])
 * @method static mixed delete()
 * @method static mixed forceDelete()
 * @method static mixed restore()
 *
 * DEFAULT PROPERTIES
 * @property string $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method static Builder|static whereId($value)
 * @method static Builder|static whereCreatedAt($value)
 * @method static Builder|static whereUpdatedAt($value)
 */
trait HasEloquentAnnotations
{

    public function scopeCreatedBetween($query, $startDate, $endDate): Builder|static
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    public function getCreatedAtHumanAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }
}
