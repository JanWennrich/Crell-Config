<?php

declare(strict_types=1);

namespace Crell\Config;

use WriteiniFile\WriteiniFile;

readonly class IniFileSource implements ConfigSource
{
    public function __construct(
        private string $directory,
    ) {}

    public function load(string $id): array
    {
        $filePath = $this->directory . '/' . $id . '.ini';
        if (!file_exists($filePath)) {
            return [];
        }
        return parse_ini_file($filePath) ?: [];
    }

    public function write(string $id, array $configData): void
    {
        $filePath = $this->directory . '/' . $id . '.ini';

        $writeIniFile = new WriteiniFile($filePath);

        $writeIniFile->create($configData)->write();
    }
}
