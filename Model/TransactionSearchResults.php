<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Model;

use Prisma\PaywayPromotions\Api\Data\TransactionSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Service Data Object with Rule search results.
 */
class TransactionSearchResults extends SearchResults implements TransactionSearchResultsInterface
{
}
