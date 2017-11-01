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

/**
 * Class PDFCropper
 * @package PDFTronBundle\Services
 */
class PDFCropper extends PDFTron
{
    /**
     * PDFTron constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Crops an external padding from every page of the PDF.
     * @param $inputPDFPath
     * @param null $outputPDFPath
     * @param int $padding
     * @param null $x2
     * @param null $y1
     * @param null $y2
     */
    public function crop($inputPDFPath, $outputPDFPath = null, $padding = 1, $x2 = null, $y1 = null, $y2 = null)
    {
        $inputDoc = new \PDFDoc($inputPDFPath);
        $inputDoc->InitSecurityHandler();

        $iterator = $inputDoc->GetPageIterator();
        for ($iterator; $iterator->HasNext(); $iterator->Next()) {
            $mediaBox = new \Rect($iterator->Current()->GetMediaBox());

            $mediaBox->x1 += $padding;
            $mediaBox->x2 -= empty($x2) ? $padding : $x2;
            $mediaBox->y1 += empty($y1) ? $padding : $y1;
            $mediaBox->y2 -= empty($y2) ? $padding : $y2;

            $mediaBox->Update();
        }

        $inputDoc->Save($outputPDFPath, 0);
        $inputDoc->Close();
    }
}