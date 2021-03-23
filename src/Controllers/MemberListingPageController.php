<?php

/**
 * MemberListingPageController
 *
 * @package SwiftDevLabs\MultiVendor\Controllers
 * @author Kong Jin Jie <jinjie@swiftdev.sg>
 */

namespace SwiftDevLabs\MultiVendor\Controllers;

use SilverStripe\Control\HTTPRequest;
use SilverStripe\Security\PermissionProvider;
use SilverStripe\Security\Security;
use SwiftDevLabs\MultiVendor\Forms\ListingForm;
use SwiftDevLabs\MultiVendor\Models\Listing;

class MemberListingPageController extends \PageController
{
    private static $allowed_actions = [
        'add',
        'edit',
        'ListingForm',
    ];

    public function init()
    {
        parent::init();

        if (!Security::getCurrentUser()) {
            return Security::permissionFailure($this, _t(
                self::class . '.NO_PERMISSION',
                "Please login to submit listings"
            ));
        }
    }

    public function add(HTTPRequest $request)
    {
        $request->getSession()->clear(ListingForm::class . ".ListingID");

        return $this->customise([
            'Title'       => _t(self::class . ".ADD_LISTING_TITLE", "Add Listing"),
        ]);
    }

    public function edit(HTTPRequest $request)
    {
        $listing = Listing::get()->filter('ID', $request->param('ID'))->First();

        if ($listing && $listing->canEdit(Security::getCurrentUser())) {
            $request->getSession()->set(ListingForm::class . ".ListingID", $listing->ID);
            return $this->customise([
                'Title'       => _t(self::class . ".EDIT_LISTING_TITLE", "Edit Listing"),
            ]);
        }

        return Security::permissionFailure(
            $this,
            _t(
                self::class . ".NO_PERMISSION_EDIT_LISTING",
                "You have no permission to this listing."
            )
        );
    }

    public function ListingForm()
    {
        return ListingForm::create($this, 'ListingForm');
    }
}
