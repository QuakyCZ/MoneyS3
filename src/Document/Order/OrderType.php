<?php

namespace eProduct\MoneyS3\Document\Order;

enum OrderType: string
{
    case RECEIVED = 'received';        // SeznamObjPrij
    case ISSUED = 'issued';            // SeznamObjVyd
    case OFFER_RECEIVED = 'offer_received'; // SeznamNabPrij 
    case OFFER_ISSUED = 'offer_issued';     // SeznamNabVyd
    case INQUIRY_RECEIVED = 'inquiry_received'; // SeznamPoptPrij
    case INQUIRY_ISSUED = 'inquiry_issued';     // SeznamPoptVyd

    /**
     * Gets the root XML element name for this order type
     */
    public function getRootElement(): string
    {
        return match ($this) {
            self::RECEIVED => 'ObjPrij',
            self::ISSUED => 'ObjVyd',
            self::OFFER_RECEIVED => 'NabPrij',
            self::OFFER_ISSUED => 'NabVyd',
            self::INQUIRY_RECEIVED => 'PoptPrij',
            self::INQUIRY_ISSUED => 'PoptVyd',
        };
    }

    /**
     * Gets the list root XML element name for this order type
     */
    public function getListRootElement(): string
    {
        return match ($this) {
            self::RECEIVED => 'SeznamObjPrij',
            self::ISSUED => 'SeznamObjVyd',
            self::OFFER_RECEIVED => 'SeznamNabPrij',
            self::OFFER_ISSUED => 'SeznamNabVyd',
            self::INQUIRY_RECEIVED => 'SeznamPoptPrij',
            self::INQUIRY_ISSUED => 'SeznamPoptVyd',
        };
    }
}
