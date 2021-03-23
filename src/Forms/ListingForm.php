<?php

/**
 * ListingForm
 *
 * @package SwiftDevLabs\MultiVendor\Forms
 * @author Kong Jin Jie <jinjie@swiftdev.sg>
 */

namespace SwiftDevLabs\MultiVendor\Forms;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SwiftDevLabs\MultiVendor\Models\Listing;

class ListingForm extends Form
{
    public function __construct($controller, $name)
    {
        $fields = Listing::create()->getFrontEndFields();
        $actions = FieldList::create();

        $actions->push(FormAction::create('doSave', _t(self::class . ".SAVE", "Save")));

        $validator = Listing::create()->getValidator();

        parent::__construct(
            $controller,
            $name,
            $fields,
            $actions,
            $validator
        );

        if ($listing = $this->getListing()) {
            $this->loadDataFrom($listing);

            $this->Actions()->push(
                FormAction::create('doDelete', 'Delete')
            );
        }

        return $this;
    }

    public function getListing()
    {
        $listingId = $this->getController()->getRequest()->getSession()->get(self::class . '.ListingID');
        $listing = Listing::get()->filter('ID', $listingId)->First();

        return $listing;
    }

    public function doSave($data, $form)
    {
        if (!$listing = $this->getListing()) {
            $listing = Listing::create();
        }

        $form->saveInto($listing);

        if ($listing->isInDB()) {
            $listing->write();
            $this->sessionMessage(
                _t(self::class . ".LISTING_SAVED", "Listing saved")
            );
        } else {
            $listing->write();
            $this->sessionMessage(
                _t(self::class . ".LISTING_CREATED", "Listing created")
            );
        }

        return $this->getController()->redirectBack();
    }

    public function doDelete($data, $form)
    {
        if ($listing = $this->getListing()) {
            $listing->delete();
        }

        $this->sessionMessage(
            _t(self::class . ".LISTING_DELETED", "Listing deleted")
        );

        return $this->getController()->redirect($this->getController()->Link('add'));
    }
}
