
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
    <table width="74%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td>No. Pencucian</td>
            <td>:</td>
            <td><?php echo $modPencucianLinen->nopencucianlinen; ?></td>
        </tr>
        <tr>
            <td>Tanggal Perawatan</td>
            <td>:</td>
            <td><?php echo isset($modPencucianLinen->tglpencucianlinen) ? MyFormatter::formatDateTimeForUser($modPencucianLinen->tglpencucianlinen) : ""; ?></td>
        </tr>
        <tr>
            <td>Pegawai Mengetahui</td>
            <td>:</td>
            <td><?php echo (isset($modPencucianLinen->pegpenerima->NamaLengkap) ? $modPencucianLinen->pegpenerima->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo $modPencucianLinen->keterangan_pencucianlinen; ?></td>
        </tr>
    </table><br>
    <table class="items table border" id="table-detailpemesanan">
        <thead>
            <tr>
                <th>No.</th>
                <th>Ruangan Asal</th>
                <th>No. Penerimaan</th>
                <th>Kode Linen</th>
                <th>Nama Linen</th>
                <th>Keterangan</th>
                <th>Status Pencucian</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count((array)$modPencucianLinenDetail) > 0){
                foreach($modPencucianLinenDetail AS $i=>$modDetail){ ?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo (!empty($modDetail->ruangan_id) ? $modDetail->ruangan_nama : ""); ?></td>
                <td><?php echo (!empty($modDetail->penerimaanlinen_id) ? $modDetail->nopenerimaanlinen : ""); ?></td>
                <td><?php echo (!empty($modDetail->kodelinen) ? $modDetail->kodelinen : ""); ?></td>
                <td><?php echo (!empty($modDetail->namalinen) ? $modDetail->namalinen : ""); ?></td>
                <td><?php echo isset($modDetail->keteranganpenerimaanlinen_item) ? $modDetail->keteranganpenerimaanlinen_item : ""; ?></td>
                <td><?php echo isset($modDetail->statuspencucian) ? $modDetail->statuspencucian : ""; ?></td>
            </tr>
            <?php    }
            }
            ?>
        </tbody>
    </table>
	<span>Data Bahan Perawatan</span>
	<table class="items table table border" id="table-detailpemesanan">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Bahan</th>
                <th>Jumlah Bahan</th>
                <th>Satuan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count((array)$modPencucianBahan) > 0){
                foreach($modPencucianBahan AS $i=>$modBahan){ ?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo (!empty($modBahan->bahanperawatan_id) ? $modBahan->bahanperawatan->bahanperawatan_nama : ""); ?></td>
                <td><?php echo (!empty($modBahan->jmlpemakaian) ? $modBahan->jmlpemakaian : ""); ?></td>
                <td><?php echo (!empty($modBahan->satuanpemakaian) ? $modBahan->satuanpemakaian : ""); ?></td>
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
            <div style="margin-top:50px;"></div><?php echo (isset($modPencucianLinen->pegpenerima->NamaLengkap) ? $modPencucianLinen->pegpenerima->NamaLengkap : ""); ?>
		</td>
        <td width="50%" align="center">
            <?php echo Yii::app()->user->getState('kabupaten_nama'); ?>, <?php echo $format->formatDateTimeForUser(date('Y-m-d')); ?><br>
            Pegawai Mengetahui,
            <div style="margin-top:50px;"></div><?php echo (isset($modPencucianLinen->petugas->NamaLengkap) ? $modPencucianLinen->petugas->NamaLengkap : Yii::app()->user->getState('nama_pegawai')); ?>
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
        pencucianlinen_id = '<?php echo isset($modPencucianLinen->pencucianlinen_id) ? $modPencucianLinen->pencucianlinen_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&pencucianlinen_id='+pencucianlinen_id+'&caraprint='+caraprint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}?>