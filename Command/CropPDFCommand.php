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
     *
     * @param PDFCropper $PDFCropper
     * @param PDFFileSystem $PDFFileSystem
     */
    public function __construct(PDFCropper $PDFCropper, PDFFileSystem $PDFFileSystem)
    {
        $this->PDFCropper = $PDFCropper;
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
            ->addArgument('input_pdf_name', InputArgument::REQUIRED)
            ->addArgument('output_pdf_name', InputArgument::REQUIRED)
            ->addArgument('margin', InputArgument::OPTIONAL)
            ->addArgument('x2', InputArgument::OPTIONAL)
            ->addArgument('y1', InputArgument::OPTIONAL)
            ->addArgument('y2', InputArgument::OPTIONAL)
            ->setDescription('Crop all pages in a PDF file')
            ->setHelp('The command converts an input PDF file into the XOD format.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new SymfonyStyle($input, $output);

        // the input and put files are required.
        $inputFilename = $input->getArgument('input_pdf_name');
        $outputFilename = $input->getArgument('output_pdf_name');

        // Foreach file system path.
        $inputFilePath = $this->PDFFileSystem->getPDFSystemPath($inputFilename);
        $outputFilePath = $this->PDFFileSystem->getPDFSystemPath($outputFilename);

        // Get the cropping margins
        $margin = empty($input->getArgument('margin')) ? 10 : $input->getArgument('margin');
        $x2 = empty($input->getArgument('x2')) ? null : $input->getArgument('x2');
        $y1 = empty($input->getArgument('y1')) ? null : $input->getArgument('y1');
        $y2 = empty($input->getArgument('y2')) ? null : $input->getArgument('y2');

        $style->text('Cropping ' . $inputFilename);

        try {
            $this->PDFCropper->crop($inputFilePath, $outputFilePath, $margin, $x2, $y1, $y2);

            $style->text('Cropped pdf saved at ' . $outputFilePath);
        } catch (\Exception $e) {
            $style->text('Unable to crop file ' . $inputFilename . ' to ' . $outputFilePath);
        }
    }
}