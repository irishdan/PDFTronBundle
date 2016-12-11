<?php

namespace PDFTronBundle\Command;


use PDFTronBundle\Services\PDFFileSystem;
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
    private $PDFFileSystem;

    /**
     * ConvertPDFCommand constructor.
     * @param PDFTron $PDFTron
     * @param PDFFileSystem $PDFFileSystem
     */
    public function __construct(PDFTron $PDFTron, PDFFileSystem $PDFFileSystem)
    {
        $this->PDFTron = $PDFTron;
        $this->PDFFileSystem = $PDFFileSystem;

        parent::__construct();
    }

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('pdf_tron:pdf_to_xod')
            ->addArgument('pdf_name', InputArgument::OPTIONAL)
            ->setDescription('Convert a PDF file to XOD format')
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
            $this->PDFTron->convertPDFToXOD($PDFFile, $XODFile);

            // File sizes before and after.
            $originalSize = $this->PDFFileSystem->fileSize($PDFFile);
            $convertedSize = $this->PDFFileSystem->fileSize($XODFile);

            // Output the results.
            $style->text($PDFFile . ' converted to ' . $XODFile . ', ' . $originalSize . '/' . $convertedSize);
        }
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