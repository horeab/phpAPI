<?php
use PHPUnit\Framework\TestCase;

class test extends TestCase
{
    public function testOne()
    {
        $this->assertTrue(false);
    }
    
    /**
     * @depends testOne
     */
    public function testTwo()
    {
    }
}
?>