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
if(!$modPenerimaanLinenRuanganDetail){
    echo "Data tidak ditemukan."; exit;
}
echo $this->renderPartial('application.views.headerReport.headerRincian');
$format = new MyFormatter;
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
?>
<body class="kertas">
    <table width="74%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td>Tanggal Penerimaan Linen</td>
            <td>:</td>
            <td><?php echo isset($modPenerimaanLinenRuangan->tglpenlinenruangan) ? $format->formatDateTimeId($modPenerimaanLinenRuangan->tglpenlinenruangan) : "-"; ?></td>
        </tr>
        <tr>
            <td>No. Penerimaan</td>
            <td>:</td>
            <td><?php echo isset($modPenerimaanLinenRuangan->nopenlinenruangan) ? $modPenerimaanLinenRuangan->nopenlinenruangan : "-"; ?></td>
        </tr>
        <tr>
            <td>Ruangan Asal</td>
            <td>:</td>
            <td><?php echo isset($modPenerimaanLinenRuangan->ruangan->ruangan_nama) ? $modPenerimaanLinenRuangan->ruangan->ruangan_nama : "-"; ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo isset($modPenerimaanLinenRuangan->keterangan_penlinenruangan) ? $modPenerimaanLinenRuangan->keterangan_penlinenruangan : "-"; ?></td>
        </tr>
    </table><br><br>
    <table width="100%" style='margin-left:auto; margin-right:auto;'>
        <thead class="border">
            <th>No. Registrasi</th>
            <th>Nama Linen</th>
            <th>Keterangan</th>
        </thead>
        <?php 
			foreach ($modPenerimaanLinenRuanganDetail as $i=>$modLinen){ 
        ?>
            <tr>
                <td><?php echo $modLinen->linen->noregisterlinen; ?></td>
                <td><?php echo $modLinen->linen->namalinen; ?></td>
                <td><?php echo $modLinen->keterangan; ?></td>
            </tr>
        <?php } ?>
    </table>
	<table width="100%" style="margin-top:20px;">
    <tr>
        <td width="100%" align="left" align="top">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="35%" align="center">
                        <div>Mengajukan<br></div>
                        <div style="margin-top:60px;"><?php echo $modPenerimaanLinenRuangan->pegpenerima->nama_pegawai; ?></div>
                    </td>
                    <td width="35%" align="center">
                    </td>
                    <td width="35%" align="center">
                        <div>Mengetahui</div>
                        <div style="margin-top:60px;"><?php echo $modPenerimaanLinenRuangan->pegmengetahui->nama_pegawai; ?></div>
                        <div></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
</body>
