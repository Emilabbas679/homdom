<?php

require 'tfpdf.php';

class AIN_Pdf_PdfInvoice extends AIN_Pdf_tFPDF
{
    public function Header()
    {
        $this->SetFont('Roboto Regular', '', 8);
        $this->Image(AIN_DIR_INCLUDE.'library/ain/pdf/smartbee.png', 10, 10, 35, 11);
        $this->Cell(190, 10, 'Date : '. date('d.m.Y'), 0, 0, 'R');
        $this->Ln(20);
    }

    public function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Roboto Regular', '', 8);
        // Page number
        $this->Cell(0, 10, 'Adres: Əhməd Cavad 15, City Centre ticarət mərkəzi, 3-cü mərtəbə / info@smartbee.az / +994702011514', 0, 0, 'L');
    }

    public function FirmTable($header=null, $data)
    {
        $this->SetFont('Roboto Bold', 'B', 10);
        if ($header) :
            foreach ($header as $col) {
                $this->Cell(40, 7, $col, 1);
            }
        $this->Ln();
        endif;
        // Data
        foreach ($data as $row) {
            foreach ($row as $col) {
                $this->MultiCell(60, 4, $col, 0);
            }
            $this->Ln();
        }
    }



    // Colored table
    public function InvoiceTable($header, $data)
    {
        // Colors, line width and bold font
        $this->SetFillColor(245, 129, 22);
        $this->SetTextColor(0);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0);
        $this->SetFont('Roboto Bold', 'B', 10);
        // Header
        $w = array(120, 20, 20, 30);
        for ($i=0;$i<count($header);$i++) {
            $this->Cell($w[$i], 7, $header[$i], 0, 0, 'C', true);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetLineWidth(0);
        $this->SetFont('Roboto Regular', '', 9);
        // Data
        $fill = false;
        $pul = 0;
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row[0], 0, 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 0, 0, 'C', $fill);
            $this->Cell($w[2], 6, number_format($row[2]), 0, 0, 'R', $fill);
            $this->Cell($w[3], 6, number_format($row[3]), 0, 0, 'R', $fill);
            $this->Ln();
            $pul +=$row[3];
            $fill = !$fill;
        }
        // Closing line
        $this->Ln(10);
        $this->SetFont('Roboto Bold', 'B', 10);
        $this->Cell(160, 6, 'Toplam', 0, 0, 'R');
        $this->SetFont('Roboto Regular', '', 9);
        $this->Cell(30, 6, number_format($pul), 0, 0, 'R');
        $this->Cell(array_sum($w), 0, '', 0);
    }
}
