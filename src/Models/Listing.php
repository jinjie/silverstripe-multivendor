<?php

/**
 * Listing
 *
 * @package SwiftDevLabs\MultiVendor\Models
 * @author Kong Jin Jie <jinjie@swiftdev.sg>
 */

namespace SwiftDevLabs\MultiVendor\Models;

use Bummzack\SortableFile\Forms\SortableUploadField;
use Package\Category;
use SilverStripe\Assets\Image;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\Forms\CompositeValidator;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;
use SilverStripe\Security\Permission;
use SilverStripe\Security\PermissionProvider;
use SilverStripe\Security\Security;

class Listing extends DataObject implements PermissionProvider
{
    private static $table_name = 'MultiVendor_Listing';

    private static $db = [
        'Title'       => 'Varchar(200)',
        'Description' => 'Text',
        'Price'       => 'Float',
    ];

    private static $has_one = [
        'Member' => Member::class,
    ];

    private static $many_many = [
        'Images' => Image::class,
    ];

    private static $belongs_many_many = [
        'Categories' => Category::class,
    ];

    private static $many_many_extraFields = [
        'Images' => [
            'SortOrder' => 'Int',
        ]
    ];

    private static $owns = [
        'Images',
    ];

    private static $field_labels = [
        'Title' => 'Listing title',
    ];

    private static $summary_fields = [
        'Title',
        'Price',
        'Created.Nice' => 'Created',
        'LastEdited.Nice' => 'Last Edited',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('Images');
        $fields->addFieldToTab(
            'Root.Main',
            SortableUploadField::create(
                'Images',
                'Images'
            )->setFolderName('Multi Vendor Listing Images')
            ->setSortColumn('SortOrder')
        );

        if ($categoriesGridField = $fields->fieldByName('Root.Categories.Categories')) {
            $categoriesGridField->getConfig()
                ->getComponentByType(GridFieldDataColumns::class)
                ->setFieldCasting([
                    'Breadcrumbs' => 'HTMLText->RAW',
                ]);
        }

        return $fields;
    }

    public function getFrontEndFields($params = null)
    {
        $fields = parent::getFrontEndFields($params);

        $fields->removeByName('MemberID');

        return $fields;
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();

        if (!$this->MemberID && $member = Security::getCurrentUser()) {
            $this->MemberID = $member->ID;
        }
    }

    public function getCMSCompositeValidator(): CompositeValidator
    {
        $compositeValidator = parent::getCMSCompositeValidator();

        $compositeValidator->addValidator(
            $this->getValidator()->addRequiredFields(['MemberID'])
        );

        return $compositeValidator;
    }

    public function getValidator()
    {
        $validator = \ZenValidator::create();
        $validator->addRequiredFields(
            'Title',
            'Description',
            'Price'
        );

        $validator->setConstraint('Price', \Constraint_type::create('number'));

        return $validator;
    }

    public function Link($action = null)
    {
        return Controller::join_links(
            Director::baseURL(),
            'listing',
            $action ? : 'view',
            $this->ID
        );
    }

    public function canEdit($member = null)
    {
        if (Permission::check('MV_EDIT_ALL_LISTINGS', 'any', $member)) {
            return true;
        }

        if ($this->Member()->exists() && Permission::check('MV_EDIT_OWN_LISTINGS', 'any', $member)) {
            if (!$member) {
                $member = Security::getCurrentUser();
            }

            return ($this->Member()->ID === $member->ID);
        }

        return false;
    }

    public function providePermissions()
    {
        return [
            'MV_EDIT_OWN_LISTINGS' => [
                'name'     => 'Edit own listings',
                'category' => 'Multi Vendor Listings',
            ],
            'MV_EDIT_ALL_LISTINGS' => [
                'name'     => 'Edit all listings',
                'category' => 'Multi Vendor Listings',
            ],
        ];
    }

    public function getSortedImages()
    {
        return $this->Images()->Sort('SortOrder');
    }

    public function getFeaturedImage()
    {
        if ($images = $this->getSortedImages()) {
            return $images->First();
        }

        return false;
    }
}
