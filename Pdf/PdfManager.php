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

class PdfManager
{
    /**
     * @var EngineInterface
     */
    private $templating;

    public function __construct(
        EngineInterface $templating
    )
    {
        $this->templating = $templating;
    }


    public function convertToPdf($tmpl, $data, $save)
    {
        // returns a file pointer
        return $this->renderTemplate($tmpl, $data);
    }

    public function renderTemplate($tmpl, $data)
    {
        // should return a rendered template
        return $this->templating->render($tmpl, $data);
    }
}