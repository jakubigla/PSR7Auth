<?php

namespace PSR7AuthTest\AccessRule;

use Psr\Http\Message\ServerRequestInterface;
use PSR7Auth\AccessRule\RequestMethodRule;

/**
 * Class RequestMethodRuleTest
 */
class RequestMethodRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \PSR7Auth\Exception\AccessRuleException
     * @expectedExceptionMessage Invalid request method
     */
    public function testRuleThrowingExceptionForInvalidRequestMethod()
    {
        /** @var ServerRequestInterface | \PHPUnit_Framework_MockObject_MockObject $request */
        $request = $this->getMock(ServerRequestInterface::class);
        $rule    = new RequestMethodRule(['POST']);
        $rule->__invoke($request);
    }

    public function testRuleSatisfied()
    {
        /** @var ServerRequestInterface | \PHPUnit_Framework_MockObject_MockObject $request */
        $request = $this->getMock(ServerRequestInterface::class);
        $rule    = new RequestMethodRule([null]);
        $result  = $rule->__invoke($request);

        $this->assertTrue($result);
    }
}
