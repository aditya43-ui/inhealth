<!--<table style="width: 300px;margin:120px 0 0 0;" border="0">
    <tr>
        <td valign="MIDDLE" rowspan ="6" width="150px">
            <?php $this->widget('ext.MyBarcode.MyBarcode',array('code'=>$modPasien->no_rekam_medik,'imageOptions'=>array('style'=>'height:50px;width:150px;'))); ?>
        </td>
    </tr>
    <tr>
        <td><?php echo $modPasien->nama_pasien; ?></td>
    </tr>
    <tr>
        <td><?php echo $modPasien->jeniskelamin; ?></td>
    </tr>
    <tr>
        <td><?php echo $modPasien->tanggal_lahir; ?></td>
    </tr>
    <tr>
        <td><?php echo $modPasien->alamat_pasien; ?></td>
    </tr>
</table>
-->

<?php
    if($modPasien->kelompokumur_id == 1 || $modPasien->kelompokumur_id == 2)
    {
        $image = '/images/dua.png';
    }else{
        $image = '/images/satu.png';
    }
    $image_path = Yii::app()->request->baseUrl . $image;
?>

<table style="height:163px;margin:19px;width:260px;background:url('<?php echo $image_path;?>');" border="0">
    <tr>
        <td valign="bottom">
            <table widht="100%">
                <tr>
                    <!--<td width="190px" align="right" style="font-weight:bold;">-->
                    <td width="150px" align="right" style="font-weight:bold;">
                        <div><?php echo $model->nama_pasien; ?></div>
                        <div><?php echo $model->no_rekam_medik; ?></div>
                        <div>
                            <?php
                                $this->widget('ext.MyBarcode.MyBarcode',array(
                                        'code'=>$model->no_rekam_medik,
                                        'imageOptions'=>array(
                                            'style'=>'height:30px;width:150px;',
                                            'alt'=>null
                                         )
                                    )
                                );
                            ?>                            
                        </div>
                    </td>
                    <td width="60px" align="right"><!--<img src="<?php echo Yii::app()->request->baseUrl.'/data/images/pasien/'.$modPasien->photopasien; ?>" width="55px" />--></td>
                </tr>                
            </table>            
        </td>
    </tr>
</table>
