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
    .border{
        border:1px solid;
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

    .border {
        box-shadow:none;
        border-spacing: 0;
        padding: 0;
    }
');
?>  
<?php
if(!$modPemakaianBhnmknDetail){
    echo "Data tidak ditemukan."; exit;
}
echo $this->renderPartial('application.views.headerReport.headerDefaultNew');
$format = new MyFormatter;
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
?>
<body class="kertas">
    <table width="74%" style="margin: 0;" align="left" cellpadding="0" cellspacing="0">
        <tr>
            <td><b>Tanggal Pemakaian Bahan Makanan</b></td>
            <td>:</td>
            <td><?php echo isset($modPemakaianBhnmkn->tglpemakaianbhnmkn) ? $format->formatDateTimeId($modPemakaianBhnmkn->tglpemakaianbhnmkn) : "-"; ?></td>
        </tr>
        <tr>
            <td><b>No. Pemakaian Bahan Makanan</b></td>
            <td>:</td>
            <td><?php echo isset($modPemakaianBhnmkn->no_pemakaianbhnmkn) ? $modPemakaianBhnmkn->no_pemakaianbhnmkn : "-"; ?></td>
        </tr>
        <tr>
            <td><b>Keterangan Pemakai</b></td>
            <td>:</td>
            <td><?php echo isset($modPemakaianBhnmkn->ketpemakaian) ? $modPemakaianBhnmkn->ketpemakaian : "-"; ?></td>
        </tr>
    </table><br><br>
    <table width="100%" style='margin-left:auto; margin-right:auto;' class="border">
        <thead class="border">
            <tr>                  
            <th>Golongan</th>
            <th>Jenis</th>
            <th>Kelompok</th>
            <th>Nama Bahan Makanan</th>  
            <th>Tanggal Kedaluwarsa</th>
            <th>Harga Netto (Rp)</th>
            <th>Jumlah Pakai</th>
        </tr>
        </thead>
        <tbody>
            
                 <?php
               if (isset($modPemakaianBhnmknDetail)){
            $format = new MyFormatter();
        foreach ($modPemakaianBhnmknDetail as $i=>$detail){?>
        <?php $modBhnMkn = BahanmakananM::model()->findByPk($detail->bahanmakanan_id); ?>
            <tr>   
                <td><?php 
        echo $modBhnMkn->golbahanmakanan->golbahanmakanan_nama;
        ?>
    </td>
    <td><?php echo $modBhnMkn->jenisbahanmakanan; ?></td>
    <td><?php echo $modBhnMkn->kelbahanmakanan; ?></td>
        <td><?php echo $modBhnMkn->namabahanmakanan; ?></td>    
    <td><?php echo $format->formatDateTimeForUser($modBhnMkn->tglkadaluarsabahan); ?></td>
    <!--<td><?php // echo number_format($modBahanmkn->harganettobahan,0,"","."); ?></td>-->
    <td><?php echo number_format($modBhnMkn->harganettobahan,0,"",".") ?> </td>
<!--//    <td><?php // echo (Params::cekHiddenHargaGudangUmum()==true || Params::cekHiddenHargaGudangFarmasi()==true)?CHtml::activeTextField($modDetail, '[ii]hargajual', array('class'=>'span2 integer2 satuan', )):CHtml::activePasswordField($modDetail, '[ii]hargajual', array('class'=>'span2 integer2 satuan', )); ?></td>-->
    <td><?php echo $detail->jmlpemakaianbhnmkn; ?></td>
     </tr>   
        <?php }
        }
        ?>
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
        pemakaianbarang_id = '<?php echo isset($modPemakaianBarang->pemakaianbarang_id) ? $modPemakaianBarang->pemakaianbarang_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&pemakaianbarang_id='+pemakaianbarang_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
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
                        <div>Mengetahui<br></div>
                        <div style="margin-top:60px;"><?php echo $modPemakaianBhnmkn->pegmengetahui_nama; ?></div>
                    </td>
                    <td width="35%" align="center">
                    </td>
                    <td width="35%" align="center">
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
