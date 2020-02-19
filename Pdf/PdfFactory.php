<?php

namespace Massive\Bundle\PdfBundle\Pdf;

use Knp\Snappy\GeneratorInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;

/**
 * The pdf factory will create pdfs.
 */
class PdfFactory
{
    /**
     * @var GeneratorInterface
     */
    private $generator;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(
        Environment $twig,
        GeneratorInterface $generator,
        RequestStack $requestStack
    ) {
        $this->generator = $generator;
        $this->twig = $twig;
        $this->requestStack = $requestStack;
    }

    /**
     * Generate a pdf.
     *
     * @param string $template
     * @param array $parameters
     * @param array $options
     *
     * @return string
     */
    public function create($template, $parameters = [], $options = [])
    {
        return $this->generator->getOutputFromHtml(
            $this->generateHtml($template, $parameters),
            array_merge(
                $this->getDefaultOptions(),
                $this->getCustomHeaderParameters(),
                $options
            )
        );
    }

    /**
     * Generate html.
     *
     * @param string $template
     * @param array $parameters
     *
     * @return string
     */
    public function generateHtml($template, $parameters = [])
    {
        return $this->twig->render(
            $template,
            $parameters
        );
    }

    /**
     * Get default options.
     *
     * @return array
     */
    private function getDefaultOptions()
    {
        return [
            'encoding' => 'UTF-8',
            'margin-right' => '13mm',
            'margin-left' => '13mm',

            // header
            'margin-top' => '13mm',
            'header-font-size' => 8,
            'header-spacing' => 4,

            // footer
            'margin-bottom' => '13mm',
            'footer-font-size' => 8,
            'footer-spacing' => 4,
        ];
    }

    /**
     * Get Custom Headers parameter.
     *
     * @return array
     */
    private function getCustomHeaderParameters()
    {
        $authorizationHeader = $this->requestStack->getCurrentRequest()->headers->get('Authorization');

        if (!$authorizationHeader) {
            return [];
        }

        return [
            'custom-header' => [
                'Authorization' => $authorizationHeader,
            ],
            'custom-header-propagation' => true,
        ];
    }
}
