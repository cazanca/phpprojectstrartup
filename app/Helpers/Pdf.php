<?php

namespace App\Helpers;

use Dompdf\Dompdf;

class Pdf
{
    private $pdf;

    public function __construct()
    {
        $this->pdf = new Dompdf();
    }

    public function load($file): Pdf
    {
        $this->pdf->loadHtml($file);
        return $this;
    }

    public function config(string $paper = "A4", string $orientation = "portrait"): Pdf
    {
        $this->pdf->setPaper($paper, $orientation);
        return $this;
    }

    protected function render(): Pdf
    {
        $this->pdf->render();
        return $this;
    }

    public function stream(string $filename, bool $download = false): void
    {
        $this->render();
        $this->pdf->stream($filename, ["Attachment" => $download]);
    }
}
