<?php

namespace Pyz\Zed\Examprep\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

class ExamprepFacade extends AbstractFacade implements ExamprepFacadeInterface
{
	// Your code goes here
    // The order of implementation is incorrect in the tutorial.
    // The facade is calling to the factory, which will then in turn call the StringReverser class.

    /**
    * @param string $originalString
    *
    * @return string
    */
    public function reverseString($originalString)
    {
    return $this->getFactory()
        ->createStringReverser()
        ->reverseString($originalString);
    }

}
