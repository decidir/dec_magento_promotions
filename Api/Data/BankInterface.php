<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\DecidirPromotions\Api\Data;

interface BankInterface
{
    public function getEntityId();
    public function getBankName();
    public function setBankName($name);
    public function getThumbnail();
    public function setThumbnail($path);
    public function getIsActive();
    public function setIsActive($isActive);
}
