<!--<table style="width: 300px;margin:120px 0 0 0;" border="0">
    <tr>
        <td valign="MIDDLE" rowspan ="6" width="150px">
            <?php $this->widget('ext.MyBarcode.MyBarcode',array('code'=>$model->nomorindukpegawai,'imageOptions'=>array('style'=>'height:50px;width:150px;background:transparent;'))); ?>
        </td>
    </tr>
    <tr>
        <td><?php echo $model->nomorindukpegawai; ?></td>
    </tr>
    <tr>
        <td><?php echo $model->NamaLengkap; ?></td>
    </tr>
    <tr>
        <td><?php echo $model->jeniskelamin; ?></td>
    </tr>
    <tr>
        <td><?php echo $model->tgl_lahirpegawai; ?></td>
    </tr>
</table>
-->

<?php
    $image = '/images/KartuPegawai.jpg';
    $image_path = Yii::app()->request->baseUrl . $image;

    $photo = '/data/images/pegawai/'.$model->photopegawai;
    $photo_path = Yii::app()->request->baseUrl . $photo;
?>

<table style="height:163px;margin:19px;width:260px;background:url('<?php echo $image_path;?>');" border="0">
    <tr>
        <td valign="bottom">
            <table width="100%" height="60%">
                <tr>
                    <td width="35%" align="center"><img src="<?php echo $photo_path; ?>" alt="" height="85px" width="57px"> </td>
                    <td align="left" style="font-weight:bold;">
                        <div style="font-size:8pt;">Nama : <?php echo $model->NamaLengkap; ?></div>
                        <div style="font-size:8pt;">NIP  : <?php echo $model->nomorindukpegawai; ?></div>
                        <div>
                            <?php
                                $this->widget('ext.MyBarcode.MyBarcode',array(
                                        'code'=>$model->nomorindukpegawai,
                                        'imageOptions'=>array(
                                            'style'=>'height:30px;width:150px;',
                                            'alt'=>null
                                         )
                                    )
                                );
                            ?>                            
                        </div>
                    </td>
                </tr>                
            </table>            
        </td>
    </tr>
</table>
