<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{pager}{summary}\n{items}";
if (isset($caraprint)){
    $template = "{items}";
}
if($caraprint == 'EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');   
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judul_print, 'colspan'=>''));      

?>
<fieldset>
    <table width="74%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td>No. Penyimpanan</td>
            <td>:</td>
            <td><?php echo $modPenyimpananSterilisasi->penyimpanansteril_no; ?></td>
        </tr>
        <tr>
            <td>Tanggal Penyimpanan</td>
            <td>:</td>
            <td><?php echo isset($modPenyimpananSterilisasi->penyimpanansteril_tgl) ? MyFormatter::formatDateTimeForUser($modPenyimpananSterilisasi->penyimpanansteril_tgl) : ""; ?></td>
        </tr>
        <tr>
            <td>Pegawai Penyimpanan</td>
            <td>:</td>
            <td><?php echo (isset($modPenyimpananSterilisasi->pegpenyimpanan->NamaLengkap) ? $modPenyimpananSterilisasi->pegpenyimpanan->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Pegawai Mengetahui</td>
            <td>:</td>
            <td><?php echo (isset($modPenyimpananSterilisasi->pegmengetahui->NamaLengkap) ? $modPenyimpananSterilisasi->pegmengetahui->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo $modPenyimpananSterilisasi->penyimpanansteril_ket; ?></td>
        </tr>
    </table><br>
    <table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
        <thead>
            <tr>
				<th>No.</th>
				<th>Lokasi Penyimpanan</th>
				<th>Sub Rak</th>
				<th>No. Sterilisasi</th>
				<th>Instalasi</th>
				<th>Ruangan</th>
				<th>Nama Peralatan dan Linen</th>
			</tr>
        </thead>
        <tbody>
            <?php
            
            
            if(count((array)$modPenyimpananSterilisasiDetail) > 0){
                foreach($modPenyimpananSterilisasiDetail AS $i=>$modDetail){ ?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo (!empty($modDetail->lokasipenyimpanan->lokasipenyimpanan_id) ? $modDetail->lokasipenyimpanan->lokasipenyimpanan_nama : ""); ?></td>
                <td><?php echo (!empty($modDetail->rakpenyimpanan->rakpenyimpanan_id) ? $modDetail->rakpenyimpanan->rakpenyimpanan_nama : ""); ?></td>
                <td><?php echo (!empty($modDetail->sterilisasi_id) ? $modDetail->sterilisasi->sterilisasi_no : ""); ?></td>
                <td><?php echo (!empty($modDetail->sterilisasi->ruangan->instalasi_id) ? $modDetail->sterilisasi->ruangan->instalasi->instalasi_nama : ""); ?></td>
                <td><?php echo (!empty($modDetail->sterilisasi->ruangan->ruangan_id) ? $modDetail->sterilisasi->ruangan->ruangan_nama : ""); ?></td>
                <td><?php echo (!empty($modDetail->peralatansterilisasi_id) ? $modDetail->peralatansterilisasi->peralatansterilisasi_nama : 0); ?></td>                
            </tr>
            <?php    }
            }
            ?>
        </tbody>
    </table>	
</fieldset>
<table width="80%" style="margin-top:20px;">
    <tr>
        <td width="50%" align="center">
			Pegawai Menyetujui,
            <div style="margin-top:50px;"></div><?php echo (isset($modPenyimpananSterilisasi->pegpenyimpanan->NamaLengkap) ? $modPenyimpananSterilisasi->pegpenyimpanan->NamaLengkap : ""); ?>
		</td>
        <td width="50%" align="center">
            <?php echo Yii::app()->user->getState('kabupaten_nama'); ?>, <?php echo $format->formatDateTimeForUser(date('Y-m-d')); ?><br>
            Pegawai Mengetahui,
            <div style="margin-top:50px;"></div><?php echo (isset($modPenyimpananSterilisasi->pegmengetahui->NamaLengkap) ? $modPenyimpananSterilisasi->pegmengetahui->NamaLengkap : Yii::app()->user->getState('nama_pegawai')); ?>
        </td>
    </tr>
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
    function print(caraprint){
        penyimpanansteril_id = '<?php echo isset($modPenyimpananSterilisasi->penyimpanansteril_id) ? $modPenyimpananSterilisasi->penyimpanansteril_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&penyimpanansteril_id='+penyimpanansteril_id+'&caraprint='+caraprint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}?>
<br>
<div class="">
</div>
<div class="footer">
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    
</div>