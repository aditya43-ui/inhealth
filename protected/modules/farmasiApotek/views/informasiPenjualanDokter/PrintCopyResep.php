<?php 
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('colspan'=>7));      
?>
<div style='border:1px solid #cccccc; border-radius:2px;padding:10px; width: 10%;float:right;margin-top:-70px;'>
                <span style='font-size:9pt'><B>SALIN RESEP</B><br></div>
<?php
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:120px;
        color:black;
        padding-right:10px;
    }
    table{
        font-size:11px;
    }
');
?><br><br><br>
<table width="100%" style="margin: 0;margin-left:30px;" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0" style='margin-top:-30px;'>
                <tr>
                    <td width="10%">
                             <b><?php echo CHtml::encode($modelPenjualanResep->getAttributeLabel('noresep')); ?></b>
                    </td>
                    <Td width="5%"><b>:</b></td>
                    <td width="20%" style="margin-left:20px;"><?php echo CHtml::encode($modelPenjualanResep->noresep); ?></td>

                    <td width="10%">
                            <b><?php echo CHtml::encode($modPasien->getAttributeLabel('no_rekam_medik')); ?></b>
                    </td>
                    <td width="5%"><b>:</b></td>
                    <td width="20%">
                        <?php
                                echo ($modPasien->no_rekam_medik == null) ? "-" : CHtml::encode($modPasien->no_rekam_medik);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td width="10%"><b>Tgl. Resep</b></td>
                    <td width="5%"><b>:</b></td>
                    <Td width="20%"> <?php echo CHtml::encode($modelPenjualanResep->tglresep); ?></td>
                    
                    <td width="10%"><b>Nama Pasien</b></td>
                    <td width="5%"><b>:</b></td>
                    <Td width="20%"> <?php echo CHtml::encode($modPasien->nama_pasien); ?></td>
                </tr>
                <tr>
                    <td width="10%"><b>Dokter</b></td>
                    <td width="5%"><b>:</b></td>
                    <Td width="20%"> <?php echo (empty($modDetailPenjualan[0]->nama_pegawai )) ? " - " :  $modDetailPenjualan[0]->nama_pegawai  ?></td>
                    
                    <td width="10%"> 
                            <b>Alamat Pasien</b>
                    <td width="1%"><b>:</b></td>
                    <td width="20%">
                        <?php
                                echo ($modPasien->alamat_pasien == null) ? "-" : CHtml::encode($modPasien->alamat_pasien);
                        ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table id="tableObatAlkes" class="table table-bordered table-condensed" style="margin-top:5px;">
    <thead>
    <tr>
        <th style='text-align:center;'>No</th>
        <th style='text-align:center;'>Kode Obat</th>
        <th style='text-align:center;'>Nama Obat</th>
        <th style='text-align:center;'>Jumlah</th>
        <th style='text-align:center;'>Aturan Pakai</th>
    </tr>
    </thead>
    <?php
    if (count((array)$modDetailPenjualan) > 0) {
        $no = 1;
        foreach($modDetailPenjualan AS $tampilData):
            echo "<tr>
                    <td style='text-align:center'>".$no."</td>
                    <td>".$tampilData->obatalkes_kode."</td>  
                    <td>".$tampilData->obatalkes_nama."</td>   
                    <td>".$tampilData->qty_oa."</td>   
                    <td>".$tampilData->signa_oa."</td>
                 </tr>";  
            $no++;
           
        endforeach;
    }
    else{
        echo '<tr><td colspan=12>'.Yii::t('zii','No. results found.').'</td></tr>';
    }
     
    ?>
</table>
<table style="margin-top:50px;">
    <tr>
        <td>
            <span style='font-size:9pt'><b>Keterangan : </b><br>
        </td>
    </tr>
    <tr>
        <td>
            <table border="1" width="200px;" height="100px;" style="border-color: gray;">
                <tr>
                    <td style="vertical-align: top">
                        <?php foreach($modCopy as $i=>$datacopy){ echo $datacopy->keterangancopy; } ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<?php
        echo $this->renderPartial('application.views.headerReport.footer2Default',array('colspan'=>7)); 
?>