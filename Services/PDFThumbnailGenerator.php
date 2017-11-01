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
 * Class PDFThumbnailGenerator
 * @package PDFTronBundle\Services
 */
class PDFThumbnailGenerator extends PDFTron
{
    /**
     * @var array
     */
    private $optionSets;

    /**
     * PDFTron constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create an image from a page of a PDF.
     *
     * @param string $PDFFilePath
     * @param string $outputPath
     * @param int $dpi
     * @param int $page
     * @param string $imageType
     */
    public function drawImage($PDFFilePath = '', $outputPath = '', $dpi = 92, $page = 1, $imageType = 'JPEG')
    {
        $draw = new \PDFDraw();
        $draw->SetDPI($dpi);

        $doc = new \PDFDoc($PDFFilePath);
        $doc->InitSecurityHandler();
        $pg = $doc->GetPage($page);
        $draw->Export($pg, $outputPath, $imageType);
        $doc->Close();
    }
}