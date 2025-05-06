<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Massive\Bundle\PdfBundle\Twig;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class LocalAssetTwigExtension extends AbstractExtension
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var string
     */
    private $publicDirectory;

    /**
     * LocalAssetTwigExtension constructor.
     *
     * @param string $publicDirectory
     */
    public function __construct(
        RequestStack $requestStack,
        $publicDirectory
    ) {
        $this->requestStack = $requestStack;
        $this->publicDirectory = rtrim($publicDirectory, '/') . '/';
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('local_asset', [$this, 'getLocalAsset']),
        ];
    }

    public function getFilters()
    {
        return [
            new TwigFilter('local_asset', [$this, 'getLocalAsset']),
        ];
    }

    /**
     * Get local asset path.
     *
     * @param string $assetUrl
     * @param bool $force
     *
     * @return string
     */
    public function getLocalAsset($assetUrl, $force = false)
    {
        $assetUrl = '/' . ltrim($assetUrl, '/');
        $filePath = $this->publicDirectory . $assetUrl;
        $prefix = 'file://' . $this->publicDirectory;

        if ($force && file_exists($filePath)) {
            return $prefix . $assetUrl;
        }

        $request = $this->requestStack->getCurrentRequest();

        if ($request && ('html' === $request->getRequestFormat() || !file_exists($filePath))) {
            $prefix = $request->getSchemeAndHttpHost();
        }

        return $prefix . $assetUrl;
    }
}
