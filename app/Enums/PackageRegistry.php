<?php

namespace App\Enums;

enum PackageRegistry: string
{
    case Unknown = 'unknown';
    case Packagist = 'packagist';
    case Npm = 'npm';
    case None = 'none';

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $registry) => [$registry->value => $registry->label()])
            ->all();
    }

    public function label(): string
    {
        return match ($this) {
            self::Unknown => 'Unknown (detect automatically)',
            self::Packagist => 'Packagist (Composer)',
            self::Npm => 'npm',
            self::None => 'None (GitHub only)',
        };
    }

    public function isDetermined(): bool
    {
        return $this !== self::Unknown;
    }

    public function publishesPackage(): bool
    {
        return in_array($this, [self::Packagist, self::Npm], true);
    }
}
