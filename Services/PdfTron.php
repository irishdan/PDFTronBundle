<?php

namespace PDFTronBundle\Services;

/**
 * Class PDFTron
 * @package PDFTronBundle\Services
 */
abstract class PDFTron
{

    /**
     * PDFTron constructor.
     */
    public function __construct()
    {
        \PDFNet::Initialize();
    }
}