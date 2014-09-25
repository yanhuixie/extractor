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

use Exception;
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
        $fileName = dirname(__FILE__) . '/Fixtures/file.zip';

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
        $fileName = dirname(__FILE__) . '/Fixtures/file2.zip';

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
        $fileName = dirname(__FILE__) . '/Fixtures/file.zipo';

        $extractor = new Extractor();

        try {
            $extractor->extractFromFile($fileName);
            $this->fail();
        } catch (Exception $e) {

        }
    }
}
