<?php

namespace BYanelli\Actions\Tests;

use Action;

class ActionTest extends TestCase
{
    public function testClosureAction()
    {
        Action::bind('testClosureAction', function (bool $foo, bool $bar) {
            return ($foo != $bar);
        });

        $val = Action::testClosureAction(true, false);

        $this->assertTrue($val);
    }

    public function testInvokableAction()
    {
        $val = Action::testInvokableAction();

        $this->assertEquals('invokable result', $val);
    }

    public function testCallActionWithContainer()
    {
        Action::bind('calledWithContainer', function (int $foo, int $bar) {
            return ($foo == 1) && ($bar == 2);
        });

        $val = Action::make('calledWithContainer')->callWith(['bar' => 2, 'foo' => 1]);

        $this->assertTrue($val);
    }
}
