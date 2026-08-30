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

?>
<table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNewest', array());
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
<style>

.table
{
    border: 1px solid #000;
    border-radius: 0 0px 0px 0px;
    box-shadow: 0 0px 0px 0px;
}
    
.table-striped tbody tr:nth-child(2n+1) td
{
    background-color: #fff;
}

.table th
{
    border-top: 1px solid #000;
    border-bottom: 1px solid #000;
    
}

.table-striped th + th, .table-striped td + td, .table-striped th + td, .table-striped td + th 
{
    border-left: 1px solid #000;
    
}
</style>

<fieldset>
    <table width="60%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td>No. Pemesanan</td>
            <td>:</td>
            <td><?php echo $model->nopemesanan; ?></td>
        </tr>
        <tr>
            <td>Tanggal Pemesanan</td>
            <td>:</td>
            <td><?php echo $format->formatDateTimeForUser(date('Y-m-d H:i:s', strtotime($model->tglpemesanan)));//$model->tglpemesanan; ?></td>
        </tr>
        <tr>
            <td>Tanggal Pesanan Minta Dikirim</td>
            <td>:</td>
            <td><?php echo $format->formatDateTimeForUser(date('Y-m-d H:i:s', strtotime($model->tglmintadikirim))); ?></td>
        </tr>
        <tr>
            <td>Ruang Pemesan</td>
            <td>:</td>
            <td><?php echo $model->ruanganpemesan->ruangan_nama; ?></td>
        </tr>
        <tr>
            <td>Ruang Tujuan</td>
            <td>:</td>
            <td><?php echo $model->ruangantujuan->ruangan_nama; ?></td>
        </tr>
<!--<tr>
            <td>Pegawai Mengetahui</td>
            <td>:</td>
            <td><?php // echo (isset($model->pegawaimengetahui->NamaLengkap) ? $model->pegawaimengetahui->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Pegawai Menyetujui</td>
            <td>:</td>
            <td><?php // echo (isset($model->pegawaipemesan->NamaLengkap) ? $model->pegawaipemesan->NamaLengkap : ""); ?></td>
        </tr>-->
        <tr>
            <td>Status Pesan</td>
            <td>:</td>
            <td><?php echo $model->statuspesan; ?></td>
        </tr>
        <tr>
            <td>Keterangan Pesan</td>
            <td>:</td>
            <td><?php echo $model->keterangan_pesan; ?></td>
        </tr>
    </table><br>
    <table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
        <thead>
            <tr>
                <th>No.</th>
                <th>Jenis</th>
                <th>Nama Obat</th>
               <!--<th>Satuan Kecil </th>-->
                <th>Tgl. Kedaluwarsa</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php            
            if(count((array)$modDetails) > 0){
                foreach($modDetails AS $i=>$modDetail){ ?>           
            
                <td><?php echo $i+1; ?></td>
                <td><?php echo (!empty($modDetail->obatalkes->jenisobatalkes_id) ? $modDetail->obatalkes->jenisobatalkes->jenisobatalkes_nama : ""); ?></td>
                <td><?php echo (!empty($modDetail->obatalkes_id) ? $modDetail->obatalkes->obatalkes_nama : ""); ?></td>
               <!--<td><?php //echo (!empty($modDetail->satuankecil_id) ? $modDetail->obatalkes->satuankecil->satuankecil_nama : ""); ?></td>-->
                <td><?php echo !empty($modDetail->tglkadaluarsa)?  MyFormatter::formatDateTimeForUser($modDetail->tglkadaluarsa):"-"; ?></td>
                <td style = "text-align:right;"><?php echo $modDetail->jmlpesan.' '.(!empty($modDetail->satuankecil_id) ? $modDetail->obatalkes->satuankecil->satuankecil_nama : ""); ?></td>
            </tr>
            <?php    }
            }
            ?>
        </tbody>
    </table>
</fieldset>
<table width="100%" style="margin-top:20px;">
    <tr>
        <td width="50%" align="center">
			Pegawai Pemesan,
            <div style="margin-top:50px;"></div><?php echo (isset($model->pegawaipemesan->NamaLengkap) ? $model->pegawaipemesan->NamaLengkap : ""); ?>
		</td>
        <td width="50%" align="center">
            <?php echo Yii::app()->user->getState('kabupaten_nama'); ?>, <?php echo $format->formatDateTimeForUser(date('Y-m-d')); ?><?php // echo Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-mm-dd hh:mm:ss')); ?><br>
            Pegawai Mengetahui,
            <div style="margin-top:50px;"></div><?php echo (isset($model->pegawaimengetahui->NamaLengkap) ? $model->pegawaimengetahui->NamaLengkap : ""); ?>
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
        pesanobatalkes_id = '<?php echo isset($model->pesanobatalkes_id) ? $model->pesanobatalkes_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&pesanobatalkes_id='+pesanobatalkes_id+'&caraprint='+caraprint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}?>
</div>		
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<?php
if (!isset($_GET['frame'])){
    
?>
<div class="footer">
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
</div>
<?php
}
?>