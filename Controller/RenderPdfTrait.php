<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Massive\Bundle\PdfBundle\Controller;

use Massive\Bundle\PdfBundle\Pdf\PdfFactory;
use Symfony\Component\HttpFoundation\Response;

trait RenderPdfTrait
{
    protected function renderPdf($template, $parameters = [], $requestFormat = 'pdf', Response $response = null)
    {
        /** @var PdfFactory $pdfFactory */
        $pdfFactory = $this->get('massive_pdf.pdf_factory');

        if (!$response) {
            $response = new Response();
        }

        if ('pdf' === $requestFormat) {
            $content = $pdfFactory->create($template, array_merge($parameters, ['request_format' => 'pdf']));
            $response->headers->set('Content-Type', 'application/pdf');
        } else {
            $content = $this->renderView($template, array_merge($parameters, ['request_format' => 'html']));
        }

        $response->setContent($content);

        return $response;
    }
}
