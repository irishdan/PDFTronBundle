<?php
/**
 * This file is part of the IrishDan\PDFTronBundle package.
 *
 * (c) Daniel Byrne <danielbyrne@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source
 * code.
 */

namespace IrishDan\PDFTronBundle\Command;

use IrishDan\PDFTronBundle\Services\PDFCropper;
use IrishDan\PDFTronBundle\Services\PDFFileSystem;
use IrishDan\PDFTronBundle\Services\PDFToXODConverter;
use IrishDan\PDFTronBundle\Services\PDFTron;
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
        // @TODO: Get input filename.
        $files = $this->getPDFFilesArray(null);

        foreach ($files as $inputPath) {
            // @TODO: Allow for keeping original.
            // $destination = '/var/www/pdftron/pdf/cropped/170105.pdf';
            $style->text('Cropping ' . $inputPath);


            $this->PDFCropper->crop($inputPath, $inputPath);
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