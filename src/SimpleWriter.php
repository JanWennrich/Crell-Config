<?php

declare(strict_types=1);

namespace Crell\Config;

use Crell\Serde\Serde;
use Crell\Serde\SerdeCommon;

final class SimpleWriter implements ConfigWriter
{
    public function __construct(
        private readonly ConfigSource $configSource,
        private readonly Serde $serde = new SerdeCommon()
    ) {
    }

    public function write(object $object): void
    {
        $id = $this->deriveId($object);

        $data = $this->serde->serialize($object, 'array');

        $this->configSource->write($id, $data);
    }

    /**
     *
     * This might be syntactically easier with AttributeUtils,
     * but for just a single class-level attribute it's not worth
     * the extra CPU cycles.
     */
    private function deriveId(object $object): string
    {
        $rClass = new \ReflectionClass($object);

        /** @var Config[] $attribs */
        $attribs = array_map(
            static fn(\ReflectionAttribute $a) => $a->newInstance(),
            $rClass->getAttributes(Config::class, \ReflectionAttribute::IS_INSTANCEOF)
        );

        return $attribs[0]?->key ?? strtolower(str_replace('\\', '_', $object::class));
    }
}