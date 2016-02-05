<?php

namespace Pyz\Yves\Checkout\Process\Steps;

use Generated\Shared\Transfer\QuoteTransfer;
use Pyz\Yves\Application\Business\Model\FlashMessengerInterface;
use Pyz\Yves\Checkout\Dependency\Plugin\CheckoutStepHandlerPluginInterface;
use Spryker\Client\Calculation\CalculationClient;
use Spryker\Shared\Shipment\ShipmentConstants;
use Symfony\Component\HttpFoundation\Request;

class ShipmentStep extends BaseStep
{

    /**
     * @var CalculationClient
     */
    protected $calculationClient;

    /**
     * @var CheckoutStepHandlerPluginInterface[]
     */
    protected $shipmentPlugins;

    /**
     * @param FlashMessengerInterface $flashMessenger
     * @param CalculationClient $calculationClient
     * @param string $stepRoute
     * @param string $escapeRoute
     * @param CheckoutStepHandlerPluginInterface[] $shipmentPlugins
     */
    public function __construct(
        FlashMessengerInterface $flashMessenger,
        CalculationClient $calculationClient,
        $stepRoute,
        $escapeRoute,
        array $shipmentPlugins
    ) {
        parent::__construct($flashMessenger, $stepRoute, $escapeRoute);

        $this->calculationClient = $calculationClient;
        $this->shipmentPlugins = $shipmentPlugins;
    }

    /**
     * @param QuoteTransfer $quoteTransfer
     *
     * @return bool
     */
    public function preCondition(QuoteTransfer $quoteTransfer)
    {
        return !$this->isCartEmpty($quoteTransfer);
    }

    /**
     * @param QuoteTransfer $quoteTransfer
     *
     * @return bool
     */
    public function requireInput(QuoteTransfer $quoteTransfer)
    {
        return true;
    }

    /**
     * @param Request $request
     * @param QuoteTransfer $quoteTransfer
     *
     * @return QuoteTransfer
     */
    public function execute(Request $request, QuoteTransfer $quoteTransfer)
    {
        $shipmentSelection = $quoteTransfer->getShipment()->getShipmentSelection();

        if (isset($this->shipmentPlugins[$shipmentSelection])) {
            $shipmentHandler = $this->shipmentPlugins[$shipmentSelection];
            $shipmentHandler->addToQuote($request, $quoteTransfer);
        }

        return $this->calculationClient->recalculate($quoteTransfer);
    }

    /**
     * @param QuoteTransfer $quoteTransfer
     *
     * @return bool
     */
    public function postCondition(QuoteTransfer $quoteTransfer)
    {
        if (!$this->isShipmentSet($quoteTransfer)) {
            $this->flashMessenger->addErrorMessage('checkout.step.shipment.shipment_not_set');
            return false;
        }

        return true;
    }

    /**
     * @param QuoteTransfer $quoteTransfer
     *
     * @return bool
     */
    protected function isShipmentSet(QuoteTransfer $quoteTransfer)
    {
        foreach ($quoteTransfer->getExpenses() as $expenseTransfer) {
            if ($expenseTransfer->getType() === ShipmentConstants::SHIPMENT_EXPENSE_TYPE) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array
     */
    public function getTemplateVariables()
    {
        $templateVariables = parent::getTemplateVariables();

        $templateVariables['shipmentMethodsSubForms'] = ['shipment/method'];

        return $templateVariables;
    }

}
