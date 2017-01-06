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
        error_reporting(E_ALL & ~E_STRICT);
        require_once(__DIR__ . '/../PDFNetWrappers/PDFNetC/Lib/PDFNetPHP.php');

        \PDFNet::Initialize();
    }
}