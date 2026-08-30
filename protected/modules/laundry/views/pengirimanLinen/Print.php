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

<style>
   
                .border th, .border td{
                    border:1px solid #000;
                }
                .table thead:first-child{
                    border-top:1px solid #000;        
                }

                thead th{
                    background:none;
                    color:#333;
                }

                .border {
                    box-shadow:none;
                    border-spacing: 0;
                    padding: 0;
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>

<table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                if($caraprint != 'EXCEL'){
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan'=>$judul_print));
                } ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                       
  <fieldset>
      <table width="74%" class="" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td>No. Pengiriman</td>
            <td>:</td>
            <td><?php echo $modPengirimanLinen->nopengirimanlinen; ?></td>
        </tr>
        <tr>
            <td>Tanggal Pengiriman</td>
            <td>:</td>
            <td><?php echo isset($modPengirimanLinen->tglpengirimanlinen) ? MyFormatter::formatDateTimeForUser($modPengirimanLinen->tglpengirimanlinen) : ""; ?></td>
        </tr>
        <tr>
            <td>Pegawai Mengirim</td>
            <td>:</td>
            <td><?php echo (isset($modPengirimanLinen->pegpengirim->NamaLengkap) ? $modPengirimanLinen->pegpengirim->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo $modPengirimanLinen->keterangan_pengiriman; ?></td>
        </tr>
    </table><br>
	<table class="items table border" id="table-detailpemesanan">
        <thead>
            <tr>
                <th>No.</th>
                <th>Kode Inventaris</th>
                <th>Nama Barang</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count((array)$modPengirimanLinenDetail) > 0){
                foreach($modPengirimanLinenDetail AS $i=>$modDetail){ ?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo (!empty($modDetail->linen_id) ? $modDetail->linen->kodelinen : ""); ?></td>
                <td><?php echo (!empty($modDetail->linen_id) ? $modDetail->linen->namalinen : ""); ?></td>
                <td><?php echo (!empty($modDetail->keterangan_linen) ? $modDetail->keterangan_linen : ""); ?></td>
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
			Pegawai Menyetujui,
            <div style="margin-top:50px;"></div><?php echo (isset($modPengirimanLinen->pegpengirim->NamaLengkap) ? $modPengirimanLinen->pegpengirim->NamaLengkap : ""); ?>
		</td>
        <td width="50%" align="center">
            <?php echo Yii::app()->user->getState('kabupaten_nama'); ?>, <?php echo $format->formatDateTimeForUser(date('Y-m-d')); ?><br>
            Pegawai Mengetahui,
            <div style="margin-top:50px;"></div><?php echo (isset($modPengirimanLinen->pegmengetahui->NamaLengkap) ? $modPengirimanLinen->pegmengetahui->NamaLengkap : ""); ?>
        </td>
    </tr>
</table>

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
<div class="footer">
   
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
   
</div>   

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
        perawatanlinen_id = '<?php echo isset($modPengirimanLinen->perawatanlinen_id) ? $modPengirimanLinen->perawatanlinen_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&perawatanlinen_id='+perawatanlinen_id+'&caraprint='+caraprint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}?>