<style type="text/css">
    .ui-corner-all.ui-icon.ui-icon-plus,.ui-corner-all.ui-icon.ui-icon-minus{
        margin-right:10px;
    }
</style>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sagolongan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'rakstemcell_nama'),
));

$cs = Yii::app()->clientScript;
$cs->scriptMap = array(
    'bootstrap-multiselect.js' => false,
);
?>
<div class="row-fluid">
    <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <div class="control-group ">
            <label class="control-label">Nama Loket<span class="required">*</span></label>
            <div class="controls">
                <?php  
                    if (empty($model->loketpendaftaranpoli_id)){
                        echo $form->dropDownList($model, 'loket_id', LoketM::arrLoketId(),['empty'=>'-- Pilih --','onchange'=>'loadPoliklinik();','class'=>'required loket_id']);
                    }else{
                        echo $form->textField($model, 'loket_nama',['readonly'=>true]);
                        echo $form->hiddenField($model, 'loket_id',[]);
                    }
                            
                ?>
            </div>
        </div>	
        <div class="control-group">
            <label class="control-label">Poli klinik<span class="required">*</span></label>
            <div class="controls">

                <?php
                $arrRuangan = array();
                if (!empty($model->loket_id)){
                    foreach (LoketpendaftaranpoliM::model()->findAll(" loket_id = ".$model->loket_id) as $key => $val) {
                        $arrRuangan[] = $val->ruangan_id;
                    }
                }
                
                $this->widget(
                    'application.extensions.emultiselect.EMultiSelect',
                    array('sortable' => true, 'searchable' => true)
                );
                echo CHtml::dropDownList(
                    'ruangan_id[]',
                    $arrRuangan,
                    RuanganM::arrRuanganId(Params::INSTALASI_ID_RJ),
                    array('multiple' => 'multiple', 'key' => 'ruangan_id', 'class' => 'multiselect ruangan_id', 'style' => 'width:500px;height:150px')
                );
                ?>

            </div>
        </div>
        
        
    </div>    
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit',));
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), '', array('class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    ?>
    <?php echo $this->renderPartial($this->path_view . '_buttonPengaturan', ['model' => $model], true); ?>
    <?php
    $tips = array(
        '0' => 'simpan',
        '1' => 'ulang',
    );
    $content = $this->renderPartial($this->path_tips . 'detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
    ?>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    const loadPoliklinik = () => {
        var loket_id = $(".loket_id").val();
               
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('loadPoliklinik'); ?>',
            data: {
                loket_id
            },
            dataType: "json",
            success: function (data) {
                $(".ruangan_id").html(data.ruangan);

                $(".ruangan_id").multiselect('destroy');       
                $(".ruangan_id").multiselect();    
                                  
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });     
    }
       
</script>
