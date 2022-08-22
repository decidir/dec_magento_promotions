<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Api\Data;

interface CreditCardInterface
{
    public function getEntityId();
    public function getCardName();
    public function setCardName($name);
    public function getIdSps();
    public function setIdSps($id);
    public function getIdNps();
    public function setIdNps($id);
    public function getThumbnail();
    public function setThumbnail($path);
    public function getIsActive();
    public function setIsActive($isActive);
}
