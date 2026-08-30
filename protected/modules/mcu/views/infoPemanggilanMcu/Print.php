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
if(!$modDetail){
    echo "Data tidak ditemukan."; exit;
}
//echo $this->renderPartial('application.views.headerReport.headerRincian');
//$format = new MyFormatter;
//$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judul_print, 'deskripsi'=>$deskripsi, 'colspan'=>25));
?>
	
<body class="kertas">
	<br><br>
	<table class='table'>
	<?php foreach($modHeader AS $header): ?>
    <tr>
        <td>
            <b><?php echo CHtml::encode($header->getAttributeLabel('no_rekam_medik')); ?>:</b>
            <?php echo CHtml::encode($header->no_rekam_medik); ?>
            <br>
            <b><?php echo CHtml::encode($header->getAttributeLabel('nama_pasien')); ?>:</b>
            <?php echo CHtml::encode($header->nama_pasien); ?>
             <br>
        </td>
        <td>
            <b><?php echo CHtml::encode($header->getAttributeLabel('nopeserta')); ?>:</b>
            <?php echo CHtml::encode($header->nopeserta); ?>
            <br>
            <b><?php echo CHtml::encode($header->getAttributeLabel('status_hubungan')); ?>:</b>
            <?php echo CHtml::encode($header->status_hubungan); ?>
            <br>
        </td>
    </tr>   
	<?php endforeach; ?>
	</table>
	
    <table id="tableObatAlkes" class="table table-striped table-bordered table-condensed">
    <thead>
        <th>No </th>
        <th>Tanggal Rencana MCU</th>
        <th>Tanggal Pemanggilan MCU</th>
        <th>Tanggal Akan Diperiksa</th>
        <th>Pemanggilan Ke-</th>
    </thead>
    <tbody>
    <?php
        $no=1;
        foreach($modDetail AS $detail): ?>
            <tr>   
                <td><?php echo $no; ?></td>
                <td><?php echo $detail->tglrenkontrol; ?></td>
                <td><?php echo $detail->tglpemanggilanmcu; ?></td>
                <td><?php echo $detail->tglakanperiksamcu; ?></td>
                <td><?php echo $detail->pemanggilanke; ?></td>
            </tr>
    <?php 
        $no++; 
        endforeach;     
    ?>
    </tbody>
</table>
<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(caraPrint){
        pendaftaran_id = '<?php echo isset($modDetail->pendaftaran_id) ? $modDetail->pendaftaran_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&pendaftaran_id='+pendaftaran_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}else{ ?>
    <table width="100%" style="margin-top:20px;">
    <tr>
        <td width="100%" align="left" align="top">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="35%" align="center">
                        <div>Mengetahui<br></div>
                        <div style="margin-top:60px;"><?php echo Yii::app()->user->getState('nama_pegawai'); ?></div>
                    </td>
                    <td width="35%" align="center">
                    </td>
                    <td width="35%" align="center">
                        <div>Dibuat Oleh :</div>
                        <div style="margin-top:60px;"><?php echo Yii::app()->user->getState('nama_pegawai'); ?></div>
                        <div></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
</body>
<?php } ?>
