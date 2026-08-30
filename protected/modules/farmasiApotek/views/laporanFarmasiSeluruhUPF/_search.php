<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'horizontal',
    'id' => 'searchLaporan',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
));
?>
<style>
    table {
        margin-bottom: 0;
    }

    .form-actions {
        padding: 4px;
        margin-top: 10px 125px;
    }

    .nav-tabs>li>a {
        display: block;
        cursor: pointer;
    }

    .nav-tabs>.active a:hover {
        cursor: pointer;
    }
</style>

<div class="row">
    <div class="col-sm-6">
        <?php echo CHtml::hiddenField('type', ''); ?>

        <?php 
        
        $model2 = clone $model;
        $model2->tgl_awal = MyFormatter::formatDateTimeForUser($model2->tgl_awal);
        $model2->tgl_akhir = MyFormatter::formatDateTimeForUser($model2->tgl_akhir);
        
        ?>

        <div class="control-group">
            <?php echo CHtml::label("Tanggal", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model2,
                    'attribute' => 'tgl_awal',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                        //
                    ),
                    'htmlOptions' => array(
                        'class' => 'dtPicker2-5 tanggal', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>

            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Sampai Dengan", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model2,
                    'attribute' => 'tgl_akhir',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                        'onSelect' => 'js:function(dateText){cekPeriode(this, dateText);}'
                    ),
                    'htmlOptions' => array(
                        'class' => 'dtPicker2-5', 'onkeypress' => "return $(this).focusNextInputField(event)", 'id' => 'tanggal_akhir'
                    ),
                )); ?>

            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php // $form->textField($model, 'ruangan_nama', ['readonly' => true]) ?>
        <?php echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif = true order by carabayar_id asc'), 'carabayar_id', 'carabayar_nama'), array(
            'empty'=>'-- Pilih --', 'class' => 'span3'
        )) ?>
        <?php echo $form->dropDownListRow($model, 'pegawai_id', CHtml::listData($model->getPegawaiFarmasi(), 'pegawai_id', 'namaLengkap'),['class' => 'span3 search-dropdown', 'empty' => '-- Pilih --']) ?>

        <?php echo $form->dropDownListRow($model, 'create_ruangan', CHtml::listData(RuanganM::getRuanganByInstalasiNoUrut(Params::INSTALASI_ID_FARMASI), 'ruangan_id', 'ruangan_nama'),['class' => 'span3 search-dropdown', 'empty' => '-- Pilih --']) ?>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari Laporan', 'class' => 'btn btn-danger', 'type' => 'submit', 'ajax' => array(
            'type' => 'GET',
            'url' => array("/" . $this->route),
            'update' => '#tableLaporan',
            'beforeSend' => 'function(){
			$("#tableLaporan").addClass("animation-loading");
		}',
            'complete' => 'function(){
			$("#tableLaporan").removeClass("animation-loading");
		}',
        ))
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
    ?>
</div>


<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print');
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporan');
?>


<?php
$jsx = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#searchLaporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $jsx, CClientScript::POS_HEAD);
?>

<script>
    $(function(){
        var classDrop = jQuery('.search-dropdown');
     
        jQuery(classDrop).multiselect({
                includeSelectAllOption: true,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '182px',
                onDropdownShown: function(even) {
                    setTimeout(function(){
                        $('.search-dropdown').parent().find("input[type='text'].multiselect-search").focus();
                    }, 100);
                },
                enableCaseInsensitiveFiltering: true
        }).hide();

    
    });

</script>