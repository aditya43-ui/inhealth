<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-hdd"></i> Transaksi <b>Penerimaan Pencucian Linen Umum</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Transaksi Penerimaan Cuci Linen Umum' => array('index'),
        );

        ?>
        <?php if (!empty($_GET['sukses'])) {?>
            <?php echo Yii::app()->user->setFlash('success', "Data Penerimaan Linen berhasil disimpan!");
            $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php } ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'cucilinenumum-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);unformatNumbers();'),
            'focus' => '#',
        )); ?>
        <?php echo $form->errorSummary($model); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Penerimaan</b>
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . '_formPenerimaan', array('model' => $model, 'form' => $form, 'format' => $format)); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Data Linen
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial($this->path_view . '_tabelLinen', array('modDetail' => $modDetail)); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php
            $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
            $disableSave = false;
            $disableSave = (!empty($_GET['sukses'])) ? true : (($sukses > 0) ? true : false);
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'disabled' => $disableSave)
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl('index'),
                array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'if(!confirm("' . Yii::t('mds', 'Apakah Anda akan mengulang input data ?') . '")) return false;')
            ); ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')", 'disabled' => $disablePrint)); ?>
            <?php $content = $this->renderPartial($this->path_view . 'tips/transaksi1', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
$buttonMinus = CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'delRow(this); return false;'));
$confimMessage = Yii::t('mds','Do You want to remove?');
$js = <<< JSCRIPT
function renameInput(modelName,attributeName)
{
    var trLength = $('#table-linen tbody tr').length;
    var i = 1;
    $('#table-linen tbody tr').each(function(){
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
    i++;    
    });
}


JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input',$js, CClientScript::POS_HEAD);
?>
<script>
function addRow(obj){
    var buttonMinus = '<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'delRow(this); return false;')) ?>';
    var tr = $('#table-linen tbody tr:first').html();

    $('#table-linen tr:last').after('<tr>'+tr+'</tr>');
    $('#table-linen tr:last td:last').append(buttonMinus);

    renameInput('TerimapencucianlinenumumdetT','namalinen');
    renameInput('TerimapencucianlinenumumdetT','jumlah');
    renameInput('TerimapencucianlinenumumdetT','satuan');
    renameInput('TerimapencucianlinenumumdetT','keterangan');
    $('#table-linen tr:last').find('input').val('');
}

function delRow(obj){
    $(obj).parent().parent().remove();
    renameInput('TerimapencucianlinenumumdetT','namalinen');
    renameInput('TerimapencucianlinenumumdetT','jumlah');
    renameInput('TerimapencucianlinenumumdetT','satuan');
    renameInput('TerimapencucianlinenumumdetT','keterangan');
}
</script>

<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array(), true); ?>