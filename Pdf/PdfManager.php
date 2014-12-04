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

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Knp\Bundle\SnappyBundle\Snappy\LoggableGenerator as PdfGenerator;

class PdfManager
{
    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @var PdfGenerator
     */
    private $pdfGenerator;

    public function __construct(
        EngineInterface $templating,
        PdfGenerator $pdfGenerator
    ) {
        $this->templating = $templating;
        $this->pdfGenerator = $pdfGenerator;
    }


    public function convertToPdf($tmpl, $data, $save)
    {
        $filePath = sys_get_temp_dir() . uniqid() . '.pdf';
        $pdf = $this->pdfGenerator->getOutputFromHtml(
            $this->renderTemplate($tmpl, $data)
        );
        return $pdf;
    }

    public function renderTemplate($tmpl, $data)
    {
        // should return a rendered template
        return $this->templating->render($tmpl, $data);
    }
}
