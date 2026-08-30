<div class="panel-body">
    <?php   
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'list-presdokter',
            'content' => array(
                'content-list-presdokter' => array(
                    'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini hide', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk Menampilkan Form Prescription Dokter')) . ' Prescription Dokter',
                    'isi' => $this->renderPartial($this->path_view . '_prescriptiondokter', array(
                        'form' => $form,
                        'model' => $model,
                            ), true),
                    'active' => true,
                    'disabled'=>true,
                ),
            ),
        ));

        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'list-alatbahan',
            'content' => array(
                'content-list-alatbahan' => array(
                    'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini hide', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk Menampilkan Form Kelengakapan Alat HD')) . ' Kelengakapan Alat HD',
                    'isi' => $this->renderPartial($this->path_view . '_alatbahan', array(
                        'model' => $model, 'modAlatBahan' => $modAlatBahan, 'form' => $form
                            ), true),
                    'active' => true,
                ),
            ),
        ));
    ?>
    <div class="control-group">
        <label>Apakah ada perubahan untuk perawatan selanjutnya ? 
            <?= $form->radioButton($model, 'perubahan', array('value' => 'ya', 'uncheckValue' => null, 'onclick' => 'cekPerubahan("ya")')); ?> <label>Ya</label>
            <?= $form->radioButton($model, 'perubahan', array('value' => 'tidak', 'uncheckValue' => null, 'onclick' => 'cekPerubahan("tidak")')); ?> <label>Tidak</label>
        </label>
    </div>                    
    <?php echo $this->renderPartial($this->path_view . '_prescriptiondokter2', array('model' => $model, 'modPrescription' => $modPrescription, 'form' => $form)); ?>
    <?php echo $this->renderPartial($this->path_view . '_kelengkapanalat', array('model' => $model, 'modPrescription' => $modPrescription, 'modAlatBahan' => $modAlatBahan, 'modKelengkapanAlat' => $modKelengkapanAlat, 'form' => $form, 'modResephd' => $modResephd)); ?>
</div>