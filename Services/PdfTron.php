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
 * Class PDFTron
 *
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