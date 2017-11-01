<?php

namespace IrishDan\PDFTronBundle\Services;

use IrishDan\PDFTronBundle\PDFXODMapping;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

/**
 * Class PDFToXODConverter
 *
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

    public function convertPDFToXOD(PDFXODMapping $fileMapping, $optionsSetName = '')
    {
        if (!empty($fileMapping->PDFPath) && file_exists($fileMapping->PDFPath)) {
            if (!empty($optionsSetName) && !empty($this->optionSets[$optionsSetName])) {
                $outputOptions = $this->createXODOutputOptions($this->optionSets[$optionsSetName]);
                \Convert::ToXOD($fileMapping->PDFPath, $fileMapping->XODPath, $outputOptions);
            } else {
                \Convert::ToXOD($fileMapping->PDFPath, $fileMapping->XODPath);
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