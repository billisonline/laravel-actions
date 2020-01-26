<?php

namespace BYanelli\Actions\Tests;

use Action;

class ActionFacadeTest extends TestCase
{
    public function testClosureAction()
    {
        Action::bind('testClosureAction', function ($param) {
            if ($param) {
                return true;
            }

            return false;
        });

        $val = Action::call('testClosureAction', [true]);

        $this->assertTrue($val);
    }
}
