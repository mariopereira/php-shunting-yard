<?php

namespace tests\Parser;

use RR\Shunt\Parser;
use RR\Shunt\Exception\RuntimeError;

class FailingParenthesisParserTest extends \PHPUnit_Framework_TestCase
{
	
    public function testParenthesisThrowsError()
    {
		$this->expectOutputString(null);
        $equation = '()';
		return Parser::parse($equation);
    }

}
