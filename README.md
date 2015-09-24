MassivePdfBundle
================

## Installation

Install the Bundle over composer.

``` json
composer require massive/pdf-bundle
```

Add Bundle to your symfony Kernel.

``` php
new Massive\Bundle\PdfBundle\MassivePdfBundle(),
```

## Usage
========

``` php
/** @var \Massive\Bundle\PdfBundle\Pdf\PdfManager $pdfManager */
$pdfManager = $this->get('massive_pdf.pdf_manager'); // get the service or inject it in your services configuration
$pdf = $pdfManager->convertToPdf($templatePath, $templateData);
```
