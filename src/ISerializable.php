<?php

namespace eProduct\MoneyS3;

use XMLWriter;

interface ISerializable
{
    /**
     * Serialize this object to XML
     * @param \XMLWriter $writer The XMLWriter instance to write to
     * @return void
     */
    public function serialize(XmlWriter $writer): void;
}