<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\DecidirPromotions\Model;

use Prisma\DecidirPromotions\Api\Data\TransactionSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Service Data Object with Rule search results.
 */
class TransactionSearchResults extends SearchResults implements TransactionSearchResultsInterface
{
}
