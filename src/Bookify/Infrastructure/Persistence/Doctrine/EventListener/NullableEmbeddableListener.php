<?php

namespace Bookify\Infrastructure\Persistence\Doctrine\EventListener;

use Doctrine\Persistence\Event\LifecycleEventArgs;
use ReflectionClass;
use Bookify\Domain\Attributes\Nullable;
use ReflectionObject;

class NullableEmbeddableListener
{
    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->handleNullableEmbeddables($args->getObject());
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $this->handleNullableEmbeddables($args->getObject());
    }

    public function postLoad(LifecycleEventArgs $args): void
    {
        $this->handleNullableEmbeddables($args->getObject(), true);
    }

    /**
     * @throws \ReflectionException
     */
    private function handleNullableEmbeddables(object $entity, bool $isPostLoad = false): void
    {
        $reflection = new ReflectionClass($entity);
        foreach ($reflection->getProperties() as $property) {
            $propertyAttributes = $property->getAttributes(Nullable::class);
            if (empty($propertyAttributes)) {
                continue;
            }
            $property->setAccessible(true);
            $embeddable = $property->getValue($entity);

            if ($this->areAllPropertiesNull($embeddable) && $isPostLoad) {
                // When Doctrine loads the entity, if the embeddable is an empty array, we convert it to null.
                $property->setValue($entity, null);
            }

            if ($this->areAllPropertiesNull($embeddable) && !$isPostLoad) {
                // Before persisting or updating, if the embeddable is `null`, we convert it to `[]`.
                if ($property->getValue($entity) === null) {
                    $property->setValue($entity, []);
                }
            }
        }
    }

    /**
     * @throws \ReflectionException
     */
    private function areAllPropertiesNull(mixed $object): bool
    {
        $objectReflection = new ReflectionClass($object);
        foreach ($objectReflection->getProperties() as $property) {
            $property->setAccessible(true);
            if ($property->isInitialized($object) && null !== $property->getValue($object)) {
                return false;
            }
        }

        return true;
    }
}