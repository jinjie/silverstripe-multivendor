<?php

/**
 * Category
 *
 * @package Package
 * @author Kong Jin Jie <jinjie@swiftdev.sg>
 */

namespace Package;

use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\Hierarchy\Hierarchy;
use SwiftDevLabs\MultiVendor\Models\Listing;

class Category extends DataObject
{
    private static $table_name = 'MultiVendor_Category';

    private static $extensions = [
        Hierarchy::class,
    ];

    private static $db = [
        'Title' => 'Varchar(200)',
    ];

    private static $many_many = [
        'Listings' => Listing::class,
    ];

    private static $summary_fields = [
        'Title',
        'Breadcrumbs',
    ];

    private static $searchable_fields = [
        'Title',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->replaceField(
            'ParentID',
            TreeDropdownField::create(
                'ParentID',
                'Parent',
                Category::class
            )->setEmptyString('Root')
        );

        return $fields;
    }
}
