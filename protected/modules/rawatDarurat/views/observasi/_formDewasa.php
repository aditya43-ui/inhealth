<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><strong>Tabel Riwayat Observasi Pasien Dewasa</strong></div>
    </div>
    <div class="panel-body" >
        <?php $this->renderPartial($this->path_view.'_riwayatTableDewasa',array('model'=>$model,'modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien)); ?>
        <div>
            <?php $this->renderPartial($this->path_view.'_tombolPrinoutDewasa',array('modPendaftaran'=>$modPendaftaran)); ?>
        </div>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><strong>Data Hasil Observasi Pasien Dewasa</strong></div>
    </div>
    <div class="panel-body" >
        <div class="row">
            <div class="col-md-6">
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model,'tgl_observasi', array('class'=>'control-label','required'=>true)) ?>
                    <div class="controls">
                        <?php   
                            $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'tgl_observasi_dewasa',
                            'mode'=>'date',
                            'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                            ),
                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker2-5','style'=>'width:150px;'),
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo  CHtml::activeLabel($model,'jam_observasi', array('class'=>'control-label','required'=>true)) ?>
                    <div class="controls">
                        <?php 
                        $this->widget('MyDateTimePicker',array(		                                        
                          'model'=>$model,	
                            'attribute'=>'jam_observasi_dewasa',
                              'mode'=>'time',
                              'options'=> array(
                                      'showOn' => false,	
                              ),
                              'htmlOptions'=>array(
                          'readonly'=>TRUE,
                          'class'=>'span2',
                          'placeholder'=>'00:00:00',
                          'onkeyup'=>"return $(this).focusNextInputField(event),",
                              ),
                            ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo  CHtml::activeLabel($model,'petugas_id', array('class'=>'control-label','required'=>true)) ?>
                    <div class="controls">
                        <?php echo CHtml::activeDropDownList($model,'petugas_id',CHtml::listData(PegawairuanganV::model()->findAll('ruangan_id = '.Yii::app()->user->getState("ruangan_id")), 'pegawai_id', 'NamaLengkap'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);",'id' =>'petugas'));?>
                    </div>
                </div>
                <div class="control-group">
                    <?php  echo CHtml::label('Tekanan Darah', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'td_sistolic', array('class' => 'span1 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> / 
                        <?php echo CHtml::activeTextField($model, 'td_diastolic', array('class' => 'span1 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> mmHg
                    </div>
                </div>
                <div class="control-group ">
                    <?php  echo CHtml::label('Nadi', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'detaknadi', array('class' => 'span1 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> x/menit 
                    </div>
                </div>
                <div class="control-group ">
                    <?php  echo CHtml::label('Suhu', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'suhutubuh', array('class' => 'span1 float2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> &#176 Celcius
                    </div>
                </div>
                <div class="control-group ">
                    <?php  echo CHtml::label('Pernapasan', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'pernapasan', array('class' => 'span1 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> x/menit 
                    </div>
                </div>
                <div class="control-group ">
                    <?php  echo CHtml::label('Saturasi Oksigen (SpO2)', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'spo2_nilai', array('class' => 'span1 float2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> %
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="control-group ">
                    <?php  echo CHtml::label('Jenis Cairan', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'cairan_jenis', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'maxlength'=>300)); ?> 
                    </div>
                </div>
                <div class="control-group ">
                    <?php  echo CHtml::label('Jumlah Tetesan', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'jml_tetesan', array('class' => 'span2 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> 
                    </div>
                </div>
                <div class="control-group ">
                    <?php  echo CHtml::label('Kolf', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'kolf', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);",'maxlength'=>50)); ?> 
                    </div>
                </div>
                <div class="control-group ">
                    <?php  echo CHtml::label('Jumlah Urine', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'jml_urine', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);",'maxlength'=>100)); ?> 
                    </div>
                </div>
                <div class="control-group ">
                    <?php  echo CHtml::label('Bunyi Jantung Anak (BJA)', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'bunyijantung_anak', array('class' => 'span2 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);",'maxlength'=>100)); ?> 
                    </div>
                </div>
                <div class="control-group ">
                    <?php  echo CHtml::label('Catatan', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextArea($model, 'catatan', array('class' => 'span3')); ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="form-actions">
            <?php $disabledSimpan = (isset($_GET['sukses'])?true:false) ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                       array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan','disabled'=>$disabledSimpan)); ?>

            <?php 
            echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    $this->createUrl($this->id.'/index',array('pendaftaran_id'=>$_GET['pendaftaran_id'],'pasienadmisi_id'=>(!empty($_GET['pasienadmisi_id']) ? $_GET['pasienadmisi_id'] : ""), 'observasipasienri_id'=>(isset($_GET['observasipasienri_id'])?$_GET['observasipasienri_id']:null),'type'=>(!empty($_GET['type'])?$_GET['type']:""),'frame'=>(!empty($_GET['frame'])?$_GET['frame']:""))), 
                                    array('class'=>'btn btn-danger',
                                        'onclick'=>'return refreshForm(this);'));
           ?>
        </div> 
    </div>
</div>

<script>
    $(document).ready(function() {
        var petugas = jQuery('#petugas');
        jQuery(petugas).multiselect({
            includeSelectAllOption: false,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();
    });
</script>

            


