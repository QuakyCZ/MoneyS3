<?php

namespace eProduct\MoneyS3\Enum;

enum EPaymentMethod: string
{
    case CASH = 'hotově';
    case BANK_TRANSFER = 'převodem';
    case SLIP = 'složenkou';
    case ON_DELIVERY = 'dobírkou';
    case CARD = 'plat. kart.';

    case COLLECTION = 'inkasem';
    case CREDIT = 'zápočtem';


    public function getAccount(): string
    {
        return match ($this) {
            self::CASH => 'POK',
            self::BANK_TRANSFER => 'BAN',
            self::SLIP => 'BAN',
            self::ON_DELIVERY => 'HOT',
            self::CARD => 'BAN',
            self::COLLECTION => 'BAN',
            self::CREDIT => 'BAN',
        };
    }

}
