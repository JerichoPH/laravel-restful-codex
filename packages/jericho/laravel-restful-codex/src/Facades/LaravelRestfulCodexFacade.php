<?php

namespace jericho\LaravelRestfulCodex\Facades;

use Illuminate\Config\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Facade;
use jericho\LaravelRestfulCodex\Services\LaravelRestfulCodexService;

/**
 * Class ModelBuilderFacade
 * @package jericho\LaravelRestfulCodex\Facades
 * @method static init(Builder $builder = null, array $options = []): LaravelRestfulCodexService
 * @method static setBuilder(Builder $builder = null): LaravelRestfulCodexService
 * @method getConfig(): array
 * @method getOptions(): array
 * @method setOptions(array $options = []): LaravelRestfulCodexService
 * @method getRequestData(string $type = 'array')
 * @method setRequestData(array $request_data = []): LaravelRestfulCodexService
 * @method getFilterExcepts(): array
 * @method setFilterExcepts(array $filter_excepts = []): LaravelRestfulCodexService
 * @method all()
 * @method pagination()
 * @method first()
 * @method firstOrFail()
 * @method toSql()
 * @method firstSql()
 * @method extension(\Closure $extension_func): self
 * @method static unionAll(\Illuminate\Database\Query\Builder $builder1, \Illuminate\Database\Query\Builder $builder2): \Illuminate\Database\Query\Builder
 * @method static test(): string
 */
class LaravelRestfulCodexFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return LaravelRestfulCodexService::class;
    }
}
