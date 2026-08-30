<?php echo $form->hiddenField($modPasienMasukPenunjang, 'pasienmasukpenunjang_id', array('readonly' => true, 'class' => 'span3')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang, 'pasienkirimkeunitlain_id', array('readonly' => true, 'class' => 'span3')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang, 'ruangan_id', array('readonly' => true, 'class' => 'span3')); ?>
<div class="control-group">
    <label class="control-label">Tanggal Masuk Penunjang</label>
    <?php $modPasienMasukPenunjang->tglmasukpenunjang = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPasienMasukPenunjang->tglmasukpenunjang, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
    <div class="controls">
        <?php
        $this->widget('MyDateTimePicker', array(
            'model' => $modPasienMasukPenunjang,
            'attribute' => 'tglmasukpenunjang',
            'mode' => 'datetime',
            'options' => array(
                'dateFormat' => Params::DATE_FORMAT,
                'minDate' => 'd',
            ),
            'htmlOptions' => array('readonly' => true, 'class' => ' span3'),
        ));
        ?>
    </div>
</div> 
<?php
$jeniskp = LBPendaftaranT::model()->getJenisKasusPenyakitItems($modPasienMasukPenunjang->ruangan_id);
echo $form->dropDownListRow($modPasienMasukPenunjang, 'jeniskasuspenyakit_id', CHtml::listData($jeniskp, 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'), array('empty' => !empty($jeniskp) ? null : '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3'));
?>
<?php // echo $form->dropDownListRow($modPasienMasukPenunjang,'kelaspelayanan_id', CHtml::listData(LBPendaftaranT::model()->getKelasPelayananItems($modPasienMasukPenunjang->ruangan_id), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('onchange'=>'setChecklistPemeriksaanLab();setTindakanPemeriksaanReset();','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3'));  ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang, 'kelaspelayanan_id'); ?>
<div class="control-group">
    <?php echo CHtml::label('PPDS', '', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $form->hiddenField($modPasienMasukPenunjang, 'ppds_id', array('readonly' => true, 'class' => 'span4 ppds_id'));

        $this->widget('MyJuiAutoComplete', array(
            'model' => $modPasienMasukPenunjang,
            'attribute' => 'ppds_nama',
            'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('/ActionAutoComplete/DropPegDanPPDS') . '",
                            dataType: "json",
                            data: {
                                term: request.term,   
                                ppds:true
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }',
            'options' => array(
                'showAnim' => 'fold',
                'minLength' => 2,
                'focus' => 'js:function( event, ui ) {
                            return false;
                        }',
                'select' => 'js:function( event, ui ) {
                            setPegawai(ui.item,"ppds");
                            return false;
                        }',
            ),
            'htmlOptions' => array(
                'class' => 'span3 ppds_nama',
                'placeholder' => 'Ketik Nama PPDS',
                'onblur' => 'if(this.value==""){$("#' . CHtml::activeId($modPasienMasukPenunjang, 'ppds_id') . '").val("");}'
            ),
            'tombolDialog' => array('idDialog' => 'dialogPPDS', 'jsFunction' => 'setDialog("ppds","dialogPPDS",this);'),
        ));
        ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($modPasienMasukPenunjang, 'pegawai_id', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        //echo $form->dropDownList($modPasienMasukPenunjang,'['.$i.']pegawai_id', !empty($modPasienMasukPenunjang->ruangan_id)? CHtml::listData($model->getDokterItems($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'nama_pegawai') : array() ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); 
        echo $form->hiddenField($modPasienMasukPenunjang, 'pegawai_id', array('readonly' => true, 'class' => 'span4 required pegawai_id'));

        $this->widget('MyJuiAutoComplete', array(
            'model' => $modPasienMasukPenunjang,
            'attribute' => 'pegawai_nama',
            'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('/ActionAutoComplete/DropPetugasRuangan') . '",
                            dataType: "json",
                            data: {
                                term: request.term,   
                                ruangan_id:' . Yii::app()->user->getState('ruangan_id') . ',
                                kelompokpegawai_id:' . Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP . '
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }',
            'options' => array(
                'showAnim' => 'fold',
                'minLength' => 2,
                'focus' => 'js:function( event, ui ) {
                            return false;
                        }',
                'select' => 'js:function( event, ui ) {
                            setPegawai(ui.item,"dpjtm",this);
                            return false;
                        }',
            ),
            'htmlOptions' => array(
                'class' => 'span3 required pegawai_nama',
                'placeholder' => 'Ketik Nama DPJTM',
                'onblur' => 'if(this.value==""){$("#' . CHtml::activeId($modPasienMasukPenunjang, 'pegawai_id') . '").val("");}'
            ),
            'tombolDialog' => array('idDialog' => 'dialogPetugas', 'jsFunction' => 'setDialog("dpjtm","dialogPetugas",this);'),
        ));
        ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Analis', 'ppjp_id', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        //echo $form->dropDownList($modPasienMasukPenunjang,'['.$i.']perawat_id', !empty($modPasienMasukPenunjang->ruangan_id)? CHtml::listData(LBPegawaiM::model()->getTenagaLaboratoriums($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'nama_pegawai') : array() ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); 
        echo $form->hiddenField($modPasienMasukPenunjang, 'ppjp_id', array('readonly' => true, 'class' => 'span4 ppjp_id'));

        $this->widget('MyJuiAutoComplete', array(
            'model' => $modPasienMasukPenunjang,
            'attribute' => 'ppjp_nama',
            'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('/ActionAutoComplete/DropPetugasRuangan') . '",
                            dataType: "json",
                            data: {
                                term: request.term,   
                                ruangan_id:' . Yii::app()->user->getState('ruangan_id') . ',
                                notkelompokpegawai_id:' . Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP . '
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }',
            'options' => array(
                'showAnim' => 'fold',
                'minLength' => 2,
                'focus' => 'js:function( event, ui ) {
                            return false;
                        }',
                'select' => 'js:function( event, ui ) {
                            setPegawai(ui.item,"analis",this);
                            return false;
                        }',
            ),
            'htmlOptions' => array(
                'class' => 'span3 ppjp_nama',
                'placeholder' => 'Ketik Nama Analis',
                'onblur' => 'if(this.value==""){$("#' . CHtml::activeId($modPasienMasukPenunjang, 'ppjp_id') . '").val("");}'
            ),
            'tombolDialog' => array('idDialog' => 'dialogPetugas', 'jsFunction' => 'setDialog("analis","dialogPetugas",this);'),
        ));
        ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label">Tanggal Masuk Penunjang</label>
    <?php $modPasienMasukPenunjang->tglmasukpenunjang = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPasienMasukPenunjang->tglmasukpenunjang, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
    <div class="controls">
        <?php
        $this->widget('MyDateTimePicker', array(
            'model' => $modPasienMasukPenunjang,
            'attribute' => 'tglmasukpenunjang',
            'mode' => 'datetime',
            'options' => array(
                'dateFormat' => Params::DATE_FORMAT,
//							'maxDate' => 'd',
            ),
            'htmlOptions' => array('readonly' => true, 'class' => ' span3'),
        ));
        ?>
    </div>
</div> 
<div class="control-group"> 
    <label class="control-label">No. Masuk Penunjang</label>
    <div class="controls">
        <?php echo $form->textField($modPasienMasukPenunjang, 'no_masukpenunjang', array('readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
    </div>
</div>


