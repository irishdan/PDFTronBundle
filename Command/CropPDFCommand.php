<?php

namespace PDFTronBundle\Command;

use PDFTronBundle\Services\PDFCropper;
use PDFTronBundle\Services\PDFFileSystem;
use PDFTronBundle\Services\PDFToXODConverter;
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
class CropPDFCommand extends ContainerAwareCommand
{
    /**
     * @var PDFTron
     */
    private $PDFCropper;

    /**
     * @var
     */
    private $PDFFileSystem;

    /**
     * ConvertPDFCommand constructor.
     * @param PDFCropper $PDFCropper
     * @param PDFFileSystem $PDFFileSystem
     */
    public function __construct(PDFCropper $PDFCropper, PDFFileSystem $PDFFileSystem)
    {
        $this->PDFCropper =$PDFCropper;
        $this->PDFFileSystem = $PDFFileSystem;

        parent::__construct();
    }

    /**
     * Define the command.
     */
    protected function configure()
    {
        $this
            ->setName('pdf_tron:crop')
            ->addArgument('pdf_name', InputArgument::OPTIONAL)
            ->setDescription('Crop all pages in a PDF file')
            ->setHelp('The command converts an input PDF file into the XOD format.')
        ;
    }

    /**
     * Execute the command
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new SymfonyStyle($input, $output);
        // Foreach file get the file name and XOD file path.
        // $files = $this->getPDFFilesArray('170105.pdf');
        $file = '/var/www/pdftron/pdf/170105.pdf';
        $destination = '/var/www/pdftron/pdf/cropped/170105.pdf';
        var_dump($file);

        $this->PDFCropper->crop($file, $destination);

        // foreach ($files as $PDFFile => $XODFile) {
        //     $this->PDFToXODConverter->convertPDFToXOD($PDFFile, $XODFile);
//
        //     // File sizes before and after.
        //     $originalSize = $this->PDFFileSystem->fileSize($PDFFile);
        //     $convertedSize = $this->PDFFileSystem->fileSize($XODFile);
//
        //     // Output the results.
        //     $style->text($PDFFile . ' cropped ' . $XODFile . ', ' . $originalSize . '/' . $convertedSize);
        // }
    }

    /**
     * @param InputInterface $input
     * @return array
     */
    function getPDFFilesArray(InputInterface $input)
    {
        $filename = $input->getArgument('pdf_name');

        return $this->PDFFileSystem->getPDFFilesArray($filename);
    }
}