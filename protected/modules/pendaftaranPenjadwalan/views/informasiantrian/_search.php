<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'search',
    'type' => 'horizontal',
    'focus'=>'#'.CHtml::activeId($model,'no_pendaftaran'),
        ));
?>
<style>
    #ruangan label{
    width: 200px;
        display:inline-block;
    }
</style>
<fieldset class="box">
    <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
    <div class="row">
        <div class="col-sm-4">
            <div class="control-group">
                <?php echo $form->labelEx($model, 'tgl_antrian', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_awal',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true,
                                    'class' => 'dtPicker2'),
                    ));
                    ?>
                    <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
                </div>
            </div>
            <div class="control-group">
                <label class='control-label'>Sampai dengan</label>
                <div class="controls">
                    <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_akhir',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 
                                    'class' => 'dtPicker2'),
                    ));
                    ?>
                    <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                </div>
            </div>
            
        </div>
        <div class="col-sm-4">
            <?php echo $form->dropDownListRow($model, 'loket_id', CHtml::listData(LoketM::model()->findAll(array(
                    'condition'=>'loket_aktif = true',
                    'order'=>'loket_singkatan',
            )), 'loket_id', 'namaLoketLengkap'), array('class' => 'span3','empty' => '-- Pilih --')); ?>
            
            <div class="control-group">
                   <?php echo Chtml::label("No. Antrian",'noantrian_loket', array('class'=>'control-label')); ?>
                <div class="controls">
                <?php echo $form->textField($model, 'noantrian_loket', array('class' => 'span3 numbers-only', 'maxlength' => 3,'placeholder'=>'No. Antrian')); ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow($model, 'statusdaftar', array(1=>'BELUM DIDAFTARKAN', 2=>'SUDAH DIDAFTARKAN'), array('class' => 'span3','empty' => '-- Pilih --')); ?>
            
            <div class="control-group">
                    <?php echo Chtml::label("No. Pendaftaran",'no_pendaftaran', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'prefix_pendaftaran', PendaftaranT::model()->getColumn(),array('empty'=>'-- Pilih --','class'=>'numbers-only span1')); ?>
                    <?php echo $form->textField($model, 'no_pendaftaran', array('class' => 'span3 numbers-only', 'maxlength' => 10,'placeholder'=>'No. Pendaftaran')); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('class' => 'span3 numbers-only', 'maxlength' => 10,'placeholder'=>'No. Rekam Medik')); ?>
            <?php echo $form->textFieldRow($model, 'nama_pasien', array('class' => 'span3 hurufs-only', 'maxlength' => 50,'placeholder'=>'Nama Pasien')); ?>
        </div>
        <div class="col-sm-4">
            <?php echo $form->dropDownListRow($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true and instalasi_id in (2,4) ORDER BY instalasi_nama'), 'instalasi_id', 'instalasi_nama'), array('empty'=>'-- Pilih --', 'class' => 'span3', 'ajax' => array('type' => 'POST',
                                                        'url' => $this->createUrl('GetRuanganForCheckBox', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
                                                        'update' => '#PPInformasiantrianpasien_ruangan_id',  //selector to update
                                                    ),)); ?>
            <?php echo $form->dropDownListRow($model, 'ruangan_id', array(), array('empty'=>'-- Pilih --', 'class'=>'span3')); ?>
                        
            <?php 
            $carabayar = CarabayarM::model()->findAll(array(
                'condition'=>'carabayar_aktif = true',
                'order'=>'carabayar_nama ASC',
            ));
            foreach ($carabayar as $idx=>$item) {
                $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                    'carabayar_id'=>$item->carabayar_id,
                    'penjamin_aktif'=>true,
               ));
               if (empty($penjamins)) unset($carabayar[$idx]);
            }
            $penjamin = PenjaminpasienM::model()->findAll(array(
                'condition'=>'penjamin_aktif = true',
                'order'=>'penjamin_nama',
            ));
            echo $form->dropDownListRow($model,'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                'empty'=>'-- Pilih --',
                'class'=>'span3', 
                'ajax' => array('type'=>'POST',
                    'url'=> $this->createUrl('/actionDynamic/getPenjaminPasien',array('encode'=>false,'namaModel'=>get_class($model))), 
                    'success'=>'function(data){$("#'.CHtml::activeId($model, "penjamin_id").'").html(data); }',
                ),
             ));
            echo $form->dropDownListRow($model,'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3'));
            ?>
            
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                    $this->createUrl($this->id.'/index'), 
                                    array('class'=>'btn btn-danger',
                                        'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index').'";} ); return false;')); ?>
        <?php 
        $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasiAntrianPasien',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>          
    </div>
</fieldset>
<?php $this->endWidget(); ?>
<script>
    function checkAll(){
        if($('#checkAllRuangan').is(':checked')){
           $('#search input[name*="ruangan_id"]').each(function(){
                $(this).attr('checked',true);
           });
        }else{
             $('#search input[name*="ruangan_id"]').each(function(){
                $(this).removeAttr('checked');
           });
        }
    } 
</script>

