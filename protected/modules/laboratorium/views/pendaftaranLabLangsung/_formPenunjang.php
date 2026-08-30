<?php echo $form->hiddenField($modPasienMasukPenunjang, '[' . $i . ']pendaftaran_id', array('readonly' => true, 'class' => 'span3')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang, '[' . $i . ']pasienmasukpenunjang_id', array('readonly' => true, 'class' => 'span3')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang, '[' . $i . ']ruangan_id', array('readonly' => true, 'class' => 'span3')); ?>
<?php
    $ruangan_skr = Yii::app()->user->getState('ruangan_id');
    $hide_kp = $ruangan_skr == 53 ? "hide" : "";
?>
<div class="<?php $hide_kp ?>">
    <?php echo $form->dropDownListRow($modPasienMasukPenunjang, '[' . $i . ']jeniskasuspenyakit_id', CHtml::listData($model->getJenisKasusPenyakitItems($modPasienMasukPenunjang->ruangan_id), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
</div>
<div class="hide">
    <?php echo $form->dropDownListRow($modPasienMasukPenunjang, '[' . $i . ']kelaspelayanan_id', CHtml::listData($model->getKelasPelayananItems($modPasienMasukPenunjang->ruangan_id), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => "setKarcis(" . $i . ");", 'class' => 'span3 kelaspelayanan_0')); ?>
</div>
<div class="control-group">
    <?php echo CHtml::label('Dokter', 'pegawai_id', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $form->dropDownList($modPasienMasukPenunjang, '[' . $i . ']pegawai_id', CHtml::listData($model->getDokterItems($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'nama_pegawai'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Analis', 'perawat_id', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $form->dropDownList($modPasienMasukPenunjang, '[' . $i . ']perawat_id', CHtml::listData(LBPegawaiM::model()->getTenagaLaboratoriums($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'nama_pegawai'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label">Dokter Perujuk</label>
    <div class="controls">
    <?php 
    echo $form->hiddenField($modPasienMasukPenunjang, '[' . $i . ']dokterperujuk', array('class'=>'dokterperujuk'));
                $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modPasienMasukPenunjang,
                                'attribute'=>'[' . $i . ']dokter_perujuk',
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('autocompleteDokterPerujuk').'",
                                                   dataType: "json",
                                                   data: {
                                                       term: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'minLength' => 2,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val( ui.item.label);
                                            $(".dokterperujuk").val( ui.item.value);
                                            return false;
                                        }',
                                ),
                                //'tombolDialog'=>array('idDialog'=>'dialogDokter'),
                                'htmlOptions'=>array('placeholder'=>'Ketik Dokter Perujuk','class'=>'span3 dokter_perujuk','rel'=>'tooltip','title'=>'Ketik dokter perujuk / klik icon untuk mencari data dokter perujuk',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",                                    
                                    ),
                            )); 
            ?>
    </div>
</div>
<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Pilih Pemeriksaan', array('{icon}' => '<i class="glyphicon glyphicon-briefcase"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', "onclick" => "setChecklistPemeriksaanLab($('#form-pemeriksaan-" . $i . "')," . $i . "); ")); ?>
<div id="form-tindakanpemeriksaan-<?php echo $i; ?>" style="margin-top: 8px;">
    <table class="table table-condensed table-striped">
        <thead>
            <th>No.</th>
            <th>Nama Pemeriksaan</th>
            <th>Jumlah</th>
            <th>Satuan</th>
            <th>Tarif</th>
            <th>Total Tarif</th>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>