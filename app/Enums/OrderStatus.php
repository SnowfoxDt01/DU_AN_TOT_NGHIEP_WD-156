<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class OrderStatus extends Enum
{
    const CONFIRMING = 'confirming';
    const CONFIRMED = 'confirmed';
    const PREPARING = 'preparing';
    const SHIPPING = 'shipping';
    const DELIVERED = 'delivered';
    const COMPLETED = 'completed';
    const CANCELED = 'canceled';


    public static function getDescription($value): string
    {
        switch ($value) {
            case self::CONFIRMING:
                return 'Chờ xác nhận';
            case self::CONFIRMED:
                return 'Đã xác nhận';
            case self::PREPARING:
                return 'Đang chuẩn bị';
            case self::SHIPPING:
                return 'Đang giao hàng';
            case self::DELIVERED:
                return 'Đã nhận hàng';
            case self::COMPLETED:
                return 'Đã hoàn thành';
            case self::CANCELED:
                return 'Đã hủy';
            default:
                return 'Không xác định';
        }
    }
}
