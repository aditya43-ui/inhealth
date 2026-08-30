<p style="margin: 0; text-align: center;">
<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
}
?>
<?php
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:50%;
        color:black;
        padding-right:10px;
        font-size:8pt;
    }
    body{
        font-size:8pt;
    }
    td .uang{
        text-align:right;
    }
    .border{
        border:1px solid;
    }
    .kertas{
     width:20cm;
     height:12cm;
    }
');
?>  
<?php
echo $this->renderPartial('application.views.headerReport.headerRincian');
$format = new MyFormatter;
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
?>
<body class="kertas">
    <table width="74%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td>Periode Rekening</td>
            <td>:</td>
            <td><?php echo isset($modCALK->rekperiod->deskripsi) ? $modCALK->rekperiod->deskripsi : "-"; ?></td>
        </tr>
        <tr>
            <td>No. Catatan</td>
            <td>:</td>
            <td><?php echo isset($modCALK->calk_no) ? $modCALK->calk_no : "-"; ?></td>
        </tr>
        <tr>
            <td>Tanggal Catatan</td>
            <td>:</td>
            <td><?php echo isset($modCALK->calk_tgl) ? $format->formatDateTimeId($modCALK->calk_tgl) : "-"; ?></td>
        </tr>
    </table><br><br>
    <table width="100%" style='margin-left:auto; margin-right:auto;'>
        <thead>
			<tr>
				<th><u>Catatan atas Laporan Keuangan</u></th>
			</tr>
        </thead>
		<tbody>
			<tr>
				<td><?php echo isset($modCALK->calk_catatan) ? $modCALK->calk_catatan : " "; ?></td>
			</tr>
		</tbody>
    </table>
</body>
