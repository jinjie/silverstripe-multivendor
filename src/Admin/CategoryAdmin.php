<?php

/**
 * CategoryAdmin
 *
 * @package SwiftDevLabs\MultiVendor\Admin
 * @author Kong Jin Jie <jinjie@swiftdev.sg>
 */

namespace SwiftDevLabs\MultiVendor\Admin;

use Package\Category;
use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldDataColumns;

class CategoryAdmin extends ModelAdmin
{
    private static $managed_models = [
        Category::class,
    ];

    private static $url_segment = 'categories';

    private static $menu_title = 'Categories';

    protected function getGridFieldConfig(): GridFieldConfig
    {
        $config = parent::getGridFieldConfig();

        $config->getComponentByType(GridFieldDataColumns::class)
            ->setFieldCasting([
                'Breadcrumbs' => 'HTMLText->RAW',
            ]);

        return $config;
    }
}
