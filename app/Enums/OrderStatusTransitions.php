<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class OrderStatusTransitions extends Enum
{
    public const TRANSITIONS = [
        'confirming' => ['confirmed', 'canceled'],
        'confirmed'  => ['preparing', 'canceled'],
        'preparing'  => ['shipping'],
        'shipping'   => ['delivered', 'canceled'],
        'delivered'  => ['completed'],
        'completed'  => [],
        'canceled'   => [],
    ];

    public static function canTransition(string $currentStatus, string $newStatus): bool
    {
        return in_array($newStatus, self::TRANSITIONS[$currentStatus] ?? []);
    }
}
