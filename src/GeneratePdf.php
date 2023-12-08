<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap;

use setasign\Fpdi\Fpdi;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\View;
use setasign\Fpdi\PdfParser\StreamReader;
use setasign\Fpdi\PdfReader\PageBoundaries;

final class GeneratePdf
{
    public static function view(string $view): Browsershot
    {
        $html = View::make($view)->render();

        return Browsershot::html($html)
            ->setNodeBinary(DonationRecap::getNodeBinaryPath())
            ->setNpmBinary(DonationRecap::getNpmBinaryPath())
            ->format(DonationRecap::getPaperSizeFormat());
    }

    public static function combine(array $contents): string
    {
        $pdf = new Fpdi();

        collect($contents)->filter(fn (mixed $content) => is_resource($content))->each(function (mixed $content) use ($pdf): void {
            $pageCount = $pdf->setSourceFile(new StreamReader($content));

            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $pageId = $pdf->importPage($pageNo, PageBoundaries::MEDIA_BOX);

                $size = $pdf->getTemplatesize($pageId);

                $pdf->AddPage($size['orientation'], $size);

                $pdf->useImportedPage($pageId);
            }
        });

        return $pdf->Output('S');
    }
}
