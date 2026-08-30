<br>
<div class="panel panel-dark">
    <span class="group-title">
        Medikasi yang Digunakan
    </span>
    <div class="panel-body">
        <?php
        $oa = CHtml::listData(ObatalkespasienT::model()->findAllByAttributes(array(
                            'pendaftaran_id' => $model->pendaftaran_id,
                            'pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id,
                                ), array(
                            'condition'=>'ruangan_id = ' . Yii::app()->user->getState('ruangan_id'),
                        )), 'obatalkes_id', 'obatalkes_id');

        foreach ($oa as $item) {
            $obat = ObatalkesM::model()->findByPk($item);
            $is_ceklis = false;

            if (!$model->isNewRecord) {
                $det = MedikasiduranteoperasiT::model()->countByAttributes(array(
                    'anastesiduranteoperasi_id'=>$model->anastesiduranteoperasi_id,
                    'obatalkes_id'=>$item,
                ));

                $is_ceklis = $det != 0;
            }

            echo '<div class="checkbox">';
            echo CHtml::checkBox('medikasi['.$item.']', $is_ceklis);
            echo CHtml::label($obat->obatalkes_nama, '');
            echo '</div>';
        }
        ?>
    </div>
</div>
