<div class="row" style="margin-top: 20px; margin-bottom: 20px;">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading" style="display: flex;">
                <div class="panel-title">
                    <i></i> Kondisi Pasien Saat Diterima
                </div>
            </div>
            <div class="panel-body">
                <div class="row-fluid" style="border-bottom: 1px solid black">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <label class="control-label">Tanggal Diterima</label>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modelTransfer,
                                    'attribute' => 'tgl_diterima',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                        'onClose' => 'js:function(){hitungPerawatan()}',
                                        'sideBySide' => true,
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2-5 tgl_diterima span4', 'style' => 'width:150px;'),
                                ));
                                ?>
                                <?php echo $form->error($modelTransfer, 'tgl_diterima'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <label class="control-label">Petugas Penerima</label>
                            <div class="controls">
                                <?php
                                    echo $form->hiddenField($modelTransfer, 'petugaspenerima_id',['class'=>'petugaspenerima_id']);
                                    $this->widget('MyJuiAutoComplete', array(
                                        'model'=>$modelTransfer,
                                        'attribute' => 'petugaspenerima_nama',
                                        'source' => 'js: function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('/actionAutoComplete/dropPetugasRuangan') . '",
                                            dataType: "json",
                                            data: {
                                                term: request.term,
                                                ruangan_id: '.Yii::app()->user->getState('ruangan_id').'
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
                                                $(this).val("");
                                                return false;
                                            }',
                                            'select' => 'js:function( event, ui ) {
                                                $(".petugaspenerima_id").val(ui.item.pegawai_id);
                                                $(".petugaspenerima_nama").val(ui.item.namaLengkap);                                
                                                return false;
                                            }',
                                        ),
                                        'htmlOptions' => array(
                                            'onkeyup' => "return $(this).focusNextInputField(event)",
                                            'class'=>'petugaspenerima_nama span4',
                                        ),
                                        'tombolDialog' => array('idDialog' => 'dialogPendamping1'),
                                    ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid" style="border-bottom: 1px solid black">
                    <h4><b>KONDISI PASIEN SAAT DITERIMA</b></h4>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <label class="control-label">Diagnosa</label>
                            <div class="controls">
                                <?php 
                                    echo $form->textArea($modelTransfer,'diagnosa',array('readonly' => true, 'rows'=>4, 'class'=>'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => false)); 
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Anamnesa</label>
                            <div class="controls">
                                <?php 
                                    echo $form->textArea($modelTransfer,'diterima_anamnesa',array('rows'=>4, 'class'=>'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => false)); 
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Kesadaran</label>
                            <div class="controls">
                                <?php echo CHtml::activeRadioButtonList($modelTransfer, 'diterima_kesadaran', array('Compos Mentis' => 'Compos Mentis', 'Delirium' => 'Delirium', 'Somnolen' => 'Somnolen', 'Apatis' => 'Apatis', 'Sopor' => 'Sopor', 'Koma' => 'Koma'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '<br>')); ?>       
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <label class="control-label">Tekanan Darah</label>
                            <div class="controls">
                                <?php echo $form->textField($modelTransfer, 'diterima_sistolik',['class'=>'span2 integer']) ?> / <?php echo $form->textField($modelTransfer, 'diterima_diastolik',['class'=>'span2 integer']) ?> mmHg
                            </div>
                        </div>   
                        <div class="control-group">
                            <label class="control-label">Pernafasan</label>
                            <div class="controls">
                                <?php echo $form->textField($modelTransfer, 'diterima_pernapasan',['class'=>'span4 integer']) ?> x/mnt
                            </div>
                        </div>   
                        <div class="control-group">
                            <label class="control-label">Nadi</label>
                            <div class="controls">
                                <?php echo $form->textField($modelTransfer, 'diterima_nadi',['class'=>'span4 integer']) ?> x/mnt
                            </div>
                        </div>   
                        <div class="control-group">
                            <label class="control-label">Suhu</label>
                            <div class="controls">
                                <?php echo $form->textField($modelTransfer, 'diterima_suhu',['class'=>'span4 float']) ?> &#176;C
                            </div>
                        </div>   
                        <div class="control-group ">
                            <label class="control-label">GCS</label>
                            <div class="controls">
                                <label>E</label>
                                <?php
                                $crit = new CDbCriteria();
                                $crit->compare('LOWER(metodegcs_singkatan)', "e");
                                $crit->addCondition('metodegcs_nilai is not null');
                                $crit->order = 'metodegcs_nilai ASC';
                                echo $form->dropDownList($modelTransfer, 'diterima_gcs_eye', CHtml::listData(MetodegcsM::model()->findAll($crit), 'metodegcs_nilai', 'textMetodeGCSM'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => ''));
                                ?> 
                            </div>
                        </div> 
                        <div class="control-group ">
                            <label class="control-label"></label>
                            <div class="controls">
                                <label>V</label>
                                <?php
                                $crit3 = new CDbCriteria();
                                $crit3->compare('LOWER(metodegcs_singkatan)', "v");
                                $crit3->addCondition('metodegcs_nilai is not null');
                                $crit3->order = 'metodegcs_nilai ASC';
                                echo $form->dropDownList($modelTransfer, 'diterima_gcs_verbal', CHtml::listData(MetodegcsM::model()->findAll($crit3), 'metodegcs_nilai', 'textMetodeGCSM'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => ''));
                                ?>
                            </div>
                        </div> 
                        <div class="control-group ">
                            <label class="control-label"></label>
                            <div class="controls">
                                <label>M</label>
                                <?php
                                $crit2 = new CDbCriteria();
                                $crit2->compare('LOWER(metodegcs_singkatan)', "m");
                                $crit2->addCondition('metodegcs_nilai is not null');
                                $crit2->order = 'metodegcs_nilai ASC';
                                echo $form->dropDownList($modelTransfer, 'diterima_gcs_motorik', CHtml::listData(MetodegcsM::model()->findAll($crit2), 'metodegcs_nilai', 'textMetodeGCSM'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => ''));
                                ?>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="row-fluid" style="border-bottom: 1px solid black">
                    <div class="col-sm-6">
                        <div class="control-group ">
                            <label class="control-label">Berkas yang diberikan</label>
                            <div class="controls">
                                <?php echo $form->checkBox($modelTransfer, 'is_berkasfotorontgen', array('onkeypress' => "return $(this).focusNextInputField(event);")) . ' <label>Foto Rontgen</label>'; ?>
                                <br>
                                <?php echo $form->checkBox($modelTransfer, 'is_berkasusg', array('onkeypress' => "return $(this).focusNextInputField(event);")) . ' <label>USG</label>'; ?>
                                <br>
                                <?php echo $form->checkBox($modelTransfer, 'is_berkashasillab', array('onkeypress' => "return $(this).focusNextInputField(event);")) . ' <label>Hasil Laboratorium</label>'; ?>
                                <br>
                                <?php echo $form->checkBox($modelTransfer, 'is_lain', array('id' => 'is_lain', 'onclick' => 'cekLain()', 'onkeypress' => "return $(this).focusNextInputField(event);")) . ' <label>Lain-lain</label>'; ?>
                                <?php
                                    echo $form->textField($modelTransfer, 'berkaslainlain', array('disabled' => true, 'class' => 'span3 berkaslainlain', 'onkeypress' => 'return $(this).focusNextInputField(event);'));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group ">
                            <label class="control-label">Alat bantu yang terpasang</label>
                            <div class="controls">
                                <?php echo $form->checkBox($modelTransfer, 'is_alatbantuinfus', array('onkeypress' => "return $(this).focusNextInputField(event);")) . ' <label>Infus/Transfusi Darah</label>'; ?>
                                <br>
                                <?php echo $form->checkBox($modelTransfer, 'is_alatbantukateter', array('onkeypress' => "return $(this).focusNextInputField(event);")) . ' <label>Kateter Urine</label>'; ?>
                                <br>
                                <?php echo $form->checkBox($modelTransfer, 'is_alatbantungt', array('onkeypress' => "return $(this).focusNextInputField(event);")) . ' <label>NGT</label>'; ?>
                                <br>
                                <?php echo $form->checkBox($modelTransfer, 'is_alatbantudrain', array('onkeypress' => "return $(this).focusNextInputField(event);")) . ' <label>Drain</label>'; ?>
                                <br>
                                <?php echo $form->checkBox($modelTransfer, 'is_alatbantuoksigen', array('id' => 'is_alatbantuoksigen', 'onclick' => 'cekOksigen()', 'onkeypress' => "return $(this).focusNextInputField(event);")) . ' <label>Oksigen</label>'; ?>
                                <?php
                                    echo $form->textField($modelTransfer, 'alatbantuoksigen_ket', array('disabled' => true, 'class' => 'span3 alatbantuoksigen_ket', 'onkeypress' => 'return $(this).focusNextInputField(event);'));
                                ?>
                                <br>
                                <?php echo $form->checkBox($modelTransfer, 'is_lain2', array('id' => 'is_lain2', 'onclick' => 'cekLain2()', 'onkeypress' => "return $(this).focusNextInputField(event);")) . ' <label>Lain-lain</label>'; ?>
                                <?php
                                    echo $form->textField($modelTransfer, 'alabantulainlain', array('disabled' => true, 'class' => 'span3 alabantulainlain', 'onkeypress' => 'return $(this).focusNextInputField(event);'));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="col-sm-12">
                        <div class="control-group ">
                            <label class="control-label">Pemeriksaan Penunjang/ Diagnostik Terpenting</label>
                            <div class="controls">
                                <?php
                                    $this->widget('ext.redactorjs.Redactor', array(
                                        'model' => $modelTransfer,
                                        'attribute' => 'pemeriksaandiagnostik',
                                        'toolbar' => 'mini',
                                        'height' => '150px',
                                        'width' => '500px',
                                    )); 
                                ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <label class="control-label">Tindakan Terapeutik yang sudah dilakukan</label>
                            <div class="controls">
                                <?php
                                    $this->widget('ext.redactorjs.Redactor', array(
                                        'model' => $modelTransfer,
                                        'attribute' => 'tndakanterapeutik',
                                        'toolbar' => 'mini',
                                        'height' => '150px',
                                        'width' => '500px',
                                    )); 
                                ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <label class="control-label">Rencana tindakan yang akan dilakukan</label>
                            <div class="controls">
                                <?php
                                    $this->widget('ext.redactorjs.Redactor', array(
                                        'model' => $modelTransfer,
                                        'attribute' => 'rencanatindakan',
                                        'toolbar' => 'mini',
                                        'height' => '150px',
                                        'width' => '500px',
                                    )); 
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>