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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Tests\Controller\ContainerAwareController;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\HttpFoundation\Response;

trait RenderPdfTrait
{
    /**
     * @var PdfFactory
     */
    protected $pdfFactory;

    protected function getPdfFactory()
    {
        if (!$this->pdfFactory) {
            if (!$this instanceof Controller) {
                throw new \RuntimeException('The pdfFactory service need to be set to be used.');
            }

            $this->pdfFactory = $this->get('massive_pdf.pdf_factory');
        }

        return $this->pdfFactory;
    }

    protected function renderPdf($template, $parameters = [], $requestFormat = 'pdf', Response $response = null)
    {
        if (!$response) {
            $response = new Response();
        }

        $parameters['request_format'] = $requestFormat;

        if ('pdf' === $requestFormat) {
            $content = $this->pdfFactory->create($template, $parameters);
            $response->headers->set('Content-Type', 'application/pdf');
        } else {
            $content = $this->pdfFactory->generateHtml($template, $parameters);
        }

        $response->setContent($content);

        return $response;
    }
}
