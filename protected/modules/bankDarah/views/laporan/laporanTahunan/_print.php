<style> 
    #headerlaporan {
        width: 122% !important; 
    }
    @page {
        size: 7in 9.25in;
        font-family: Arial, sans-serif;
        font-size: 8pt !important;
        padding-top: 30px;
        margin-top: 0px;
        margin-bottom: 0px;
        margin-left: 2cm;
        margin-right: 2cm;

    }
    @media print {
        html, body {
            padding-top: 30px;
            padding-left: 10px;
            width: 297mm;
            height: 210mm;
            line-height: 1.6;
            font-size: 8pt !important;
        }
        div.footer {
            position: fixed;
            bottom: 0;
        }

        .headernya{
            font-size: 10pt !important;
        }
    }
    .headernya{
        font-size: 10pt !important;
    }
    table.footer {
        position: fixed;
        bottom: 0;
    }
    @media all {
        .page-break { display: none; }
    }

    @media print {
        .page-break { display: block; page-break-before: always; }
    }
</style>
<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
if ($caraPrint == 'PRINT') {
    echo $this->renderPartial($this->path_view . '_table_print', array());
} else {
    echo $this->renderPartial($this->path_view . '_table_printpdf', array('caraPrint' => $caraPrint));
}
?>
