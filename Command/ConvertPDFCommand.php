<?php

namespace PDFTronBundle\Command;


use PDFTronBundle\Services\PDFTron;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


/**
 * Class ConvertPDFCommand
 * @package PDFTronBundle\Command
 */
class ConvertPDFCommand extends ContainerAwareCommand
{
    /**
     * @var PDFTron
     */
    private $PDFTron;

    /**
     * @var
     */
    private $PDFDirectory;

    /**
     * @var
     */
    private $XODDirectory;

    /**
     * ConvertPDFCommand constructor.
     * @param PDFTron $PDFTron
     * @param $rootDirectory
     * @param $PDFDirectory
     * @param $XODDirectory
     */
    public function __construct(PDFTron $PDFTron, $rootDirectory, $PDFDirectory, $XODDirectory)
    {
        $this->PDFTron = $PDFTron;
        $this->PDFDirectory = $rootDirectory . '/../' . $PDFDirectory;
        $this->XODDirectory = $rootDirectory . '/../' . $XODDirectory;

        parent::__construct();
    }

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('pdf_tron:convert_pdf')
            ->addArgument('pdf_name', InputArgument::OPTIONAL)
            ->setDescription('Convert the input file to XOD format')
            ->setHelp('The command converts an input PDF file into the XOD format.')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new SymfonyStyle($input, $output);
        // Foreach file get the file name and XOD file path.
        $files = $this->getPDFFilesArray($input);

        foreach ($files as $PDFFile => $XODFile) {
            // Get the time taken to convert.
            $time_start = microtime(true);
            $this->PDFTron->convertPDFToXOD($PDFFile, $XODFile);
            $time_end = microtime(true);

            // Conversion time
            $conversionTime = $time_end - $time_start;
            $conversionTime = round($conversionTime, 3) . 's';

            // File sizes
            $originalSize = $this->fileSize($PDFFile);
            $convertedSize = $this->fileSize($XODFile);
            $fileSizes = $this->formatBytes($originalSize) . '/' . $this->formatBytes($convertedSize);

            // Output the results.
            $style->text($PDFFile . ' converted to ' . $XODFile . '.xod. Filesizes: ' . $fileSizes . ' in ' . $conversionTime);
        }

        $style->text($this->PDFDirectory);
    }

    /**
     * @param $filename
     * @return int
     */
    private function fileSize($filename) {
        $bytes = filesize($filename);
        return $bytes;
    }

    /**
     * @param $size
     * @param int $precision
     * @return string
     */
    function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('', 'K', 'M', 'G', 'T');

        return round(pow(1024, $base - floor($base)), $precision) . '' . $suffixes[floor($base)];
    }

    /**
     * @param InputInterface $input
     * @return array
     */
    function getPDFFilesArray(InputInterface $input)
    {
        $files = [];
        $filesMappings = [];
        $filename = $input->getArgument('pdf_name');
        if (!empty($filename)) {
            if (!file_exists($filename)) {
                $filename = $this->getPDFDirectory() . $filename;
            }

            if (file_exists($filename)) {
                $files[] = $filename;
            }
        }
        else {
            $PDFDirectory = $this->getPDFDirectory();
            $files = array_diff(scandir($PDFDirectory), array('.', '..'));
        }

        // Out non-pdf files and generate the
        foreach ($files as $key => $path) {
            $fileInfo = pathinfo($path);
            if (!empty($fileInfo['extension'] && strtolower($fileInfo['extension']) == 'pdf')) {
                $filesMappings[$path] = $this->getXODPath($fileInfo['filename']);
            }
        }

        return $filesMappings;
    }

    /**
     * @return mixed
     */
    public function getPDFDirectory()
    {
        return $this->PDFDirectory;
    }

    /**
     * @return mixed
     */
    public function getXODDirectory()
    {
        return $this->XODDirectory;
    }

    /**
     * @param $path
     * @return string
     */
    public function getXODPath($path)
    {
        return $this->getXODDirectory() . $path . '.xod';
    }
}