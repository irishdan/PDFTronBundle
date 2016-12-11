<?php

namespace PDFTronBundle\Services;

/**
 * Class PDFTron
 * @package PDFTronBundle\Services
 */
class PDFTron
{
    /**
     * PDFTron constructor.
     */
    public function __construct()
    {
        PDFNet::Initialize();
    }

    /**
     * @param string $PDFFilePath
     * @param string $XODFilePath
     */
    public function convertPDFToXOD($PDFFilePath = '', $XODFilePath = '') {
        if (!empty($PDFFilePAth) && file_exists($PDFFilePath)) {
            Convert::ToXOD($PDFFilePath, $XODFilePath);
        }
    }

}