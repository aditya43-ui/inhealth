<?php
$titik = new CustomFunction;

$data['judul_laporan'] = '&nbsp;';
$data['alias'] = '&nbsp;';
$data['no_dok'] = '&nbsp;';

echo $this->renderPartial('application.views.headerReport._default_emr_pdf',['data'=>$data,'pemprov_logo'=>true,'identitas'=>false]); 

?>


    <table class='w100 prinout grid'>        
        <tr>
            <td align="center" width="50%">KONSULTAN NEFROLOGI</td>
            <td align="center" width="50%">KEPERAWATAN DAN TENAGA KESEHATAN LAIN</td>
        </tr>
        <tr style="height:68em" height="68em">
            <td height="68em">
                <span style="font-size:13px;height:100%">
                    Rencana dan tatalaksana medis/tindakan medik, pemberian cairan/nutrisi/elektrolit, diagnosa laboratorium dan radiologi lebih lanjut, edukasi, konsultasi dan observasi.<br/>
                    Ditulis dengan : <b>P</b>= Perencanaan, <b>I</b>= Instruksi
                </span>
            </td>
            <td>
                <span style="font-size:13px;">
                    Rencana dan tatalaksana keperawatan dan tenaga kesehatan lain,rencana edukasi dan observasi.<br/>
                    Ditulis dengan : <b>P</b>= Perencanaan, <b>I</b>= Intervensi - Implementasi
                </span>
            </td>
        </tr>        
    </table>
    <table class="prinout w100 no-grid">
        <tr>
            <td>Revisi : 17/01/17</td>
            <td align="right">Hal 2 dari 2</td>
        </tr>
    </table>
 <?php
    echo '<div style=" page-break-after:always;"></div>';
 ?>