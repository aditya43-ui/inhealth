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
            <td>No. Dekontaminasi</td>
            <td>:</td>
            <td><?php echo $modDekontaminasi->dekontaminasi_no; ?></td>
        </tr>
        <tr>
            <td>Tanggal Dekontaminasi</td>
            <td>:</td>
            <td><?php echo isset($modDekontaminasi->dekontaminasi_tgl) ? MyFormatter::formatDateTimeForUser($modDekontaminasi->dekontaminasi_tgl) : ""; ?></td>
        </tr>
        <tr>
            <td>Pegawai Dekontaminasi</td>
            <td>:</td>
            <td><?php echo (isset($modDekontaminasi->pegpetugas->NamaLengkap) ? $modDekontaminasi->pegpetugas->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo $modDekontaminasi->dekontaminasi_ket; ?></td>
        </tr>
    </table><br>
    <table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
        <thead>
            <tr>
				<th>No.</th>
				<th>Tanggal Penerimaan/<br>No. Penerimaan Sterilisasi</th>
				<th>Ruangan Asal</th>
				<th>Nama Peralatan</th>
				<th>Jumlah</th>
				<th>Bahan yang digunakan</th>
				<th>Lama Dekontaminasi</th>
				<th>Status</th>
			</tr>
        </thead>
        <tbody>
            <?php
            if(count((array)$modDekontaminasiDetail) > 0){
                foreach($modDekontaminasiDetail AS $i=>$modDetail){ ?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo (!empty($modDetail->penerimaansterilisasi->penerimaansterilisasi_tgl) ? MyFormatter::formatDateTimeForUser($modDetail->penerimaansterilisasi->penerimaansterilisasi_tgl) : ""); ?>/<br>
					<?php echo (!empty($modDetail->penerimaansterilisasi->penerimaansterilisasi_no) ? $modDetail->penerimaansterilisasi->penerimaansterilisasi_no : ""); ?>
				</td>
                <td><?php echo (!empty($modDetail->ruangan_id) ? $modDetail->ruangan->ruangan_nama : ""); ?></td>
                <td><?php echo (!empty($modDetail->peralatansterilisasi_id) ? $modDetail->peralatansterilisasi->peralatansterilisasi_nama : ""); ?></td>
                <td><?php echo (!empty($modDetail->dekontaminasidetail_jml) ? $modDetail->dekontaminasidetail_jml : 0); ?></td>
                <td>
					<ol type="1">
					<?php 
						$modDekontaminasiBahan = STDekontaminasibahanT::model()->findAllByAttributes(array('dekontaminasidetail_id'=>$modDetail->dekontaminasidetail_id));
						foreach($modDekontaminasiBahan as $a=>$bahan){ ?>
						<li><?php echo $bahan->bahansterilisasi->bahansterilisasi_nama; ?></li>
					<?php } ?>
						</ol>
				</td>
                <td><?php echo $modDetail->dekontaminasidetail_lama; ?></td>
                <td><?php echo $modDetail->dekontaminasidetail_ket; ?></td>
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
            <div style="margin-top:50px;"></div><?php echo (isset($modDekontaminasi->pegpetugas->NamaLengkap) ? $modDekontaminasi->pegpetugas->NamaLengkap : ""); ?>
		</td>
        <td width="50%" align="center">
            <?php echo Yii::app()->user->getState('kabupaten_nama'); ?>, <?php echo $format->formatDateTimeForUser(date('Y-m-d')); ?><br>
            Pegawai Mengetahui,
            <div style="margin-top:50px;"></div><?php echo (isset($modDekontaminasi->pegmengetahui->NamaLengkap) ? $modDekontaminasi->pegmengetahui->NamaLengkap : Yii::app()->user->getState('nama_pegawai')); ?>
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
        dekontaminasi_id = '<?php echo isset($modDekontaminasi->dekontaminasi_id) ? $modDekontaminasi->dekontaminasi_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&dekontaminasi_id='+dekontaminasi_id+'&caraprint='+caraprint,'printwin','left=100,top=100,width=1000,height=640');
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