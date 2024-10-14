<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PaymentMethod extends Enum
{
    const CASH = 'cash';
    const CARD = 'card';
    const PAYPAL = 'paypal';

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::CASH:
                return 'Tiền mặt';
            case self::CARD:
                return 'Thẻ tín dụng';
            case self::PAYPAL:
                return 'PayPal';
            default:
                return self::getKey($value);
        }
    }
}
