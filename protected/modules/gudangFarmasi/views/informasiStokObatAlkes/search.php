<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'id' => 'informasi-search',
            'type' => 'horizontal',
            'focus' => '#' . CHtml::activeId($model, 'instalasi_id'),
        )); ?>
        <div class="row">
            <div class="col-sm-6">
                <?php if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_FARMASI) : ?>
                    <?php echo $form->dropDownListRow(
                        $model,
                        'instalasi_id',
                        $instalasiAsals,
                        array(
                            'class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($model))),
                                'update' => "#" . CHtml::activeId($model, 'ruangan_id'),
                            )
                        )
                    ); ?>
                    <?php echo $form->dropDownListRow($model, 'ruangan_id', $ruanganAsals, array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php endif; ?>
                <!--<div class="control-group">
                    <?php // echo Chtml::label('Jenis Kelompok', 'jnskelompok',array('class'=>'control-label')) 
                    ?>
                    <div class="controls">
                        <?php // echo $form->dropDownList($model,'jnskelompok', LookupM::getItems('jnskelompok'),array('empty'=>'-- Pilih --','class'=>'span4','onkeyup'=>"return $(this).focusNextInputField(event)")); 
                        ?>
                    </div>
                </div>-->
                <?php echo $form->dropDownListRow(
                    $model,
                    'jenisobatalkes_id',
                    CHtml::listData(JenisobatalkesM::model()->findAll(array(
                        'condition' => 'jenisobatalkes_aktif = true',
                        'order' => 'jenisobatalkes_nama',
                    )), 'jenisobatalkes_id', 'jenisobatalkes_nama'),
                    array('empty' => '-- Pilih --', 'class' => 'span4')
                ); ?>
                <!--<div class="control-group">-->
                <?php // echo $form->dropDownListRow($model,'obatalkes_kategori', ObatAlkesKategori::items(),array('empty'=>'-- Pilih --','class'=>'span4','onkeyup'=>"return $(this).focusNextInputField(event)")); 
                ?>
                <!--</div>-->
                <?php echo $form->dropDownListRow($model, 'obatalkes_golongan', ObatAlkesGolongan::items(), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>

                <div class="control-group">
                    <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeCheckBox($model, 'ceklisminimal', array('id' => 'stokmin')); ?>
                        <label for="stokmin">Obat Alkes yang sudah mencapai Stok Minimal</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'obatalkes_kode', array('class' => 'span4 kode-dtd all-caps', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Kode Obat dan Alkes')); ?>
                <?php echo $form->textFieldRow($model, 'obatalkes_nama', array('class' => 'span4 custom-only all-caps', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Nama Obat dan Alkes')); ?>
                <?php // echo $form->textFieldRow($model,'satuankecil_nama',array('class'=>'span4','onkeyup'=>"return $(this).focusNextInputField(event)")); 
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index'),
                array(
                    'class' => 'btn btn-default',
                    'title' => 'Ulang',
                    //                                      'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('gudangFarmasi.views.tips.informasiStokObatAlkesRJ', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');

$js = <<< JSCRIPT
function print(caraPrint){
        window.open("${urlPrint}/"+$('#informasi-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);

?>