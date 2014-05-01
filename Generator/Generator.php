<?php

namespace Felds\CodeGeneratorBundle\Generator;

class Generator
{
    const CHARS_NUMBERS = '0123456789';
    const CHARS_ALPHA = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const CHARS_ALPHANUM = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const CHARS_ALPHANUM_SAFE = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';

    /**
     * @var integer $length
     */
    private $length;

    /**
     * @var string $chars
     */
    private $chars;


    /**
     * Constructor
     *
     * @param integer $length
     * @param string $chars
     */
    public function __construct($length = 12, $chars = self::CHARS_ALPHANUM_SAFE)
    {
        $this
            ->setLength($length)
            ->setChars($chars)
        ;
    }


    /**
     * Set generated code length
     *
     * @param integer $length
     * @return Generator
     * @throws RangeException
     */
    public function setLength($length)
    {
        if ($length < 1) {
            throw new \RangeException("The length should be greater than or equal to 1.");
        }

        $this->length = (integer) $length;

        return $this;
    }

    /**
     * Get the generated code length
     *
     * @return integer
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set the available characters to generate the code
     *
     * @param string $chars
     * @return Generator
     * @throws RangeException
     */
    public function setChars($chars)
    {
        if (! (string) $chars) {
            throw new \RangeException("The characters list cannot be empty.");
        }

        $this->chars = (string) $chars;

        return $this;
    }

    /**
     * Set the available characters to generate the code
     *
     * @return Generator
     */
    public function getChars()
    {
        return $this->chars;
    }

    /**
     * Generate a new code
     *
     * @return string
     */
    public function generate()
    {
        $return = '';
        $chars = preg_split('//u', $this->getChars(), -1, PREG_SPLIT_NO_EMPTY);
        $max = count($chars) - 1;

        for ($i = 0; $i < $this->getLength(); $i++) {
            $return .= $chars[mt_rand(0, $max)];
        }

        return $return;
    }
}
