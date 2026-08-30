<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
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

    .table {
        box-shadow:none;
    }

    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
');  
if (!isset($_GET['frame'])){
    echo $this->renderPartial($this->path_view.'_headerPrint'); 
}
?>
<table class="table" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
        <td style ="text-align:center;" valig="middle" colspan="6">
            <b><?php echo $judulLaporan ?></b>
        </td>
    </tr>
    <tr>
        <td><b>No. Formulir Opname</b></td>
        <td>:</td>
        <td> <?php echo $model->noformulir; ?></td>

        <td><b>Total Volume</b></td>
        <td>:</td>
        <td> <?php echo $format->formatNumberForPrint($model->totalvolume); ?></td>
    </tr>
    <tr>
        <td><b>Tanggal Formulir Opname</b></td>
        <td>:</td>
        <td> <?php echo $format->formatDateTimeForUser($model->tglformulir); ?></td>

        <?php /*
        <td><b>Total Harga</b></td>
        <td>:</td>
        <td> <?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?$format->formatNumberForPrint($model->totalharga):"Hidden"; ?></td>
         * 
         */ ?>
    </tr>
</table><br>
<table class="table border">
    <thead>
        <tr>
            <th>No.</th>
            <th>Jenis Bahan Makanan</th>
            <th>Nama Bahan Makanan</th>
            <th>Golongan</th>
            <th>Satuan</th>
            <th>Stok Sistem</th>
            <th>Stok Fisik</th>
            <th>Kondisi Bahan Makanan</th>
            <th>Tanggal Periksa Fisik</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($modDetails as $i=>$makanan){
        ?>
        <tr>
            <td><?php echo ($i+1); ?></td>
            <td><?php echo (isset($makanan->bahanmakanan->jenisbahanmakanan) ? $makanan->bahanmakanan->jenisbahanmakanan : ""); ?></td>
            <td><?php echo $makanan->bahanmakanan->namabahanmakanan; ?></td>
            <td><?php echo $makanan->bahanmakanan->golbahanmakanan->golbahanmakanan_nama; ?></td>
            <td><?php echo $makanan->bahanmakanan->satuanbahan; ?></td>
            <td><?php echo !empty($makanan->stokopnamegizidet->volume_sistem)?$makanan->stokopnamegizidet->volume_sistem:$makanan->volume_stok; ?></td>
            <td><?php echo !empty($makanan->stokopnamegizidet->volume_fisik)?$makanan->stokopnamegizidet->volume_fisik:'-'; ?></td>
            <td><?php echo !empty($makanan->stokopnamegizidet->kondisibarang)?$makanan->stokopnamegizidet->kondisibarang:'-'; ?></td>
            <td><?php echo !empty($makanan->stokopnamegizidet->tglperiksafisik)?MyFormatter::formatDateTimeForUser($makanan->stokopnamegizidet->tglperiksafisik):"-" ?></td>
        </tr>
        <?php } ?>
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
        formuliropnamegizi_id = '<?php echo isset($model->formuliropnamegizi_id) ? $model->formuliropnamegizi_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&formuliropnamegizi_id='+formuliropnamegizi_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=640,height=480');
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
                </td>
                <td width="35%" align="center">
                </td>
                <td width="35%" align="center">
                    <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
                    <div>Petugas</div>
                    <div style="margin-top:60px;"><?php echo Yii::app()->user->getState('nama_pegawai'); ?></div>
                </td>
            </tr>
        </table>
    </td>
</tr>
</table>
<?php } 