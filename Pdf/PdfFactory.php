<?php

namespace Massive\Bundle\PdfBundle\Pdf;

use Knp\Snappy\GeneratorInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Templating\EngineInterface;

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
     * @var EngineInterface
     */
    private $templating;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * PdfFactory constructor.
     *
     * @param EngineInterface $templating
     * @param GeneratorInterface $generator
     */
    public function __construct(
        EngineInterface $templating,
        GeneratorInterface $generator,
        RequestStack $requestStack
    ) {
        $this->generator = $generator;
        $this->templating = $templating;
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
    protected function generateHtml($template, $parameters = [])
    {
        return $this->templating->render(
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
