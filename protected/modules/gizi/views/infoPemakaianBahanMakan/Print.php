<p style="margin: 0; text-align: center;">
<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
}
?>
<?php
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
    
    .table{
        box-shadow:none;
    }
        

    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
    .kertas{
     width:20cm;
     height:12cm;
    }
');
?>  
<?php
echo $this->renderPartial('application.views.headerReport.headerDefaultNew');
$format = new MyFormatter;
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
?>
<body class="kertas">
	<table class='table'>
    <tr>
        <td>
            <b><?php echo CHtml::encode($model->getAttributeLabel('no_pemakaianbhnmkn')); ?> </b>
        </td>
        <td>
            : <?php echo isset($model->no_pemakaianbhnmkn) ? $model->no_pemakaianbhnmkn : "-"; ?>
        </td>
        <td>&nbsp;</td>
        <td>
            <b>Ruangan</b>
        </td>
        <td>
            : <?php echo isset($model->ruanganpemakaibhnmkn) ? $model->ruangans->ruangan_nama : "-"; ?>
        </td>
    </tr>
    <tr>
        <td>
            <b>Tanggal Pemakaian Bahan Makanan </b>
        </td>
        <td>
            : <?php echo isset($model->tglpemakaianbhnmkn) ? $format->formatDateTimeForUser($model->tglpemakaianbhnmkn) : "-"; ?>            
        </td>
        <td>
            &nbsp;
        </td>
        <td>                        
            <b>Untuk Keperluan </b>
        </td>
        <td>
            : <?php echo isset($model->untukkeperluan) ? $model->untukkeperluan : "-"; ?>
        </td>
    </tr>   
	</table>
    
	
    <table class ="table border" style='margin-left:auto; margin-right:auto;'>
        <thead class="border">
            <th>No.</th>
            <th>Golongan</th>
            <th>Jenis</th>
            <th>Kelompok</th>
            <th>Bahan Makanan</th>
            <th>Tanggal Kedaluwarsa</th>
            <th>Jumlah Pakai</th>
            <th>Harga Netto (Rp)</th>
        </thead>
        <tbody>
            <?php 
                $total_harganetto = 0;
                $total_jmlpakai = 0;
                $no = 1;
                if(count((array)$modelDetail) >0){
                    foreach ($modelDetail as $i=>$detail){ 
                        $total_harganetto += (isset($detail->bahanmakanan->kelbahanmakanan)?$detail->bahanmakanan->harganettobahan:0);
                        $total_jmlpakai += $detail->jmlpemakaianbhnmkn; 
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo isset($detail->bahanmakanan->golbahanmakanan_id)?$detail->bahanmakanan->golbahanmakanan->golbahanmakanan_nama:""; ?></td>
                        <td><?php echo isset($detail->bahanmakanan->jenisbahanmakanan)?$detail->bahanmakanan->jenisbahanmakanan:""; ?></td>
                        <td><?php echo isset($detail->bahanmakanan->kelbahanmakanan)?$detail->bahanmakanan->kelbahanmakanan:""; ?></td>
                        <td><?php echo (isset($detail->bahanmakanan_id)?$detail->bahanmakanan->namabahanmakanan:""); ?></td>
                        <td><?php echo isset($detail->bahanmakanan->tglkadaluarsabahan) ? $format->formatDateTimeForUser($detail->bahanmakanan->tglkadaluarsabahan) : "-"; ?></td>
                        <td><?php echo number_format($detail->jmlpemakaianbhnmkn,0,"",".")." ".(isset($detail->bahanmakanan->kelbahanmakanan)?$detail->bahanmakanan->satuanbahan:""); ?></td>		
                        <td style="text-align:right;"><?php echo isset($detail->bahanmakanan->kelbahanmakanan)?number_format($detail->bahanmakanan->harganettobahan,0,"","."):"0"; ?></td>
                    </tr>
                <?php $no++;}
                    }else{
                        ?>
                    <tr>
                        <td colspan="8">
                           Data tidak ditemukan. 
                        </td>
                    </tr>    
                        <?php
                    }
                ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" align="center"><b>Total</b></td>
                <td style="text-align: center;"><?php echo number_format($total_jmlpakai,0,"","."); ?></td>
                <td style="text-align: right;"><?php echo number_format($total_harganetto,0,"","."); ?></td>
            </tr>
        </tfoot>
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
//    function print(caraPrint){
//        var pemakaianbahan_id = '<?php // echo isset($modPemakaianBarang->pemakaianbarang_id) ? $modPemakaianBarang->pemakaianbarang_id : ''; ?>';
//        window.open('<?php // echo $this->createUrl('print'); ?>&pemakaianbarang_id='+pemakaianbarang_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
//    }
    </script>
<?php
}else{ ?>
    <table width="100%" style="margin-top:20px;">
    <tr>
        <td width="100%" align="left" align="top">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="35%" align="center">
                        <div>Mengetahui<br></div>
                        <div style="margin-top:60px;"><?php echo isset($model->pegmengetahui_id)?$model->pegmengetahuis->namaLengkap:""; ?></div>
                    </td>
                    <td width="35%" align="center">
                    </td>
                    <td width="35%" align="center">
                        <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
                        <div>Dibuat Oleh :</div>
                        <div style="margin-top:60px;"><?php echo Yii::app()->user->getState('nama_pegawai'); ?></div>
                        <div></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
</body>
<?php } ?>
<?php 
$profil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
        $alamat=!empty($profil->alamatlokasi_rumahsakit)?$profil->alamatlokasi_rumahsakit:"";
	$motto=!empty($profil->motto)?$profil->motto:"";
        $telp=!empty($profil->no_telp_profilrs)?$profil->no_telp_profilrs:"";
        $email=!empty($profil->email)?$profil->email:"";
        $website=!empty($profil->website)?$profil->website:"";
        $layoutkiri=$alamat."<br>"."Telp:".$telp." Email:".$email." Website:".$website;
?>
<table width="100%" class="footer">
    <tr><td width="70%" style="text-align:left" align="left" class="alamatfooter"><?php echo  $layoutkiri ?></td><td class="mottofooter" style="text-align:right"  width="30%" align="right"><?php echo $motto ?></td></tr>
        
</table>