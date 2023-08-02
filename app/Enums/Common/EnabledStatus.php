<?php

declare(strict_types=1);

namespace App\Enums\Common;

/**
 * 関連するマスタで有効・無効を制御するために利用している
 */
enum EnabledStatus: string
{
    case ENABLED  = 'enabled';
    case DISABLED = 'disabled';

    /**
     * @return string[]
     */
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
