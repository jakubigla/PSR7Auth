<?php

namespace PSR7AuthTest\AccessRule;

use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Psr\Http\Message\ServerRequestInterface;
use PSR7Auth\AccessRule\AccessRuleChain;

/**
 * Class AccessRuleChainTest
 */
class AccessRuleChainTest extends \PHPUnit_Framework_TestCase
{
    /** @var ServerRequestInterface | MockObject */
    private $request;

    /** @var AccessRuleChain | MockObject */
    private $ruleChain;

    public function setUp()
    {
        $this->request   = $this->getMock(ServerRequestInterface::class);
        $this->ruleChain = new AccessRuleChain();
    }

    public function testRuleReturningTrueIfNoRulesAttached()
    {
        $result = $this->ruleChain->__invoke($this->request);
        $this->assertTrue($result);
    }

    public function testRuleReturningTrueWithSatisfiedRuleAttached()
    {
        $this->ruleChain->attach(function () {
            return true;
        });

        $result = $this->ruleChain->__invoke($this->request);
        $this->assertTrue($result);
    }

    public function testRuleReturningFalseWithUnsatisfiedRuleAttached()
    {
        $this->ruleChain->attach(function () {
            return false;
        });

        $result = $this->ruleChain->__invoke($this->request);
        $this->assertFalse($result);
    }
}
