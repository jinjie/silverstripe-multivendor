<?php

/**
 * Listing
 *
 * @package SwiftDevLabs\MultiVendor\Models
 * @author Kong Jin Jie <jinjie@swiftdev.sg>
 */

namespace SwiftDevLabs\MultiVendor\Models;

use SilverStripe\Forms\CompositeValidator;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;

class Listing extends DataObject
{
    private static $table_name = 'MultiVendor_Listing';

    private static $db = [
        'Title'       => 'Varchar(200)',
        'Description' => 'Text',
        'Price'       => 'Float',
    ];

    private static $field_labels = [
        'Title' => 'Listing title',
    ];

    private static $has_one = [
        'Member' => Member::class,
    ];

    private static $summary_fields = [
        'Title',
        'Price',
    ];

    public function getCMSCompositeValidator(): CompositeValidator
    {
        $compositeValidator = parent::getCMSCompositeValidator();

        $validator = \ZenValidator::create();
        $validator->addRequiredFields(
            'Title',
            'Description'
        );

        $validator->setConstraint('Price', \Constraint_type::create('number'));

        $compositeValidator->addValidator($validator);

        return $compositeValidator;
    }
}
