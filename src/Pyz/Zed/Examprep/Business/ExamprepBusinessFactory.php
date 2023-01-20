namespace Pyz\Zed\Examprep\Business;

use Pyz\Zed\Examprep\Business\Model\StringReverser;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

class ExamprepBusinessFactory extends AbstractBusinessFactory
{
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