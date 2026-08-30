<div class="control-group">
    <?php echo $form->labelEx($model, 'tindaklanjutpasien', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        $kamar_asal;
        $masuk = MasukkamarT::model()->findByPk($model->masukkamar_id);
        $pindah = PindahkamarT::model()->findByAttributes(array(
            'masukkamar_id' => $masuk->masukkamar_id
        ));
        $masukAsal = MasukkamarT::model()->findByAttributes(array(
            'pindahkamar_id' => $pindah->pindahkamar_id
        ));
        $pindahkamar2 = clone $pindahkamar;
        $kamar_asal = "";

        if (!empty($masukAsal) && empty($model->tindaklanjutpasien_masukkamar_id)) {

            $kamar_asal = $masukAsal->ruangan->ruangan_nama . (empty($masukAsal->kamarruangan) ? "" : (" - Kamar : " . $masukAsal->kamarruangan->kamarruangan_nokamar . " - Bed : " . $masukAsal->kamarruangan->kamarruangan_nobed));
            $pindahkamar2->ruangan_id = $masukAsal->ruangan_id;
            $pindahkamar2->kamarruangan_id = $masukAsal->kamarruangan_id;
        }
        
        if (!empty($model->tindaklanjutpasien_masukkamar_id)) {
            $masukAsal = $masukAsal = MasukkamarT::model()->findByPk($model->tindaklanjutpasien_masukkamar_id);
            $kamar_asal = $masukAsal->ruangan->ruangan_nama . (empty($masukAsal->kamarruangan) ? "" : (" - Kamar : " . $masukAsal->kamarruangan->kamarruangan_nokamar . " - Bed : " . $masukAsal->kamarruangan->kamarruangan_nobed));
            $pindahkamar2->ruangan_id = $masukAsal->ruangan_id;
            $pindahkamar2->kamarruangan_id = $masukAsal->kamarruangan_id;
            $pindahkamar->ruangan_id = $masukAsal->ruangan_id;
            $pindahkamar->kamarruangan_id = $masukAsal->kamarruangan_id;
            
        }
        
        
        
        ?>
        <div class="radio_ceklis_tindaklanjut">

            <?php echo $form->radioButton($model, 'tindaklanjutpasien', array('disabled'=>!empty($model->tindaklanjutpasien_masukkamar_id), 'uncheckValue' => null, 'value' => 'Ruangan Perawatan Asal Pasien', 'class'=>'radio_ceklis')); ?> <label>Ruangan Perawatan Asal Pasien</label>
            <div class="radio_ceklis_content">
                <?php
                echo $form->hiddenField($pindahkamar2, 'kamarruangan_id');
                echo $form->hiddenField($pindahkamar2, 'ruangan_id');
                ?>

                <?php echo CHtml::textArea('tindaklanjut_ruangan', $kamar_asal, array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <br>
        <div class="radio_ceklis_tindaklanjut">
            <?php echo $form->radioButton($model, 'tindaklanjutpasien', array('disabled'=>!empty($model->tindaklanjutpasien_masukkamar_id), 'uncheckValue' => null, 'value' => 'Ruangan Lain Instalasi', 'class'=>'radio_ceklis')); ?> <label>Ruangan Lain Instalasi</label><br>
            <div class="radio_ceklis_content">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'ruangan_id', array('class' => 'control-label required', 'label' => 'Ruangan')); ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($pindahkamar, 'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                                'instalasi_id' => array(Params::INSTALASI_ID_RI, Params::INSTALASI_ID_PERAWATAN_INTENSIF),
                            ), array(
                                'order' => 'ruangan_nama'
                            )), 'ruangan_id', 'ruangan_nama'), array(
                            'empty' => '-- Pilih --',
                            'class' => 'span3',
                            'onkeyup' => "return $(this).focusNextInputField(event);",
                            'onChange' => 'updateKamarRuangan($(this).val());',
                            'disabled' => !empty($model->tindaklanjutpasien_masukkamar_id),
                        ));
                        ?> 
                    </div>
                </div>
                <?php
                $kamarList = array();
                if (!empty($pindahkamar->ruangan_id)) {
                    $kamarList = CHtml::listData(KamarruanganM::model()->findAllByAttributes(array(
                                        'ruangan_id' => $pindahkamar->ruangan_id,
                                    )), 'kamarruangan_id', 'KamarDanTempatTidur');
                }
                ?>
                <div class="control-group">
                    <?php echo $form->labelEx($pindahkamar, 'kamarruangan_id', array('class' => 'control-label required', 'label' => 'Kamar Ruangan/No. Bed ')); ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($pindahkamar, 'kamarruangan_id', $kamarList, array(
                            'empty' => '-- Pilih --',
                            'class' => 'span3 kamarruangan_pilih',
                            'onkeyup' => "return $(this).focusNextInputField(event);",
                            'disabled' => !empty($model->tindaklanjutpasien_masukkamar_id),
                        ));
                        ?> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    function cekTindakLanjut() {
        $(".radio_ceklis_tindaklanjut").each(function() {
            var ceklis = $(this).find(".radio_ceklis:checked").length;
            console.log("CEKLIS", ceklis);
            if (ceklis > 0) {
                $(this).find(".radio_ceklis_content :input").prop("disabled", false);
            } else {
                $(this).find(".radio_ceklis_content :input").prop("disabled", true);
            }
        });
    }
    
    $(document).ready(function() {
        cekTindakLanjut();
        $(".radio_ceklis_tindaklanjut .radio_ceklis").on("click", cekTindakLanjut);
    });

    function updateKamarRuangan(ruangan_id)
    {
        var idRuangan = ruangan_id
        jQuery.ajax({'type': 'POST',
            'url': '<?php echo $this->createUrl('getKamarKosong', array('encode' => false, 'namaModel' => 'PindahkamarT')); ?>', 'cache': false,
            'data': {ruangan_id: idRuangan, all_kamar: true},
            'success': function (html) {
                jQuery(".kamarruangan_pilih").html(html);
            }
        });
    }

</script>