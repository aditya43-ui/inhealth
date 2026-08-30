<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'searchLaporan',
    'type' => 'horizontal',
)); 

?>
<div class="row-fluid">
    <div class="col-sm-12">
        <div class="control-group">
            <label class="control-label">Tanggal Awal <span class="required">*</span></label>
            <div class="controls">
                <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_awal',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('readonly'=>true,'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event)",),
                    ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Tanggal Akhir <span class="required">*</span></label>
            <div class="controls">
                <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_akhir',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,                              
                        ),
                        'htmlOptions' => array('readonly'=>true,'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event)",),
                    ));
                ?>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Berdasarkan Tanggal <span class="required">*</span></label>
            <div class="controls">
                <?php
                    echo $form->radioButtonList($model,'berdasarkantgl', LookupM::getItemsUrutan('filtertanggal_kontrolbpjs'));
                ?>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Jenis Surat</label>
            <div class="controls">
                <?php
                    echo $form->radioButtonList($model,'jenissurat', LookupM::getItemsUrutan('jenissurat_bpjs'));
                ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->route),
        array('class' => 'btn btn-danger')
    ); ?>
    <?php
    //                $content = $this->renderPartial('../tips/informasi',array(),true);
    //                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>

<?php $this->endWidget(); ?>