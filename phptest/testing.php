<?php
namespace Tests;


use PHPUnit\Framework\TestCase;

class tooltest extends TestCase
{
    public function testingtools()
    {
        $testemail = 'email123';
        $result1 = false;
        $result2 = true;
        include '../tools.php';
        $result= is_valid_email($testemail);
        $this->assertEquals($result1, $result);
    }
}