<?php

namespace JCV\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class JCVUserBundle extends Bundle
{
    public function getParent() {
        return 'FOSUserBundle';
    }

}
