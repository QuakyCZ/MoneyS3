<?php

namespace eProduct\MoneyS3;

use XMLWriter;

interface ISerializable
{
    public function serialize(XmlWriter $writer): void;
}