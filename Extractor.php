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

namespace Mmoreram\Extractor;

use Exception;
use Mmoreram\Extractor\Exception\ExtensionNotSupportedException;
use Mmoreram\Extractor\Exception\FileNotFoundException;
use Symfony\Component\Finder\Finder;
use ZipArchive;

/**
 * Class Extractor
 */
class Extractor
{
    /**
     * @var string
     *
     * Path
     */
    private $directory;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->directory = sys_get_temp_dir() . "/" . uniqid(time());
    }

    /**
     * Extract files from compressed file
     *
     * @param string $filePath Compressed file path
     *
     * @return Finder Finder instance with all files added
     *
     * @throws ExtensionNotSupportedException Exception not found
     * @throws Exception                      File must be a zip package
     * @throws FileNotFoundException          File not found
     */
    public function extractFromFile($filePath)
    {
        if (!class_exists('\ZipArchive')) {

            throw new ExtensionNotSupportedException('ZipArchive');
        }

        if (!is_file($filePath)) {

            throw new FileNotFoundException($filePath);
        }

        $extension = pathinfo($filePath, PATHINFO_EXTENSION);

        if ($extension != 'zip') {

            throw new Exception('File must be a zip package');
        }

        $this->checkDirectory();

        $zipArchive = new ZipArchive();
        $zipArchive->open($filePath);
        $zipArchive->extractTo($this->directory);

        return $this->createFinderFromDirectory();
    }

    /**
     * Check directory existence and integrity
     *
     * @return $this self Object
     */
    protected function checkDirectory()
    {
        if (!is_dir($this->directory)) {

            mkdir($this->directory);
        }

        return $this;
    }

    /**
     * Create finder from a directory
     *
     * @param string $directory Directory
     *
     * @return Finder
     */
    protected function createFinderFromDirectory()
    {
        $finder = Finder::create();
        $finder->in($this->directory);

        return $finder;
    }
}
