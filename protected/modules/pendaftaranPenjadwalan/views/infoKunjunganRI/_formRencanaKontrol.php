<style>
    select[disabled],textarea[disabled]{
        background:#eeeeee;
    }
</style>
<div class="panel panel-success ">
    <div class="panel-heading">
        <div class="panel-title">
            <?php echo CHtml::checkBox('iskontrol', false, array('onClick'=>'cekRenKontrol(this);')) ?>
            Rencana Kontrol
        </div>
    </div>
    <div class="panel-body panel-form-rencanakontrol">
            
            <div class="control-group">
                <?php echo CHtml::label('Tgl. Rencana Pulang<span class="required" id="mandatory"></span>', 'tglrenkontrol', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'rencanapulang_tgl',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,                         
                            'minDate' => 'd+1'
                        ),
                        'htmlOptions' => array(
                          //  'style'=>'width:110px;',                            
                            'readonly' => true, 
                            'class' => 'span3 tglrencanapulang', 
                            'disabled' => true),
                    ));
                    ?>
                </div>
            </div>
        
            <div class="control-group">
                <?php echo CHtml::label('Tgl. Kontrol<span class="required" id="mandatory"></span>', 'tglrenkontrol', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'rencanakontrol_tgl',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,                         
                            'minDate' => 'd+1'
                        ),
                        'htmlOptions' => array(
                        //    'style'=>'width:110px;',                            
                            'readonly' => true, 
                            'class' => 'span3 tglkontrol', 
                            'disabled' => true),
                    ));
                    ?>
                </div>
            </div>
        
            <?php 
                $ruangan = RuanganM::model()->findAllByAttributes(array(
                        'instalasi_id'=>Params::INSTALASI_ID_RJ,
                        'ruangan_aktif'=>true,
                ), array(
                        'order'=>'ruangan_nama',
                ));
            ?>
        
        <div class="control-group">
            <?php echo CHtml::label('Poli Kontrol<span class="required" id="mandatory"></span>','',array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                    echo $form->dropDownList($model, 'polikontrol_id', CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama'), array(
                            'empty'=>'-- Pilih --', 'disabled'=>true,'class'=>'span3 polikontrol'
                    ));
                ?>
            </div>
        </div>
            <?php    
                echo $form->textAreaRow($model,'keterangan',array('class'=>'autogrow'));
            ?>
    </div>    
</div>