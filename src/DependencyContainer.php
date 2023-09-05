<?php

namespace DannyXCII\DependencyInjection;

use DannyXCII\DependencyInjection\Exception\NotFoundException;
use Psr\Container\ContainerInterface;

class DependencyContainer implements ContainerInterface
{
    private array $container = [];

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return void
     */
    public function add(string $key, mixed $value): void
    {
        $this->container[$key] = $value;
    }

    /**
     * @param $id
     *
     * @return mixed
     *
     * @throws NotFoundException
     */
    public function get($id): mixed
    {
        if (!$this->has($id)) {
            throw new NotFoundException("Dependency not found $id");
        }

        // Check if the service with the given key is a FQCN and try to resolve it.
        if (class_exists($id)) {
            return $this->resolveService($id);
        }

        return $this->container[$id];
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function has(string $id): bool
    {
        return isset($this->container[$id]);
    }

    /**
     * @return array
     */
    public function getServices(): array
    {
        return $this->container;
    }

    /**
     * Resolve a service by its fully qualified class name (FQCN).
     *
     * @param string $className
     *
     * @return mixed
     *
     * @throws NotFoundException
     */
    private function resolveService(string $className): mixed
    {
        foreach ($this->container as $key => $value) {
            var_dump($key, $value);
//            if ($value instanceof $className) {
//                return $value;
//            }
        }

        throw new NotFoundException("Dependency not found: $className");
    }
}