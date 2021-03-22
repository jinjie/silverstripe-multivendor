<?php

/**
 * MemberExtension
 *
 * @package SwiftDevLabs\MultiVendor\Extensions
 * @author Kong Jin Jie <jinjie@swiftdev.sg>
 */

namespace SwiftDevLabs\MultiVendor\Extensions;

use SilverStripe\ORM\DataExtension;
use SwiftDevLabs\MultiVendor\Models\Listing;

class MemberExtension extends DataExtension
{
    private static $has_many = [
        'Listings' => Listing::class,
    ];
}
