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
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judul_print, 'colspan'=>''));      

?>
<fieldset>
    <table width="74%" style="margin:0px;" cellpadding="0" cellspacing="0">
        <tr>
            <td>Tgl. Intra Anestesi</td>
            <td>:</td>
            <td><?php echo isset($modIntraAnestesi->tglintraanestesi) ? MyFormatter::formatDateTimeForUser($modIntraAnestesi->tglintraanestesi) : ""; ?></td>
        </tr>
        <tr>
            <td>No. Intra Anestesi</td>
            <td>:</td>
            <td><?php echo isset($modIntraAnestesi->nointraanestesi) ? $modIntraAnestesi->nointraanestesi : ""; ?></td>
        </tr>
        <tr>
            <td>Tgl. Pra Anestesi</td>
            <td>:</td>
            <td><?php echo isset($modPraAnestesi->tglpraanestesi) ? MyFormatter::formatDateTimeForUser($modPraAnestesi->tglpraanestesi) : ""; ?></td>
        </tr>
        <tr>
            <td>No. Pra Anestesi</td>
            <td>:</td>
            <td><?php echo isset($modPraAnestesi->nopraanestesi) ? $modPraAnestesi->nopraanestesi : ""; ?></td>
        </tr>
    </table><br/>
	<div class="block-tabel">
        <h6>Tabel Daftar Tindakan <b>Anestesi</b></h6>
		<table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
			<thead>
				<tr>
					<th>No.</th>
					<th>Nama Daftar Tindakan</th>
					<th>Jenis Anestesi</th>
					<th>Anestesi</th>
					<th>Jumlah</th>
					<th>Tarif Tindkaan</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(count($modTindakanAnestesi) > 0){
					foreach($modTindakanAnestesi AS $i=>$tindakan){ ?>
				<tr>
					<td><?php echo $i+1; ?></td>
					<td><?php echo (!empty($tindakan->daftartindakan_id) ? $tindakan->daftartindakan->daftartindakan_nama : ""); ?></td>
					<td><?php echo (!empty($tindakan->anastesi_id) ? $tindakan->anastesi->jenisanastesi->jenisanastesi_nama : ""); ?></td>
					<td><?php echo (!empty($tindakan->anastesi_id) ? $tindakan->anastesi->anastesi_nama : ""); ?></td>
					<td style="text-align: center;"><?php echo (!empty($tindakan->qty_tindakan) ? number_format($tindakan->qty_tindakan) : "0"); ?></td>
					<td style="text-align: right;"><?php echo (!empty($tindakan->tarif_tindakan) ?  number_format($tindakan->tarif_tindakan) : "0"); ?></td>
				</tr>
				<?php    }
				}
				?>
			</tbody>
		</table>
	</div>
	<div class="block-tabel">
        <h6>Tabel Daftar Obat Alkes <b>Anastesi</b></h6>
		<table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
			<thead>
				<tr>
					<th>No.</th>
					<th>Nama Obat Alkes</th>
					<th>Jumlah</th>
					<th>Tarif Tindkaan</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(count($modObatAlkesAnestesi) > 0){
					foreach($modObatAlkesAnestesi AS $i=>$obat){ ?>
				<tr>
					<td><?php echo $i+1; ?></td>
					<td><?php echo (!empty($obat->obatalkespasien_id) ? $obat->obatalkespasien->obatalkes->obatalkes_nama : ""); ?></td>
					<td style="text-align: center;"><?php echo (!empty($obat->qty_oa) ? number_format($obat->qty_oa) : "0"); ?></td>
					<td style="text-align: right;"><?php echo (!empty($obat->hargasatuan_oa) ?  number_format($obat->hargasatuan_oa) : "0"); ?></td>
				</tr>
				<?php    }
				}
				?>
			</tbody>
		</table>
	</div>
</fieldset>
<table width="80%" style="margin-top:20px;">
    <tr>
        <td width="50%" align="center">
			Pegawai Menyetujui,
            <div style="margin-top:50px;"></div><?php echo (isset($modPasienAnestesi->dokteranastesi->NamaLengkap) ? $modPasienAnestesi->dokteranastesi->NamaLengkap : Yii::app()->user->getState('nama_pegawai')); ?>
		</td>
        <td width="50%" align="center">
            <?php echo Yii::app()->user->getState('kabupaten_nama'); ?>, <?php echo $format->formatDateTimeForUser(date('Y-m-d')); ?><br>
            Pegawai Mengetahui,
            <div style="margin-top:50px;"></div><?php echo (isset($modPasienAnestesi->perawatanastesi->NamaLengkap) ? $modPasienAnestesi->perawatanastesi->NamaLengkap : ""); ?>
        </td>
    </tr>
</table>
<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(caraprint){
        pasienanastesi_id = '<?php echo isset($modPasienAnestesi->pasienanastesi_id) ? $modPasienAnestesi->pasienanastesi_id : ''; ?>';
        window.open('<?php echo $this->createUrl('printHasil'); ?>&pasienanastesi_id='+pasienanastesi_id+'&caraprint='+caraprint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}?>