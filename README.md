MassivePdfBundle
================

Built upon KnpSnappyBundle: https://github.com/KnpLabs/KnpSnappyBundle

## Installation

**Install the bundle with composer.**

``` json
composer require massive/pdf-bundle
```

**Add bundle to your symfony kernel.**

``` php
new Knp\Bundle\SnappyBundle\KnpSnappyBundle(),
new Massive\Bundle\PdfBundle\MassivePdfBundle(),
```

### Install wkhtmltopdf

**Ubuntu**

``` 
apt-get install wkhtmltopdf
apt-get install xvfb
echo ‘xvfb-run –server-args=”-screen 0, 1024x768x24″ /usr/bin/wkhtmltopdf $*’ > /usr/bin/wkhtmltopdf.sh
chmod a+x /usr/bin/wkhtmltopdf.sh
ln -s /usr/bin/wkhtmltopdf.sh /usr/local/bin/wkhtmltopdf
wkhtmltopdf http://www.google.com output.pdf
```

**MacOSX**

http://wkhtmltopdf.org/downloads.html

### Configure Knp Snappy Bundle**

See [KnpSnappyBundle](https://github.com/KnpLabs/KnpSnappyBundle#configuration) for configuration.

## Usage
========

**Controller Trait**

The controller trait is the easiest way to generate a pdf:

```php
<?php

namespace AppBundle\Controller;

use Massive\Bundle\PdfBundle\Controller\RenderPdfTrait;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class YourController extends Controller
{
    use RenderPdfTrait;

    public function pdfAction(Request $request): Response
    {
        return $this->renderPdf(
            '@pdfs/your.html.twig',
            [
                'parameter' => 'hello'
            ],
            $request->getRequestFormat()
        );
    }
}
```

Register the route with default `_format` as `pdf`:

```xml
    <route id="your.pdf" path="/your.{_format}">
        <default key="_controller">AppBundle:Your:pdf</default>
        <default key="_format">pdf</default>
    </route>
```

Now you can access the pdf with `/your` or use `/your.html` to get a html response (good for development).

**Generate Pdf**

```php
/** @var \Massive\Bundle\PdfBundle\Pdf\PdfFactory $pdfFactory */
$pdfFactory = $this->get('massive_pdf.pdf_factory'); // get the service or inject it in your services configuration
$pdf = $pdfFactory->create('pdf.html.twig');
```

**Embedding local assets**

The `local_asset` avoids doing a http request by using `file://` instead of `https://` for performance improvement:

```twig
<img src="{{ local_asset('/images/image.jpg') }}" alt="Local Asset">
```

This will only work when `$request->getRequestFormat()` will return `pdf`.
