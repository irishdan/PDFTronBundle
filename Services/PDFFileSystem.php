<?php

namespace PDFTronBundle\Services;


/**
 * Class PDFFileSystem
 * @package PDFTronBundle\Services
 */
class PDFFileSystem
{
    /**
     * @var string
     */
    private $PDFDirectory;

    /**
     * @var string
     */
    private $XODDirectory;

    /**
     * @var string
     */
    private $imageDirectory;

    /**
     * PDFFileSystem constructor.
     * @param $rootDirectory
     * @param $PDFDirectory
     * @param $XODDirectory
     * @param $imageDirectory
     */
    public function __construct($rootDirectory, $PDFDirectory, $XODDirectory, $imageDirectory)
    {
        $this->PDFDirectory = $rootDirectory . '/../' . $PDFDirectory;
        $this->XODDirectory  = $rootDirectory . '/../' . $XODDirectory;
        $this->imageDirectory = $rootDirectory . '/../' . $imageDirectory;
    }

    function getPDFFilesArray($filename = '')
    {
        $files = [];
        $filesMappings = [];
        if (!empty($filename)) {
            if (!file_exists($filename)) {
                $filename = $this->getPDFDirectory() . $filename;
            }

            if (file_exists($filename)) {
                $files[] = $filename;
            }
        }
        else {
            $PDFDirectory = $this->getPDFDirectory();
            $files = array_diff(scandir($PDFDirectory), array('.', '..'));
        }

        // Out non-pdf files and generate the
        foreach ($files as $key => $path) {
            $fileInfo = pathinfo($path);
            if (!empty($fileInfo['extension'] && strtolower($fileInfo['extension']) == 'pdf')) {
                $filesMappings[$path] = $this->getXODPath($fileInfo['filename']);
            }
        }

        return $filesMappings;
    }

    /**
     * @param $filename
     * @return int
     */
    public function fileSize($filename) {
        $bytes = filesize($filename);
        return $bytes;
    }

    /**
     * @param $size
     * @param int $precision
     * @return string
     */
    function formatBytes($size, $precision = 2)
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
        return $this->XODDirectory  . '/';
    }

    /**
     * @return mixed
     */
    public function getImageDirectory()
    {
        return $this->imageDirectory  . '/';
    }

    /**
     * @param $path
     * @return string
     */
    public function getXODPath($path)
    {
        return $this->getXODDirectory() . $path . '.xod';
    }
}