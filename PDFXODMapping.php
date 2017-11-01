<?php

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