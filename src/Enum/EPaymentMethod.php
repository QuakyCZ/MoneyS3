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

}
