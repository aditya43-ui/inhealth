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
    <table width="74%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td>No. Permohonan</td>
            <td>:</td>
            <td><?php echo $modPertukaranJadwal->no_permohonanpertukaran; ?></td>
			
			<td>Pegawai Mengajukan 1</td>
            <td>:</td>
            <td><?php echo (isset($modPertukaranJadwal->ygmengajukan1->NamaLengkap) ? $modPertukaranJadwal->ygmengajukan1->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Tanggal Permohonan</td>
            <td>:</td>
            <td><?php echo isset($modPertukaranJadwal->tglpermohonanpertukaran) ? MyFormatter::formatDateTimeForUser($modPertukaranJadwal->tglpermohonanpertukaran) : ""; ?></td>
			
			<td>Pegawai Mengajukan 2</td>
            <td>:</td>
            <td><?php echo (isset($modPertukaranJadwal->ygmengajukan2->NamaLengkap) ? $modPertukaranJadwal->ygmengajukan2->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Pegawai Menyetujui 1</td>
            <td>:</td>
            <td><?php echo (isset($modPertukaranJadwal->ygmenyetujui1->NamaLengkap) ? $modPertukaranJadwal->ygmenyetujui1->NamaLengkap : ""); ?></td>
			
			<td>Pegawai Menyetujui 2</td>
            <td>:</td>
            <td><?php echo (isset($modPertukaranJadwal->ygmenyetujui2->NamaLengkap) ? $modPertukaranJadwal->ygmenyetujui2->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Pegawai Mengetahui</td>
            <td>:</td>
            <td><?php echo (isset($modPertukaranJadwal->ygmengetahui->NamaLengkap) ? $modPertukaranJadwal->ygmengetahui->NamaLengkap : ""); ?></td>
			
			<td></td>
			<td></td>
			<td></td>
        </tr>
    </table><br>
	<table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
        <thead>
            <tr>
                <th>No.</th>
                <th>Tgl. Asal Jadwal</th>
                <th>Tgl. Pertukaran Jadwal</th>
                <th>Nama Pegawai</th>
                <th>Asal Shift</th>
                <th>Shift</th>
                <th>Ruangan</th>
                <th>Alasan Pertukaran</th>
                <th>Keterangan Pertukaran</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count((array)$modPertukaranJadwalDetail) > 0){
                foreach($modPertukaranJadwalDetail AS $i=>$modDetail){ 
				$modPenjadwalanDetail = KPPenjadwalandetailT::model()->findByAttributes(array('pertukaranjadwaldet_id'=>$modDetail->pertukaranjadwaldet_id));
			?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo (!empty($modPenjadwalanDetail->tgljadwalpegawai) ? MyFormatter::formatDateTimeForUser($modPenjadwalanDetail->tgljadwalpegawai) : ""); ?></td>
                <td><?php echo (!empty($modDetail->tglpertukaranjadwal) ? MyFormatter::formatDateTimeForUser($modDetail->tglpertukaranjadwal) : ""); ?></td>
                <td><?php echo (!empty($modDetail->pegawai->NamaLengkap) ? $modDetail->pegawai->NamaLengkap : ""); ?></td>
                <td><?php echo (!empty($modPenjadwalanDetail->shift->shift_kode) ? $modPenjadwalanDetail->shift->shift_kode : ""); ?></td>
                <td><?php echo (!empty($modDetail->shift->shift_kode) ? $modDetail->shift->shift_kode : ""); ?></td>
                <td><?php echo (!empty($modDetail->ruangan->ruangan_nama) ? $modDetail->ruangan->ruangan_nama : ""); ?></td>
                <td><?php echo (!empty($modDetail->alasanpertukaran) ? $modDetail->alasanpertukaran : ""); ?></td>
                <td><?php echo (!empty($modDetail->ketranganpertukaran) ? $modDetail->ketranganpertukaran : ""); ?></td>
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
            <div style="margin-top:50px;"></div><?php echo (isset($modPertukaranJadwal->ygmenyetujui1->NamaLengkap) ? $modPertukaranJadwal->ygmenyetujui1->NamaLengkap : ""); ?>
		</td>
        <td width="50%" align="center">
            <?php echo Yii::app()->user->getState('kabupaten_nama'); ?>, <?php echo $format->formatDateTimeForUser(date('Y-m-d')); ?><br>
            Pegawai Mengetahui,
            <div style="margin-top:50px;"></div><?php echo (isset($modPertukaranJadwal->ygmengetahui->NamaLengkap) ? $modPertukaranJadwal->ygmengetahui->NamaLengkap : ""); ?>
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
        pertukaranjadwal_id = '<?php echo isset($modPertukaranJadwal->pertukaranjadwal_id) ? $modPertukaranJadwal->pertukaranjadwal_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&pertukaranjadwal_id='+pertukaranjadwal_id+'&caraprint='+caraprint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}?>