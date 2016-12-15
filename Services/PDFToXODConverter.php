<?php

namespace PDFTronBundle\Services;

use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

/**
 * Class PDFToXODConverter
 * @package PDFTronBundle\Services
 */
class PDFToXODConverter extends PDFTron
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
        parent::__construct();

        $this->optionSets = $optionSets;
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