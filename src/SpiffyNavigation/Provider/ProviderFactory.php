<?php

namespace SpiffyNavigation\Provider;

class ProviderFactory
{
    /**
     * @var array
     */
    protected static $classmap = array(
        'array' => 'SpiffyNavigation\Provider\ArrayProvider'
    );

    protected function __construct()
    {
    }

    /**
     * Creates a provider from a spec.
     *
     * @param array $spec
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     * @return ProviderInterface
     */
    public static function create(array $spec)
    {
        if (!isset($spec['type'])) {
            throw new \InvalidArgumentException('Missing type for provider');
        }

        $provider = null;
        if (isset(static::$classmap['type'])) {
            $class    = static::$classmap['type'];
            $provider = new $class();
        } elseif (class_exists($spec['type'])) {
            $provider = new $spec['type']();
        }

        if (!$provider instanceof ProviderInterface) {
            throw new \RuntimeException('could not determine provider to create');
        }

        if (isset($spec['options'])) {
            $provider->setOptions($spec['options']);
        }

        return $provider;
    }
}