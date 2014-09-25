<?php

/**
 * This file is part of the Extractor package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 */

namespace Mmoreram\Extractor\tests;

use Mmoreram\Extractor\Exception\AdapterNotAvailableException;
use Mmoreram\Extractor\Exception\FileNotFoundException;
use Mmoreram\Extractor\Extractor;
use PHPUnit_Framework_TestCase;

/**
 * Class ExtractorTest
 */
class ExtractorTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests extractFromFile
     */
    public function testExtractFromFile()
    {
        $fileName = dirname(__FILE__) . '/Adapter/Fixtures/file.phar';

        $extractor = new Extractor();

        $this->assertInstanceOf(
            'Symfony\Component\Finder\Finder',
            $extractor->extractFromFile($fileName)
        );
    }

    /**
     * Tests extractFromFile
     */
    public function testExtractFromNonExistingFile()
    {
        $fileName = dirname(__FILE__) . '/Adapter/Fixtures/phar2.phar';

        $extractor = new Extractor();

        try {
            $extractor->extractFromFile($fileName);
            $this->fail();
        } catch (FileNotFoundException $e) {

        }
    }

    /**
     * Tests extractFromFile
     */
    public function testExtractWithNotAvailableAdapter()
    {
        $fileName = dirname(__FILE__) . '/Adapter/Fixtures/file.phar';

        $extractorAdapterInterface = $this
            ->getMock('\Mmoreram\Extractor\Adapter\Interfaces\ExtractorAdapterInterface');

        $extractorAdapterInterface
            ->expects($this->any())
            ->method('isAvailable')
            ->will($this->returnValue(false));

        $extractor = $this
            ->getMockBuilder('\Mmoreram\Extractor\Extractor')
            ->setMethods(array('instanceExtractorAdapter'))
            ->getMock();

        $extractor
            ->expects($this->any())
            ->method('instanceExtractorAdapter')
            ->will($this->returnValue($extractorAdapterInterface));

        try {
            $extractor->extractFromFile($fileName);
            $this->fail();
        } catch (AdapterNotAvailableException $e) {

        }
    }

    /**
     * Tests extractFromFile
     */
    public function testExtractWithMultiExtension()
    {
        $fileName = dirname(__FILE__) . '/Adapter/Fixtures/file.tar.gz';

        $extractor = new Extractor();

        try {
            $extractor->extractFromFile($fileName);
        } catch (AdapterNotAvailableException $e) {
            $this->fail();
        }
    }
}
