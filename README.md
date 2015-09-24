MassivePdfBundle
================

Build on `KnpSnappyBundle`: https://github.com/KnpLabs/KnpSnappyBundle

## Installation

**Install the Bundle over composer.**

``` json
composer require massive/pdf-bundle
```

**Add Bundle to your symfony Kernel.**

``` php
new Knp\Bundle\SnappyBundle\KnpSnappyBundle(),
new Massive\Bundle\PdfBundle\MassivePdfBundle(),
```

**Install wkhtmltopdf**

Ubuntu: 

``` 
apt-get install wkhtmltopdf
apt-get install xvfb
echo ‘xvfb-run –server-args=”-screen 0, 1024x768x24″ /usr/bin/wkhtmltopdf $*’ > /usr/bin/wkhtmltopdf.sh
chmod a+x /usr/bin/wkhtmltopdf.sh
ln -s /usr/bin/wkhtmltopdf.sh /usr/local/bin/wkhtmltopdf
wkhtmltopdf http://www.google.com output.pdf
```

MacOSX

http://wkhtmltopdf.org/downloads.html

**Configure Knp Snappy Bundle**

``` yml
knp_snappy:
    pdf:
        enabled:    true
        binary:     /usr/local/bin/wkhtmltopdf
        options:    []
```

## Usage
========

``` php
/** @var \Massive\Bundle\PdfBundle\Pdf\PdfManager $pdfManager */
$pdfManager = $this->get('massive_pdf.pdf_manager'); // get the service or inject it in your services configuration
$pdf = $pdfManager->convertToPdf($templatePath, $templateData);
```
