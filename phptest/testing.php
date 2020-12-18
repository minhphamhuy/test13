<?php
namespace Tests;


use PHPUnit\Framework\TestCase;

class tooltest extends TestCase
{
    public function testinginput()
    {
        $testdata = '\\data123\\';
        $expectedresult = 'data123';
      
        include 'scripts/tools.php';
        $result= test_input($testdata);
        $this->assertEquals($expectedresult, $result);
        //test success
    }
    public function testingemailval()
    {
        $testdata = 'email123';
        $expectedresult = false;
      
        
        $result= is_valid_email($testdata);
        $this->assertEquals($expectedresult, $result);
        //test error
    }
    public function testingprePrintArray()
    {
        
        $expectedresult = "name";
        $arr= "name";

        $result= prePrintArray($arr, $returnAsString=false );

        $this->assertEquals($expectedresult, $result);
        //test fail
    }

 
}