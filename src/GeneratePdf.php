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
    private static ?Browsershot $browserShot = null;

    public static function useBrowserShot(Browsershot $browserShot): void
    {
        self::$browserShot = $browserShot;
    }

    protected static function browserShot(): Browsershot
    {
        return self::$browserShot ?? new Browsershot();
    }

    public static function view(string $view, array $data = [], array $mergeData = []): Browsershot
    {
        $html = View::make($view, $data, $mergeData)->render();

        $browserShot = self::browserShot()
            ->margins(.5, 0, 0, 0, 'cm')
            ->setHtml($html)
            ->format(DonationRecap::getPaperSizeFormat());

        if (DonationRecap::getNodeBinaryPath()) {
            $browserShot->setNodeBinary(DonationRecap::getNodeBinaryPath());
        }

        if (DonationRecap::getNpmBinaryPath()) {
            $browserShot->setNpmBinary(DonationRecap::getNpmBinaryPath());
        }

        return $browserShot;
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
