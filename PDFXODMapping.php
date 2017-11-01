<?php
/**
 * This file is part of the IrishDan\PDFTronBundle package.
 *
 * (c) Daniel Byrne <danielbyrne@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source
 * code.
 */

namespace IrishDan\PDFTronBundle;

/**
 * Class PDFXODMapping
 *
 * @package IrishDan\PDFTronBundle
 */
class PDFXODMapping
{
    /**
     * @var
     */
    public $PDFPath;

    /**
     * @var
     */
    public $XODPath;

    /**
     * PDFXODMapping constructor.
     * @param $PDFPath
     * @param $XODPAth
     */
    public function __construct($PDFPath, $XODPAth)
    {
        $this->PDFPath = $PDFPath;
        $this->XODPath = $XODPAth;
    }
}