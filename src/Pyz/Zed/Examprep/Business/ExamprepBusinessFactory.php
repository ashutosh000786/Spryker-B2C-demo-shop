<?php

namespace Pyz\Zed\Examprep\Business;

use Pyz\Zed\Examprep\Business\Model\StringReverser;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

class ExamprepBusinessFactory extends AbstractBusinessFactory
{
    // The order of implementation is incorrect in the tutorial.
    // In the original, it is having the factory call itself. This will result in errors.
    // In this case, the facade calls to the factory which calls to the string reverser.

    /**
    * @return StringReverser
    */
    public function createStringReverser()
    {
        return new StringReverser();
    }
}
