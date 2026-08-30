<br>
<div class="panel panel-dark">
    <span class="group-title">
        Intra Muskular Cairan
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
            $nilai = "";

            if (!$model->isNewRecord) {
                $det = CairanimduranteopT::model()->findByAttributes(array(
                    'anastesiduranteoperasi_id'=>$model->anastesiduranteoperasi_id,
                    'obatalkes_id'=>$item,
                ));

                if (!empty($det)) {
                    $is_ceklis = true;
                    $nilai = empty($det->jumlah_cairanim) ? "" : number_format($det->jumlah_cairanim, 2, ",", ".");
                }
            }


            echo '<div class="checkbox cb_main">';
            echo CHtml::checkBox('intramuskular['.$item.'][ceklis]', $is_ceklis, array('class'=>'cb_ceklis', 'uncheckValue'=>false));
            echo CHtml::label($obat->obatalkes_nama, '')."<br>";
            echo CHtml::label("Jumlah ", '').CHtml::textField('intramuskular['.$item.'][jumlah]', $nilai, array(
                'class'=>'span1 float2 cb_input'
            ));
            echo '</div>';
        }
        ?>
    </div>
</div>
