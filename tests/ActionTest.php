<?php

namespace BYanelli\Actions\Tests;

use Action;

class ActionTest extends TestCase
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

    public function testInvokableAction()
    {
        $val = Action::call('testInvokableAction');

        $this->assertEquals('invokable result', $val);
    }

    public function testCallActionByMagicMethod()
    {
        $val = Action::testInvokableAction();

        $this->assertEquals('invokable result', $val);
    }
}
