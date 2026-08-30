<div class="panel panel-gradient">  
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Tarif Hemodialisa</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'formCari',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#',
            'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
        )); ?>
        <?php $this->endWidget(); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <?php
            // ===========================Dialog Details Tarif=========================================
            $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id' => 'dialogDetailsTarif',
                // additional javascript options for the dialog plugin
                'options' => array(
                    'title' => 'Komponen Tarif',
                    'autoOpen' => false,
                    'width' => 350,
                    'height' => 350,
                    'resizable' => false,
                    'scroll' => false
                ),
            ));
            ?>
            <iframe src="" name="iframe" width="100%" height="100%">
            </iframe>
            <?php
            $this->endWidget('zii.widgets.jui.CJuiDialog');
            //===============================Akhir Dialog Details Tarif================================
            Yii::app()->clientScript->registerScript('search', "
        $('form#formCari').submit(function(){
                $.fn.yiiGridView.update('daftarTindakan-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ", CClientScript::POS_READY);
            ?>
            <div class="panel-body">
                <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'formCari',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'focus' => '#' . CHtml::activeId($modTarifTindakanRuanganV, 'daftartindakan_nama'),
                    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
                )); ?>
                <?php $this->endWidget(); ?>
                <div class="row">
                    <div class="col-sm-6">
                        <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'jenistarif_id', CHtml::listData(JenistarifM::model()->findAllByAttributes(array('jenistarif_aktif' => true)), 'jenistarif_id', 'jenistarif_nama'), array('class' => 'span4')); ?>
                        <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'kategoritindakan_id', CHtml::listData($modTarifTindakanRuanganV->getKategoritindakanItems(), 'kategoritindakan_id', 'kategoritindakan_nama'), array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'kelaspelayanan_id', CHtml::listData($modTarifTindakanRuanganV->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                        <?php echo $form->textFieldRow($modTarifTindakanRuanganV, 'daftartindakan_nama', array('onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30, 'placeholder' => 'Uraian Tindakan', 'class' => 'span4',)); ?>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array(
                            'title' => 'Cari',
                            'class' => 'btn btn-danger',
                            'type' => 'submit',
                            'ajax' => array(
                                'type' => 'GET',
                                'url' => array("/" . $this->route),
                                'update' => '#daftarTindakan-grid',
                                'beforeSend' => 'function(){
                                              $("#daftarTindakan-grid").addClass("animation-loading");
                                          }',
                         'complete' => 'function(){
                                              $("#daftarTindakan-grid").removeClass("animation-loading");
                                          }',
                     ))); 
             ?>
                  <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                    Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                                    array('class'=>'btn btn-danger',
                                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                 <?php 
                   $content = $this->renderPartial('../tips/informasi',array(),true);
                                $this->widget('UserTips',array('type'=>'admin','content'=>$content));
                ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Tarif Hemodialisa</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php echo $this->renderPartial('_tableTarif', array('modTarifTindakanRuanganV' => $modTarifTindakanRuanganV)); ?>
            </div>
        </div>
    </div>
</div> 
</div>
