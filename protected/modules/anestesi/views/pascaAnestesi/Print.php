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
            <td><?php echo isset($modPascaAnestesi->intraanestesi->tglintraanestesi) ? MyFormatter::formatDateTimeForUser($modPascaAnestesi->intraanestesi->tglintraanestesi) : ""; ?></td>
        </tr>
        <tr>
            <td>No. Intra Anestesi</td>
            <td>:</td>
            <td><?php echo isset($modPascaAnestesi->intraanestesi->nointraanestesi) ? $modPascaAnestesi->intraanestesi->nointraanestesi : ""; ?></td>
        </tr>
        <tr>
            <td>Tgl. Pra Anestesi</td>
            <td>:</td>
            <td><?php echo isset($modPascaAnestesi->intraanestesi->praanestesi->tglpraanestesi) ? MyFormatter::formatDateTimeForUser($modPascaAnestesi->intraanestesi->praanestesi->tglpraanestesi) : ""; ?></td>
        </tr>
        <tr>
            <td>No. Pra Anestesi</td>
            <td>:</td>
            <td><?php echo isset($modPascaAnestesi->intraanestesi->praanestesi->nopraanestesi) ? $modPascaAnestesi->intraanestesi->praanestesi->nopraanestesi : ""; ?></td>
        </tr>
        <tr>
            <td>Tgl. Pasca Anestesi</td>
            <td>:</td>
            <td><?php echo isset($modPascaAnestesi->tglpascaanestesi) ? MyFormatter::formatDateTimeForUser($modPascaAnestesi->tglpascaanestesi) : ""; ?></td>
        </tr>
        <tr>
            <td>No. Pasca Anestesi</td>
            <td>:</td>
            <td><?php echo isset($modPascaAnestesi->nopascaanestesi) ? $modPascaAnestesi->nopascaanestesi : ""; ?></td>
        </tr>
    </table><br/>
	<div class="block-tabel">
        <h6>Tabel Daftar <b>Pemantauan Kondisi Pasien</b></h6>
			<table class="items table table-striped table-bordered table-condensed" id="table-pemantauan-kondisi-pasien">
			<thead>
				<tr>
					<th>No.</th>
					<th>Tanggal Pemantauan</th>
					<th>Jam Mulai</th>
					<th>Jam Selesai</th>
					<th>Menit Ke-</th>
					<th>Oksigen L/mnt</th>
					<th>Ventilasi mmHg</th>
					<th>Sirkulasi</th>
					<th>Suhu</th>
					<th>Perfusi Jaringan</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(count($modKondisiPasien) > 0){
					foreach($modKondisiPasien AS $i=>$kondisi){ ?>
				<tr>
					<td><?php echo $i+1; ?></td>
					<td><?php echo isset($kondisi->tglpemantauan) ? MyFormatter::formatDateTimeForUser($kondisi->tglpemantauan) : ""; ?></td>
					<td><?php echo isset($kondisi->jammulai) ? $kondisi->jammulai : ""; ?></td>
					<td><?php echo isset($kondisi->jamselesai) ? $kondisi->jamselesai : ""; ?></td>
					<td><?php echo isset($kondisi->menitke) ? $kondisi->menitke : ""; ?></td>
					<td><?php echo isset($kondisi->oksigen_liter) ? $kondisi->oksigen_liter : ""; ?></td>
					<td><?php echo isset($kondisi->ventilasi_mmhg) ? $kondisi->ventilasi_mmhg : ""; ?></td>
					<td><?php echo isset($kondisi->sirkulasi) ? $kondisi->sirkulasi : ""; ?></td>
					<td><?php echo isset($kondisi->suhu) ? $kondisi->suhu : ""; ?></td>
					<td><?php echo isset($kondisi->perfusijaringan) ? $kondisi->perfusijaringan : ""; ?></td>
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
            <div style="margin-top:50px;"></div><?php echo (isset($modPraAnestesi->dokter->NamaLengkap) ? $modPraAnestesi->dokter->NamaLengkap : Yii::app()->user->getState('nama_pegawai')); ?>
		</td>
        <td width="50%" align="center">
            <?php echo Yii::app()->user->getState('kabupaten_nama'); ?>, <?php echo $format->formatDateTimeForUser(date('Y-m-d')); ?><br>
            Pegawai Mengetahui,
            <div style="margin-top:50px;"></div><?php echo (isset($modPraAnestesi->perawat1->NamaLengkap) ? $modPraAnestesi->perawat1->NamaLengkap : ""); ?>
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
        pascaanestesi_id = '<?php echo isset($modPascaAnestesi->pascaanestesi_id) ? $modPascaAnestesi->pascaanestesi_id : ''; ?>';
        window.open('<?php echo $this->createUrl('printHasil'); ?>&pascaanestesi_id='+pascaanestesi_id+'&caraprint='+caraprint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}?>