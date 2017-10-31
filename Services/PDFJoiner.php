<?php

namespace IrishDan\PDFTronBundle\Services;

/**
 * Class PDFJoiner
 * @package PDFTronBundle\Services
 */
class PDFJoiner extends PDFTron
{
    /**
     * PDFTron constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Merge PDFs sequentially.
     *
     * @param array $PDFPaths
     * @param null $outputDestination
     */
    public function joinPDFs(array $PDFPaths, $outputDestination = null) {
        foreach ($PDFPaths as $key => $PDFPath) {
            if ($key > 0) {
                $this->joinTwoPDFs($PDFPaths[$key -1], $PDFPath, $outputDestination);
            }
        }
    }

    /**
     * Merge two PDFs one after the other.
     *
     * @param $firstPDFPath
     * @param $secondPDFPath
     * @param null $outputDestination
     */
    public function joinTwoPDFs($firstPDFPath, $secondPDFPath, $outputDestination = null)
    {
        $firstPDF = new \PDFDoc($firstPDFPath);
        $firstPDF->InitSecurityHandler();

        $secondPDF = new \PDFDoc($secondPDFPath);
        $firstPDF->InsertPages(1, $secondPDF, 1, $secondPDF->GetPageCount(), \PDFDoc::e_none);
        $secondPDF->Close();

        if (!empty($outputDestination)) {
            $firstPDF->Save($outputDestination, \SDFDoc::e_remove_unused);
        }
        else {
            $firstPDF->Save($firstPDFPath, \SDFDoc::e_remove_unused);
        }

    }
}