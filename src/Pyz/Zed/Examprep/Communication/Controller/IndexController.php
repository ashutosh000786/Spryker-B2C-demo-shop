<?php

namespace Pyz\Zed\Examprep\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends AbstractController
{
    /**
    * @param Request $request
    *
    * @return array
    */
    public function indexAction(Request $request)
    {
        $originalString = "Examprep";
        $reversedString = $this->getFacade()->reverseString($originalString);
        return ['string' => $reversedString];
    }
}