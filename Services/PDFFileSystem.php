<?php
/**
 * This file is part of the IrishDan\PDFTronBundle package.
 *
 * (c) Daniel Byrne <danielbyrne@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source
 * code.
 */

namespace IrishDan\PDFTronBundle\Services;

use IrishDan\PDFTronBundle\PDFXODMapping;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class PDFFileSystem
 * @package PDFTronBundle\Services
 */
class PDFFileSystem extends Filesystem
{
    /**
     * @var string
     */
    private $PDFDirectory;

    /**
     * @var string
     */
    private $XODDirectory;

    private $XODPath;

    /**
     * @var string
     */
    private $imageDirectory;

    /**
     * PDFFileSystem constructor.
     *
     * @param $rootDirectory
     * @param $PDFDirectory
     * @param $XODDirectory
     * @param $imageDirectory
     */
    public function __construct($rootDirectory, $PDFDirectory = null, $XODDirectory = null, $imageDirectory = null)
    {
        if (!empty($PDFDirectory)) {
            $this->PDFDirectory = $rootDirectory . '/../' . $PDFDirectory;
        }

        if (!empty($XODDirectory)) {
            $this->XODPath = $XODDirectory;
            $this->XODDirectory = $rootDirectory . '/../' . $XODDirectory;

            if (!$this->exists($this->XODDirectory)) {
                $this->mkdir($this->XODDirectory);
            }
        }

        if (!empty($imageDirectory)) {
            $this->imageDirectory = $rootDirectory . '/../' . $imageDirectory;

            if (!$this->exists($this->imageDirectory)) {
                $this->mkdir($this->imageDirectory);
            }
        }
    }

    public function getPDFtoXODFileMapping($filename = '')
    {
        // Get the XOD path.
        $XODPath = $this->getXODPath($filename);

        // Get the PDF path
        $this->appendExtensionIfMissing($filename);
        $PDFPath = $this->getPDFDirectory() . $filename;

        return new PDFXODMapping($PDFPath, $XODPath);
    }

    protected function appendExtensionIfMissing(&$filename, $extension = 'pdf')
    {
        if (!preg_match('/(\.' . $extension . ')$/i', $filename)) {
            $filename .= '.' . $extension;
        }
    }

    /**
     * @param $filename
     *
     * @return int
     */
    public function fileSize($filename)
    {
        $bytes = filesize($filename);
        return $bytes;
    }

    /**
     * @param $size
     * @param int $precision
     *
     * @return string
     */
    protected function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('', 'K', 'M', 'G', 'T');

        return round(pow(1024, $base - floor($base)), $precision) . '' . $suffixes[floor($base)];
    }

    /**
     * @return mixed
     */
    public function getPDFDirectory()
    {
        return $this->PDFDirectory . '/';
    }

    /**
     * @return mixed
     */
    public function getXODDirectory()
    {
        return $this->XODDirectory . '/';
    }

    /**
     * @return mixed
     */
    public function getImageDirectory()
    {
        return $this->imageDirectory . '/';
    }

    /**
     * @param $path
     * @return string
     */
    public function getXODPath($path)
    {
        return $this->getXODDirectory() . $path . '.xod';
    }

    public function getXODWebPath($path)
    {
        // $this->XODPath remove the web from the start of the string.
        $patterns = array();
        $patterns[0] = '/^(web\/)/i';
        $patterns[1] = '/^(\/web\/)/i';
        $replacements = array();
        $replacements[] = '/';
        $replacements[] = '/';

        $webPath = preg_replace($patterns, $replacements, $this->XODPath);

        return $webPath . '/' . $path . '.xod';
    }
}