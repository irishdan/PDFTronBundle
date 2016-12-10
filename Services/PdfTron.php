<?php

namespace PdfTronBundle\Services;

/**
 * Class PdfTron
 * @package PdfTronBundle\Services
 */
class PdfTron
{
    /**
     * @var string
     */
    private $pdfDirectory;

    /**
     * @var string
     */
    private $xodDirectory;

    /**
     * PdfTron constructor.
     */
    public function __construct($rootDir) {
        $this->pdfDirectory = $rootDir . '/../pdf/';
        $this->xodDirectory = $rootDir . '/../web/xod/';
    }

    /**
     * @param string $pdfName
     */
    public function convert($pdfName = '') {
        if (!empty($pdfName)) {
            PDFNet::Initialize();
            Convert::ToXod(
                $this->pdfPath($pdfName),
                $this->xodPath($pdfName)
            );
        }
    }

    /**
     * @return string
     */
    public function getPdfDirectory()
    {
        return $this->pdfDirectory;
    }

    /**
     * @return string
     */
    public function getXodDirectory()
    {
        return $this->xodDirectory;
    }

    public function pdfPath($filename) {
        return $this->getPdfDirectory() . '' . $filename . '.pdf';
    }

    public function pdfExists($filename) {
        $xodPath = $this->pdfPath($filename);
        return file_exists($xodPath);
    }

    public function xodPath($filename) {
        return $this->getXodDirectory() . '' . $filename . '.xod';
    }

    public function xodExists($filename) {
        $xodPath = $this->xodPath($filename);
        return file_exists($xodPath);
    }
}