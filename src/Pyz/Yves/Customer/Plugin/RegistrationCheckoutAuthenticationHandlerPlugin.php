<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Pyz\Yves\Customer\Plugin;

use Generated\Shared\Transfer\QuoteTransfer;
use Pyz\Yves\Application\Business\Model\FlashMessengerInterface;
use Pyz\Yves\Customer\Plugin\CheckoutAuthenticationHandlerPluginInterface;
use Pyz\Yves\Customer\CustomerFactory;
use Spryker\Yves\Kernel\AbstractPlugin;

/**
 * @method CustomerFactory getFactory()
 */
class RegistrationCheckoutAuthenticationHandlerPlugin extends AbstractPlugin implements CheckoutAuthenticationHandlerPluginInterface
{

    /**
     * @var \Pyz\Yves\Application\Business\Model\FlashMessengerInterface
     */
    protected $flashMessenger;

    /**
     * @param \Pyz\Yves\Application\Business\Model\FlashMessengerInterface $flashMessenger
     */
    public function __construct(FlashMessengerInterface $flashMessenger)
    {
        $this->flashMessenger = $flashMessenger;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function addToQuote(QuoteTransfer $quoteTransfer)
    {
        $customerResponseTransfer = $this->getFactory()
            ->createAuthenticationHandler()
            ->registerCustomer($quoteTransfer->getCustomer());

        $quoteTransfer->setCustomer(null);

        if ($customerResponseTransfer->getIsSuccess() === true) {
            $quoteTransfer->setCustomer($customerResponseTransfer->getCustomerTransfer());
        } else {
            foreach ($customerResponseTransfer->getErrors() as $errorTransfer) {
                $this->flashMessenger->addErrorMessage($errorTransfer->getMessage());
            }
        }

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return bool
     */
    public function canHandle(QuoteTransfer $quoteTransfer)
    {
        return ($quoteTransfer->getCustomer() !== null);
    }

}
