<?php

namespace PDFTronBundle\Services;

/**
 * Class PDFTron
 * @package PDFTronBundle\Services
 */
class PDFTron
{
    /**
     * @param string $PDFFilePath
     * @param string $XODFilePath
     */
    public function convertPDFToXOD($PDFFilePath = '', $XODFilePath = '') {
        if (!empty($PDFFilePAth) && file_exists($PDFFilePath)) {
            PDFNet::Initialize();
            Convert::ToXOD($PDFFilePath, $XODFilePath);
        }
    }

}