<?php

declare (strict_types=1);

namespace eProduct\MoneyS3\Agenda;

use eProduct\MoneyS3\ISerializable;

interface IAgenda extends ISerializable
{
    public function getType(): EAgenda;
    public function isEmpty(): bool;
    public function flush(): void;
}
