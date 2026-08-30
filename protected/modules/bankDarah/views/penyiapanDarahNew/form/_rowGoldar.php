<tr>
    <td>
        <?php 
            if(empty($model->no_kantongpabrik)) {
                echo $model->nomorbarcode;
            } else {
                echo $model->no_kantongpabrik;
            }
        ?>
    </td>
    <td>
        <?php echo $model->stokkantongdarah->jeniskantongdarah->nama_jenis ?>
    </td>
    <td>
        <?php 
            $checked = false;
            if(!empty($model->penyiapandarah_id)) {
                $checked = true;
            }
            echo CHtml::activeHiddenField($model, 'pemeriksaangoldar_id', ['class' => 'pemeriksaangoldar_id']);
            echo CHtml::activeCheckBox($model, '[' . $i . ']kirim_penyiapan', ['checked' => $checked, 'disabled' => $checked, 'onclick' => 'setKirimDarah(this)']);
        ?>
    </td>
</tr>