<?php
/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Massive\Bundle\PdfBundle\Pdf;

use Knp\Snappy\GeneratorInterface as PdfGenerator;
use Twig\Environment;

/**
 * @deprecated use PdfFactory instead
 */
class PdfManager
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var PdfGenerator
     */
    private $pdfGenerator;

    public function __construct(
        Environment $twig,
        PdfGenerator $pdfGenerator
    ) {
        $this->twig = $twig;
        $this->pdfGenerator = $pdfGenerator;
    }

    /**
     * This function can be called on a PdFManager instance in order to
     * get a new pdf by the given parameters.
     *
     * @param $tmpl string
     * @param $data []
     * @param $save boolean
     * @param array $options
     *
     * @return pdf binary
     */
    public function convertToPdf($tmpl, $data, $save, $options = [])
    {
        if ($save) {
            // ToDO the file needs to be saved
            //$filePath = sys_get_temp_dir() . uniqid() . '.pdf';
        }

        $pdf = $this->pdfGenerator->getOutputFromHtml(
            $this->renderTemplate($tmpl, $data),
            $options
        );

        return $pdf;
    }

    /**
     * Renders a given template and data and returns the rendered html.
     *
     * @param $template string
     * @param $data []
     *
     * @return string
     */
    public function renderTemplate($template, $data)
    {
        // should return a rendered template
        return $this->twig->render($template, $data);
    }
}
