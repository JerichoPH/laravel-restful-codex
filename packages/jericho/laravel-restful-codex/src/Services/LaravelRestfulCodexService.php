<?php

namespace jericho\LaravelRestfulCodex\Services;

use App\Models\Article;
use Closure;
use Exception;
use Illuminate\Config\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use jericho\LaravelRestfulCodex\Facades\LaravelRestfulCodexFacade;

class LaravelRestfulCodexService
{
    private $__filter_excepts = [];
    private $__request_data = [];
    private $__builder = null;
    private $__config_name = 'laravelRestfulCodex';

    protected $__config;

    public function __construct(Repository $config = null)
    {
        $this->__config = $config;
    }

    /**
     * init class and get instance
     * @param Builder|null $builder
     * @return $this
     * @throws Exception
     */
    public function init(Builder $builder = null, array $options = []): self
    {
        if (!$builder) throw new Exception('builder is null');
        $this->__builder = $builder;
        return $this->setOptions($options);
    }

    /**
     * set builder
     * @param Builder|null $builder
     * @return LaravelRestfulCodexService
     * @throws Exception
     */
    final public function setBuilder(Builder $builder = null): self
    {
        if (!$builder) throw new Exception('builder is null');
        $this->__builder = $builder;
        return $this;
    }

    /**
     * get config
     * @param string $key
     * @return array
     */
    public function getConfig(string $key): array
    {
        return $this->__config->get($this->__config_name)[$key] ?? [];
    }

    /**
     * get options
     * @return array
     */
    final public function getOptions(): array
    {
        return [
            'builder' => $this->__builder,
            'request_data' => $this->__request_data,
            'filter_excepts' => $this->__filter_excepts,
        ];
    }

    /**
     * set options
     * @param array $options
     * @return LaravelRestfulCodexService
     */
    final public function setOptions(array $options = []): self
    {
        $options = array_merge($options, [
            'request_data' => request()->all(),  // request data default: request()->all()
            'filter_excepts' => $this->getConfig('defaultFilterExcepts'),  // use for filter excepts
        ]);
        $this->__request_data = $options['request_data'];
        $this->__filter_excepts = $options['filter_excepts'];
        return $this;
    }

    /**
     * get request data
     * @param string $type
     * @return array|Collection
     */
    final public function getRequestData(string $type = 'array')
    {
        switch ($type) {
            case 'array':
            default:
                return $this->__request_data ?? [];
            case 'collection':
                return collect($this->__request_data) ?? collect([]);
        }
    }

    /**
     * set request data
     */
    final public function setRequestData(array $request_data = []): self
    {
        $this->__request_data = collect($request_data);
        return $this;
    }

    /**
     * get filter excepts for request data usable in "model builder" where condition's "key"
     * @return array
     */
    final public function getFilterExcepts(): array
    {
        return $this->__filter_excepts ?? [];
    }

    /**
     * set filter excepts for request data usable in "model builder" where condition's "key"
     * @param array $filter_excepts
     * @return $this
     */
    final public function setFilterExcepts(array $filter_excepts = []): self
    {
        $this->__filter_excepts = $filter_excepts;
        return $this;
    }

    /**
     * generate where condition and filter
     */
    final private function filter()
    {
        $request_data = $this->getRequestData('collection');
        $params = array_filter($request_data->except($this->__filter_excepts), function ($val) {
            return !empty($val);
        });
        if ($params) {
            foreach ($params as $field_name => $condition) {
                $this->__builder->when($field_name, function ($query) use ($field_name, $condition) {
                    return self::__condition($query, $field_name, $condition);
                });
            }
        }
        $this->__builder->when($request_data->get('limit'), function ($query) use ($request_data) {
            return $query->limit($request_data->get('limit'));
        });
    }

    /**
     * make conditions
     * @param $query
     * @param $fieldName
     * @param $condition
     * @return mixed
     */
    final private function __condition($query, $fieldName, $condition)
    {
        if (is_array($condition)) {
            switch (strtolower($condition['operator'])) {
                case 'in':
                    return $query->whereIn($fieldName, $condition['value']);
                case 'or':
                    return $query->orWhere($fieldName, $condition['value']);
                case 'between':
                    return $query->whereBetween($fieldName, $condition['value']);
                case 'like_l':
                    return $query->where($fieldName, 'like', "%{$condition['value']}");
                case 'like_r':
                    return $query->where($fieldName, 'like', "{$condition['value']}%");
                case 'like_b':
                    return $query->where($fieldName, 'like', "%{$condition['value']}%");
                default:
                    return $query->where($fieldName, $condition['operator'], $condition['value']);
            }
        } else {
            return $query->where($fieldName, $condition);
        }
    }

    /**
     * order
     */
    final private function ordering(): self
    {
        $request_data = $this->getRequestData('collection');
        if ($request_data->get('ordering'))
            $this->__builder->orderByRaw($request_data->get('ordering'));
        return $this;
    }

    /**
     * make union all query
     * @param \Illuminate\Database\Query\Builder $builder1
     * @param \Illuminate\Database\Query\Builder $builder2
     * @return \Illuminate\Database\Query\Builder
     */
    final public static function unionAll(\Illuminate\Database\Query\Builder $builder1, \Illuminate\Database\Query\Builder $builder2): \Illuminate\Database\Query\Builder
    {
        return DB::table(DB::raw("({$builder1->unionAll($builder2)->toSql()}) as tmp_union_all"))->mergeBindings($builder1);
    }

    /**
     * extension operation
     * @param Closure $extension_func
     * @return $this
     */
    final public function extension(Closure $extension_func): self
    {
        if ($extension_func) $this->__builder = ($extension_func($this->__builder) ?: $this->__builder);
        return $this;
    }

    /**
     * get many and auto distinguish paginate
     * @return mixed
     */
    final public function all()
    {
        $request_data = $this->getRequestData('collection');
        return $request_data->get('page') ?
            $this->__builder->paginate($request_data->get('size', env('PAGE_SIZE'))) :
            $this->__builder->get();
    }

    /**
     * get paginate
     * @return mixed
     */
    final public function paginate()
    {
        $request_data = $this->getRequestData('collection');
        return $this->__builder->paginate($request_data->get('size', env('PAGE_SIZE')));
    }

    /**
     * get one
     * @return mixed
     */
    public function first()
    {
        return $this->__builder->first();
    }

    /**
     * get first or fail
     * @return mixed
     */
    final public function firstOrFail()
    {
        return $this->__builder->firstOrFail();
    }

    /**
     * get many sql
     * @return mixed
     */
    final public function toSql()
    {
        DB::connection()->enableQueryLog();
        $this->__builder->get();
        return DB::getQueryLog();
    }

    /**
     * get first sql
     * @return mixed
     */
    final public function firstSql()
    {
        DB::connection()->enableQueryLog();
        $this->__builder->first();
        return DB::getQueryLog();
    }

    /**
     * test fun
     */
    final public function test(): string
    {
        $class_name = LaravelRestfulCodexFacade::class;
        return "here is {$class_name}";
    }
}
