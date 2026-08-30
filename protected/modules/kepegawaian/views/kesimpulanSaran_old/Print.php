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
            <td>Tanggal Pembuatan Kesimpulan dan Saran</td>
            <td>:</td>
            <td><?php echo isset($modKesimpulan->tglkesimpulan) ? MyFormatter::formatDateTimeForUser($modKesimpulan->tglkesimpulan) : ""; ?></td>
        </tr>
        <tr>
            <td>Pegawai Pembuat kesimpulan dan Saran</td>
            <td>:</td>
            <td><?php echo (isset($modKesimpulan->pegawai_pemberisaran) ? $modKesimpulan->pegawai_pemberisaran: ""); ?></td>
        </tr>
        <tr>
            <td>Total Penilaian</td>
            <td>:</td>
            <td><?php echo (isset($modKesimpulan->totalpenilaian) ? $modKesimpulan->totalpenilaian : ""); ?></td>
        </tr>
		<tr>
            <td>Rata rata Penilaian</td>
            <td>:</td>
            <td><?php echo (isset($modKesimpulan->ratapenilaian) ? $modKesimpulan->ratapenilaian : ""); ?></td>
        </tr>		
        <tr>
            <td>Kesimpulan</td>
            <td>:</td>
            <td><?php echo $modKesimpulan->kesimpulan; ?></td>
        </tr>
		<tr>
            <td>Saran</td>
            <td>:</td>
            <td><?php echo $modKesimpulan->saran; ?></td>
        </tr>		
    </table><br>
    <table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
        <thead>
            <tr>
				<th>No.</th>
				<th>NIP</th>
				<th>Nama Pegawai</th>
				<th>Keterangan Penilaian</th>
				<th>Jumlah Penilaian</th>				
			</tr>
        </thead>
        <tbody>
            <?php
            if(count((array)$modKesimpulanDetail) > 0){
                foreach($modKesimpulanDetail AS $i=>$modDetail){ ?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo (!empty($modDetail->penilainip) ? $modDetail->penilainip : ""); ?></td>
                <td><?php echo (!empty($modDetail->penilainama) ? $modDetail->penilainama : ""); ?></td>
                <td><?php echo (!empty($modDetail->penilaianpegawai_keterangan) ? $modDetail->penilaianpegawai_keterangan : ""); ?></td>
                <td><?php echo (!empty($modDetail->jumlahpenilaian) ? $modDetail->jumlahpenilaian : ""); ?></td>                
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
            <?php echo Yii::app()->user->getState('kabupaten_nama'); ?>, <?php echo $format->formatDateTimeForUser(date('Y-m-d')); ?><br>
            Pegawai Menyetujui,
            <div style="margin-top:50px;"></div><?php echo Yii::app()->user->getState('nama_pegawai'); ?>
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
        kesimpulanpenilaian_id = '<?php echo isset($modKesimpulan->kesimpulanpenilaian_id) ? $modKesimpulan->kesimpulanpenilaian_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&kesimpulanpenilaian_id='+kesimpulanpenilaian_id+'&caraprint='+caraprint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}?>