<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Model;

use Prisma\PaywayPromotions\Api\Data\RuleSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Service Data Object with Rule search results.
 */
class RuleSearchResults extends SearchResults implements RuleSearchResultsInterface
{
}
