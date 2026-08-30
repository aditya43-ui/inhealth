<style>
    .alig{
      text-align:left !important;   
    }
</style>
<?php
$no_rekam_medik = "";
$no_pendaftaran = "";
$nama_pasien = "";
$jeniskelamin = "";
$umur = "";
$tgl_pendaftaran = "";
$instalasi = "";
$ruangan = "";
$pendaftaran_id = "";
$penjamin_nama = "";


if (isset($_GET['insidenrs_id'])) {
    if (!empty($model->pendaftaran_id)) {
        $pendaftaran = PendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
        $pasien = PasienM::model()->findByAttributes(array('pasien_id' => $pendaftaran->pasien_id));
        if (!empty($model->diagnosa_id)) {
            $diagnosa = DiagnosaM::model()->findByAttributes(array('diagnosa_id' => $model->diagnosa_id));
            $model->diagnosa_nama = $diagnosa->diagnosa_nama;
            $diagnosa_id = $diagnosa->diagnosa_id;
        }

        $no_rekam_medik = $pasien->no_rekam_medik;
        $no_pendaftaran = $pendaftaran->no_pendaftaran;
        $nama_pasien = $pasien->nama_pasien;
        $jeniskelamin = $pasien->jeniskelamin;
        $umur = $pendaftaran->umur;
        $tgl_pendaftaran = MyFormatter::formatDateTimeForUser($pendaftaran->tgl_pendaftaran);
        $instalasi = $pendaftaran->instalasi->instalasi_nama;
        $ruangan = $pendaftaran->ruangan->ruangan_nama;
        $pendaftaran_id = $model->pendaftaran_id;
        $penjamin_nama = $pendaftaran->penjamin->penjamin_nama;
    } else {
        $no_rekam_medik = $model->norekammedik;
        $nama_pasien = $model->nama_pasien;
        $umur = $model->umur;
        $jeniskelamin = $model->jenis_kelamin;
        $penjamin_nama = $model->penanggungjawab_biaya;
        $tgl_pendaftaran = MyFormatter::formatDateTimeForUser($model->tanggal_masukrs);
        if (!empty($model->diagnosa_id)) {
            $diagnosa = DiagnosaM::model()->findByAttributes(array('diagnosa_id' => $model->diagnosa_id));
            $model->diagnosa_nama = $diagnosa->diagnosa_nama;
            $diagnosa_id = $diagnosa->diagnosa_id;
        }
        if (!empty($model->instalasi_id)) {
            $cekInstalasi = InstalasiM::model()->findByPk($model->instalasi_id);
            $instalasi = $cekInstalasi->instalasi_nama;
        } else {
            $instalasi = '-';
        }
        if (!empty($model->ruangan_id)) {
            $cekRuangan = RuanganM::model()->findByPk($model->ruangan_id);
            $ruangan = $cekRuangan->ruangan_nama;
        } else {
            $ruangan = '-';
        }
        $no_pendaftaran = '';
        $pendaftaran_id = '';
    }
}

?>
<div class="span6">      
      <div class="control-group">
          <div class="control-group">
            <?php echo CHtml::label('1.', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
            <?php echo CHtml::label('Nama Pasien', 'nama_pasien', array('class' => 'control-label alig')) ?>
        <div class="controls"> 
            <?php echo CHtml::textField("nama_pasien", $nama_pasien, array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
        </div>
    </div>
    <?php echo CHtml::label('2.', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
    <?php
        echo $form->labelEx($model, 'no_rekam_medik', array(
        'class'=>'control-label alig',
        'label'=>'No. Rekam Medik <span class="required">*</span>',
        )); 
        ?>
        <div class="controls">
        <?php
            // --- end
                
            $this->widget('MyJuiAutoComplete', array(
                    'name'=>'no_rekam_medik',
                    'value'=>$no_rekam_medik,
                    'source'=>'js: function(request, response) {
                                   $.ajax({
                                       url: "' . $this->createUrl('AutocompleteKunjunganPasien') . '",
                                       dataType: "json",
                                       data: {
                                           term: request.term,
                                           tipe: 1,
                                       },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
                    'options'=>array(
                           'showAnim'=>'fold',
                           'minLength' => 3,
                           'focus'=> 'js:function( event, ui ) {
                                $(this).val("");
                                return false;
                            }',
                           'select'=>'js:function( event, ui ) {
                                $(this).val(ui.item.label);
                                setKunjungan(ui.item);
                                return false;
                            }',
                    ),
                    'htmlOptions'=>array(
                        'disabled'=>true,
                        'onkeyup'=>"return $(this).focusNextInputField(event)",
                        'class'=>'span3 no_rekam_medik required',
                    ),
                ));
        ?>
        </div>
    </div>
    
    
    <div class="control-group">
        <?php echo CHtml::label('3.', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <?php echo CHtml::label('Ruangan', 'ruangan_pasien', array('class' => 'control-label alig')) ?>
        <div class="controls"> 
            <?php echo CHtml::textField("ruangan_pasien", $ruangan, array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('4.', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <?php echo CHtml::label('Jenis Kelamin', 'jeniskelamin', array('class' => 'control-label alig')) ?>
        <div class="controls"> 
            <?php echo CHtml::textField("jeniskelamin", $jeniskelamin, array(
                    'readonly'=>true,
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
        </div>
    </div>
</div>
<div class="span6">
    <div class="control-group">
        <?php echo CHtml::label('5.', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <?php echo CHtml::label('Umur', 'umur', array('class' => 'control-label alig')) ?>
        <div class="controls"> 
            <?php echo CHtml::textField("umur", $umur, array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('6.', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <?php echo CHtml::label('Penanggung Biaya Pasien', 'penanggungbiaya', array('class' => 'control-label alig')) ?>
        <div class="controls">
            <?php
                $lookup = LookupM::getItemsUrutan('penanggungbiayapasien');
                $i = 0;
                foreach($lookup as $key => $val){
            ?>
                <?php echo CHtml::activeRadioButton($model, 'penanggungjawab_biaya',array('uncheckValue'=>null, 'value'=>$key, 'class' => 'sponsorkualifikasi', 'disabled' => true)); ?>
                <label>&nbsp; <?php echo $val; ?></label>
                <?php } ?>
        </div>
    </div>
    
    <?php if($model->penanggungjawab_biaya == 'Lainnya') : ?>
    <div class="control-group">
        <?php echo CHtml::label('', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <?php echo CHtml::label('', 'penanggungbiaya', array('class' => 'control-label alig')) ?>
        <div class="controls">    
            <?php echo CHtml::activeTextField($model, 'penanggungjawabpasien_lainnya_ket', array('class' => 'span3', 'disabled' => true)); ?>       
        </div>
    </div>
    <?php endif;?>
    <div class="control-group">
        <?php echo CHtml::label('7.', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <?php echo CHtml::label('Tanggal Masuk RS', 'tanggalmasukrs', array('class' => 'control-label alig')) ?>
        <div class="controls"> 
            <?php echo CHtml::textField("tanggal_kunjungan", $tgl_pendaftaran, array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); 
                    echo $form->hiddenField($model, 'pendaftaran_id', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); 
            ?>
   
         </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('8.', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <?php echo CHtml::label('Diagnosa <span class="required">*</span>', 'diagnosa_id', array('class' => 'control-label required alig')) ?>
        <div class="controls">
            <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'diagnosa_nama',
                    'source' => 'js: function(request, response) {
                    $.ajax({
                            url: "' . $this->createUrl('AutoCompleteDiagnosa') . '",
                            dataType: "json",
                            data: {
                                term: request.term,
                            },
                            success: function (data) {
                                response(data);
                            }
                    })
                 }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 3,
                        'select' => 'js:function( event, ui ) {
                            $(this).val( ui.item.diagnosa_nama );
                            $("#InsidenrsT_diagnosa_nama").val( ui.item.diagnosa_nama );
                            $("#InsidenrsT_diagnosa_id").val( ui.item.diagnosa_id );
                            return false;
                }',
                    ),
                    'htmlOptions'=>array(
                        'disabled'=>true,
                        'class' => 'span3 required',
                    ),
                    ));
                echo $form->hiddenField($model, 'diagnosa_id', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('9.', '', array('class' => 'control-label alig', 'style' => 'width:20px')) ?>
        <?php echo CHtml::label('Diagnosa Lainnya <span class="required">*</span>', 'diagnosa_lainnya', array('class' => 'alig control-label')) ?>
        <div class="controls"> 
            <?php echo $form->textArea($model,'diagnosa_lainnya',array('disabled' => true, 'class' =>' span3')); ?> 
        </div>
    </div>
</div>