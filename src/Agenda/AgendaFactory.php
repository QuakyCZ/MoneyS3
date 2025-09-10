<?php

declare(strict_types=1);

namespace eProduct\MoneyS3\Agenda;

use eProduct\MoneyS3\Exception\MoneyS3Exception;

readonly class AgendaFactory
{
    /**
     * @var array<class-string, IAgenda>
     */
    public array $instances;

    public function __construct()
    {
        $instances = [];

        foreach (EAgenda::cases() as $agenda) {
            $className = $agenda->getClassName();
            if (!class_exists($className)) {
                throw new MoneyS3Exception("Agenda class '{$className}' does not exist");
            }

            $instance = new $className();
            if (!$instance instanceof IAgenda) {
                throw new MoneyS3Exception("Class '{$className}' does not implement IAgenda");
            }
            $instances[$className] = $instance;
        }

        $this->instances = $instances;
    }

    /**
     * Get agenda instance by class name
     *
     * @template T of IAgenda
     * @param class-string<T> $className
     * @return T
     */
    public function getInstance(string $className): IAgenda
    {
        if (!isset($this->instances[$className])) {
            throw new MoneyS3Exception("Agenda instance for '{$className}' does not exist");
        }

        $instance = $this->instances[$className];
        assert($instance instanceof $className);
        return $instance;
    }

    /**
     * Clear all singleton instances (useful for testing)
     */
    public function flushInstances(): void
    {
        foreach ($this->instances as $instance) {
            $instance->flush();
        }
    }

    /**
     * Check if instance exists for given class
     *
     * @param class-string $className
     */
    public function hasInstance(string $className): bool
    {
        return isset($this->instances[$className]);
    }
}
