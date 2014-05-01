<?php

namespace Carbon6\CodeGeneratorBundle\Tests\Generator;

use Carbon6\CodeGeneratorBundle\Generator\Generator;


/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-04-30 at 15:44:05.
 */
class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Generator
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Generator;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    function test_it_should_be_instance_of()
    {
        $this->assertInstanceOf('Carbon6\CodeGeneratorBundle\Generator\Generator' , $this->object);
    }

    function test_if_length_accessors_work()
    {
        $length = 8;

        $this->object->setLength($length);
        $this->assertEquals($length, $this->object->getLength());
    }

    /**
     * @expectedException RangeException
     */
    function test_if_length_should_be_greater_than_1()
    {
        $this->object->setLength(0);
    }

    function test_if_can_be_constructed_with_params()
    {
        $length = 19;
        $chars = 'ASDFGH';

        $object = new Generator($length, $chars);

        $this->assertEquals($length, $object->getLength());
        $this->assertEquals($chars, $object->getChars());
    }

    function test_if_chars_accessors_work()
    {
        $chars = Generator::CHARS_NUMBERS;

        $this->object->setChars($chars);
        $this->assertEquals($chars, $this->object->getChars());
    }

    /**
     * @expectedException RangeException
     */
    function test_if_chars_should_not_be_empty()
    {
        $this->object->setChars('');
    }

    function test_if_generates_a_new_code()
    {
        $result = $this->object->generate();

        $this->assertRegExp('/\w+/', $result);
    }

    /**
     * @dataProvider charssProvider
     */
    function test_if_generates_code_only_with_provided_chars($regexp, $chars)
    {
        $this->object->setChars($chars);
        $result = $this->object->generate();

        $this->assertRegExp($regexp, $result);
    }

    public function charssProvider()
    {
        $cr = new \ReflectionClass('Carbon6\CodeGeneratorBundle\Generator\Generator');
        $return = [];

        foreach ($cr->getConstants() as $const => $chars) {
            if (preg_match('/^CHARS_/', $const)) {
                $return[] =[
                    sprintf('/^[%s]*$/', preg_quote($chars)),
                    $chars,
                ];
            }
        }

        return $return;
    }

    /**
     * @dataProvider lengthsProvider
     */
    function test_if_generated_codes_are_of_right_length($length)
    {
        $result = $this->object
            ->setLength($length)
            ->generate()
        ;

        $this->assertEquals($length, mb_strlen($result));
    }

    public function lengthsProvider()
    {
        $return = [];

        foreach (range(1, 20, 4) as $length) {
            $return[] = [$length];
        }
        return $return;
    }

    function test_if_generates_different_codes()
    {
        $result1 = $this->object->generate();
        $result2 = $this->object->generate();

        $this->assertTrue($result1 != $result2);
    }

    function test_if_works_with_multibite()
    {
        $result = $this->object
            ->setChars('áåÇ√å¬ˆ–º¬“‘≤÷åº•¶§∞¢')
            ->setLength(64)
            ->generate()
        ;

        $enc = mb_detect_encoding($result);
        $this->assertEquals(64, mb_strlen($result, $enc));
    }
}