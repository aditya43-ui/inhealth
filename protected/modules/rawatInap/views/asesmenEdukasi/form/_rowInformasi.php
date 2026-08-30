<tr>
    <td>
        <?php 
            echo MyFormatter::formatDateTimeForUser(date("d M Y H:i:s",strtotime($modDet->tglpemeriksaan)));
        ?>
    </td>
    <td><?php echo $modDet->materiedukasi; ?></td>
    <td><?php echo $modDet->metodeedukasi; ?></td>
    <td><?php echo $modDet->durasi; ?> </td>
    <td><?php echo $modDet->hasilevaluasi; ?></td>
    <td><?php echo !empty($modDet->pegawai_pemberiedukasi_id)?$modDet->pemberiedukasi->namaLengkap:''; ?></td>
    <td><?php echo $modDet->namapenerima_edukasi; ?></td>
    <td>
        <?php echo CHtml::link(Yii::t('mds','{icon}',array('{icon}'=>"<i class='".MyIcon::getIcons('ubah')."'></i>")),$this->createUrl('index',array('pendaftaran_id'=> $_GET['pendaftaran_id'],'asesmen_id'=>$modDet->asesmenedukasi_id,'ubah'=>$modDet->kel_data)),
                array("rel"=>"tooltip","title"=>"Klik untuk mengubah data hasil evaluasi dan verifikasi informasi dan edukasi terintegrasi")); ?>
        <?php // echo CHtml::link("<i class='".MyIcon::getIcons('ubah')."'></i>",'javascript:;',array('onclick'=>'detailUbah('.$modDet->asesmenedukasi_id.',this)',"rel"=>"tooltip","title"=>"Klik untuk mengubah data hasil evaluasi dan verifikasi informasi dan edukasi terintegrasi")); ?></td>
    <td><?php echo CHtml::link("<i class='".MyIcon::getIcons('hapus')."'></i>",'javascript:;',array('onclick'=>'detailHapus('.$modDet->asesmenedukasi_det_id.',this)',"rel"=>"tooltip","title"=>"Klik untuk menghapus data hasil evaluasi dan verifikasi informasi dan edukasi terintegrasi")); ?></td>
</tr>  