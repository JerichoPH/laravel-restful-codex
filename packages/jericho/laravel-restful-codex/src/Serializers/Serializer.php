<?php

namespace jericho\LaravelRestfulCodex\Serializers;

use Exception;
use jericho\LaravelRestfulCodex\Facades\LaravelRestfulCodexFacade;
use jericho\LaravelRestfulCodex\Services\LaravelRestfulCodexService;

class Serializer
{
    protected $__options = [
        'builder' => null,
        'relationship_name' => 'Default',
        'model' => null,
        'model_name' => null,
        'request_data' => null,
        'data' => null,
    ];

    /**
     * Serializer constructor.
     * @param string $model_name
     * @param string|array $relationship_name
     * @throws Exception
     */
    public function __construct(string $model_name, $relationship_name = 'default')
    {
        $this->__options['model_name'] = $model_name;
        $this->__options['model'] = new $model_name;

        if (is_string($relationship_name)) {
            $this->__options['relationship_name'] = 'with' . ucfirst($relationship_name);
            $this->__options['builder'] = LaravelRestfulCodexFacade::init($this->__options['model']::with($this->{$this->__options['relationship_name']}()));
        } elseif (is_array($relationship_name)) {
            $this->__options['builder'] = LaravelRestfulCodexFacade::init($this->__options['model']::with($relationship_name));
        } else {
            throw new Exception('relationship_name must be a string or array');
        }

        $this->__options['request_data'] = $this->__options['builder']->getRequestData('collection');
    }

    /**
     * default model relationship
     * @return array
     */
    final public function withDefault(): array
    {
        return [];
    }

    /**
     * get builder
     * @return LaravelRestfulCodexService
     */
    final public function getBuilder(): LaravelRestfulCodexService
    {
        return $this->__options['builder'];
    }

    public function __get(string $key)
    {
        return $this->__options[$key] ?? null;
    }
}
