<?php

/**
 * MemberListingPage
 *
 * @package SwiftDevLabs\MultiVendor\Models
 * @author Kong Jin Jie <jinjie@swiftdev.sg>
 */

namespace SwiftDevLabs\MultiVendor\Models;

use SilverStripe\Control\Controller;
use SilverStripe\ORM\PaginatedList;
use SilverStripe\Security\Security;
use SwiftDevLabs\MultiVendor\Controllers\MemberListingPageController;

class MemberListingPage extends \Page
{
    private static $table_name = 'MultiVendor_MemberListingPage';

    private static $controller_name = MemberListingPageController::class;

    private static $description = 'Create a page for listing management';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('Content');

        return $fields;
    }

    public function getListings()
    {
        $member = Security::getCurrentUser();

        if (!$member) {
            return false;
        }

        return $member->Listings();
    }

    public function getPaginatedListings()
    {
        return PaginatedList::create($this->getListings(), Controller::curr()->getRequest());
    }
}
