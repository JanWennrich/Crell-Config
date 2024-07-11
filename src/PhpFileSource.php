<?php

declare(strict_types=1);

namespace Crell\Config;

readonly class PhpFileSource implements ConfigSource
{
    public function __construct(
        private string $directory,
    ) {}

    public function load(string $id): array
    {
        $filePath = $this->directory . '/' . $id . '.php';
        return file_exists($filePath) ? require $filePath : [];
    }

    public function write(string $id, array $configData): void
    {
        $filePath = $this->directory . '/' . $id . '.php';

        file_put_contents($filePath, var_export($configData, true));
    }
}
