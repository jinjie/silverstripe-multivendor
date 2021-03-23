<?php

/**
 * ListingAdmin
 *
 * @package SwiftDevLabs\MultiVendor\Admin
 * @author Kong Jin Jie <jinjie@swiftdev.sg>
 */

namespace SwiftDevLabs\MultiVendor\Admin;

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SwiftDevLabs\MultiVendor\Models\Listing;

class ListingAdmin extends ModelAdmin
{
    private static $managed_models = [
        Listing::class,
    ];

    private static $url_segment = 'listings';

    private static $menu_title = 'Listings';

    protected function getGridFieldConfig(): GridFieldConfig
    {
        $config = parent::getGridFieldConfig();

        $dataColumns = $config->getComponentByType(GridFieldDataColumns::class);
        $dataColumns->setDisplayFields([
            'Title'       => 'Title',
            'Price'       => 'Price',
            'Member.Name' => 'Member',
            'Created.Nice' => 'Created',
            'LastEdited.Nice' => 'Last edited'
        ]);

        return $config;
    }
}
