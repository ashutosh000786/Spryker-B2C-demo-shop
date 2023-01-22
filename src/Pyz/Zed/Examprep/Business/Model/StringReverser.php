<?php

namespace Pyz\Zed\Examprep\Business\Model;

class StringReverser
{
    public function reverseString($originalString)
    {
        return strrev($originalString);
    }

}
