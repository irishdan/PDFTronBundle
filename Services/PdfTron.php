<?php

namespace PDFTronBundle\Services;

/**
 * Class PDFTron
 * @package PDFTronBundle\Services
 */
class PDFTron
{
    /**
     * @var string
     */
    private $XODDirectory;

    /**
     * PDFTron constructor.
     */
    public function __construct($rootDirectory, $XODDirectory = 'web/XOD/')
    {
        $this->XODDirectory = $rootDirectory . '/../' . $XODDirectory;
    }

    /**
     * @param string $PDFName
     */
    public function convert($PDFFilePath = '') {
        if (!empty($PDFFilePAth) && file_exists($PDFFilePath)) {
            PDFNet::Initialize();
            Convert::ToXOD(
                $PDFFilePath,
                $this->XODPath($PDFFilePath)
            );
        }
    }

    /**
     * @return string
     */
    public function getXODDirectory()
    {
        return $this->XODDirectory;
    }

    /**
     * @param $filename
     * @return string
     */
    public function XODPath($filename) {
        $pathArray = explode('/', $filename);
        $PDFName = array_pop($pathArray);
        $filename = explode('.', $PDFName);
        array_pop($filename);

        return $this->getXODDirectory() . '' . $filename . '.xod';
    }
}