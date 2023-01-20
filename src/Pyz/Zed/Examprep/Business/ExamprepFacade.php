namespace Pyz\Zed\Examprep\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

class ExamprepFacade extends AbstractFacade implements ExamprepFacadeInterface
{
	// Your code goes here
            /**
        * @return StringReverser
        */
        public function createStringReverser()
        {
            return new StringReverser();
        }
        
}