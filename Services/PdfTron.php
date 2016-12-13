<?php

namespace PDFTronBundle\Services;

use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

/**
 * Class PDFTron
 * @package PDFTronBundle\Services
 */
class PDFTron
{
    /**
     * @var array
     */
    private $optionSets;

    /**
     * PDFTron constructor.
     */
    public function __construct($optionSets = [])
    {
        $this->optionSets = $optionSets;
        \PDFNet::Initialize();
    }

    /**
     * Convert a PDF file to a webviewer XOD file.
     *
     * @param string $PDFFilePath
     * @param string $XODFilePath
     * @param string $optionsSetName
     */
    public function convertPDFToXOD($PDFFilePath = '', $XODFilePath = '', $optionsSetName = '')
    {
        if (!empty($PDFFilePAth) && file_exists($PDFFilePath)) {
            if (!empty($optionsSetName) && !empty($this->optionSets[$optionsSetName])) {
                $outputOptions = $this->createXODOutputOptions($this->optionSets[$optionsSetName]);
                \Convert::ToXOD($PDFFilePath, $XODFilePath, $outputOptions);
            }
            else {
                \Convert::ToXOD($PDFFilePath, $XODFilePath);
            }
        }
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

    /**
     * Creates an XODOutputOptions object to customise XOD output.
     *
     * @param array $options
     * @return \XODOutputOptions
     */
    protected function createXODOutputOptions($options = [])
    {
        $xodOptions = new \XODOutputOptions();
        foreach ($options as $optionKey => $optionValue) {
            // Convert to camel case.
            $converter = new CamelCaseToSnakeCaseNameConverter();
            $camel = $converter->denormalize($optionKey);
            $setter = 'set' . $camel;

            // if setter exists set te value.
            if (method_exists($xodOptions, $setter)) {
                $xodOptions->{$setter}($optionValue);
            }
        }
        return $xodOptions;
    }
}