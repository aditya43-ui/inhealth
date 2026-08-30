<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'resephd-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'resephd_nama')
        ));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>

<div class="row-fluid">
    <div class = "col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Nama Paket HD <span class='required'>*</span>", "", array('class' => 'control-label')); ?>
            <div class="controls">
                <?php 
                    $valpaket = "";
                    if(isset($_GET['id'])){
                        $idPaket = ResephdDetM::model()->findByPk($_GET['id']);
                        $valpaket = $idPaket->resephd_id;
                    }
                ?>
                <?= CHtml::dropDownList('resephd_id', $valpaket, CHtml::listData(ResephdM::model()->findAll("resephd_aktif=TRUE"), 'resephd_id', 'resephd_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'empty' => '--Pilih--', 'onchange'=>'setDetailPaket(this)')); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">Nama Obat/Alkes</label>
            <?php echo CHtml::HiddenField('obatalkes_id', '', array('readonly' => true, 'style' => 'width:110px;')); ?>
            <div class="controls">
                <div class="input-append" style='display:inline'>
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
//                        'name' => $model,
                        'name' => 'obatalkes_nama',
                        'source' => 'js: function(request, response) {
                                                    $.ajax({
                                                            url: "' . $this->createUrl('SetObatAlkes') . '",
                                                            dataType: "json",
                                                            data: {
                                                                    term: request.term,
                                                                    obatalkes_id: $("#obatalkes_id").val(),
                                                            },
                                                            success: function (data) {
                                                                    response(data);
                                                            }
                                                    })
                                            }',
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 3,
                            'focus' => 'js:function( event, ui ) {
                                                            $(this).val( ui.item.label);
                                                            return false;
                                                     }',
                            'select' => 'js:function( event, ui ) {
                                                            $("#obatalkes_id").val(ui.item.value); 
                                                            $(this).val(ui.item.label);
                                                            return false;
                                                    }',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogObatAlkes'),
                        'htmlOptions' => array('class' => 'span3'),
                    ));
                    ?>
                </div>                      
            </div>
            <div class="controls">
                <?php
                echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array('onclick' => 'tambahDetailresephd();return false;',
                    'class' => 'btn btn-primary',
                    'id' => 'tomboltambahdetail',
                    'onkeypress' => "tambahDetailresephd();return false;",
                    'rel' => "tooltip",
                    'title' => "Klik untuk menambahkan Detail Paket HD",));
                ?>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="col-sm-12">
        <table class="table table-striped" id="tbl-obatalkes">
            <thead>
                <tr>
                    <th>Kode Obat/Alkes</th>
                    <th>Nama Obat/Alkes</th>
                    <th>Satuan Kecil</th>
                    <th>Harga SAtuan</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($_GET['id'])) : ?>
                    <?php
                        $modResephd = ResephdDetM::model()->findAll('resephd_id = '.$model->resephd_id);
                    ?>
                    <?php foreach ($modResephd as $key => $value) : ?>
                        <?php
                            $obatalkes = ObatalkesM::model()->findByPk($value->obatalkes_id);
                            $satuan = SatuankecilM::model()->findByPk($obatalkes->satuankecil_id);
                            $modResep = ResephdDetM::model()->findByPk($value->resephd_det_id);
                            $modResep->resephd_det_id = $modResep->resephd_det_id;
                            $modResep->obatalkes_id = $value->obatalkes_id;
                            $modResep->resephd_id = $value->resephd_id;
                            $modResep->obatalkes_kode = $obatalkes->obatalkes_kode;
                            $modResep->obatalkes_nama = $obatalkes->obatalkes_nama;
                            $modResep->satuankecil_nama = $satuan->satuankecil_nama;
                            $modResep->harga_satuan = $obatalkes->hargajual;
                        ?>
                        <tr class="tr-obatalkes" baris="<?= $key; ?>">
                            <td>
                                <?= CHtml::activeHiddenField($modResep, '[' . $key . ']resephd_det_id', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => '')); ?>
                                <?= CHtml::activeHiddenField($modResep, '[' . $key . ']obatalkes_id', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => '')); ?>
                                <?= CHtml::activeHiddenField($modResep, '[' . $key . ']resephd_id', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => '')); ?>

                                <?= CHtml::activeTextField($modResep, '[' . $key . ']obatalkes_kode', array('disabled' => true)) ?>
                            </td>
                            <td><?= CHtml::activeTextField($modResep, '[' . $key . ']obatalkes_nama', array('disabled' => true)) ?></td>
                            <td><?= CHtml::activeTextField($modResep, '[' . $key . ']satuankecil_nama', array('disabled' => true)) ?></td>
                            <td><?= CHtml::activeTextField($modResep, '[' . $key . ']harga_satuan', array('disabled' => true)) ?></td>
                            <td>
                                <a href="javascript:void(0)" onclick="hapusBaris(this)"><i class="icon-minus-sign"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</div>
<div class="row-fluid">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('create'), array('class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'));
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Detail Paket HD', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
        <?php $this->widget('UserTips', array('content' => '')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari data Alat Kesehatan ala cak lontong (non racik - therapi obat)  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogObatAlkes',
    'options' => array(
        'title' => 'Data Obat Alkes',
        'autoOpen' => false,
        'position' => ['top', 20],
        'modal' => true,
        'width' => 550,
        'height' => 600,
        'resizable' => false,
    ),
));

$modObat = new ObatalkesM();
$modObat->unsetAttributes();
if (isset($_GET['ObatalkesM'])) {
    $modObat->attributes = $_GET['ObatalkesM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-grid',
    'dataProvider' => $modObat->searchObat(),
    'filter' => $modObat,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObatalkes",
                                    "onClick" => "
                                                $(\"#obatalkes_id\").val(\"$data->obatalkes_id\"); 
                                                $(\"#obatalkes_nama\").val(\"$data->obatalkes_nama\"); 
                                                $(\'#dialogObatAlkes\').dialog(\'close\');
                                                return false;"))',
        ),
        'obatalkes_nama',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<script>
    function tambahDetailresephd(){
        var resephd_id = $('#resephd_id').val();
        var obatalkes_id = $('#obatalkes_id').val();
        var key = $('.tr-obatalkes:last').attr("baris");
        if(key == null){
            var key = 0;
        }
//        console.log(key);return false;
        var keyNew = parseInt(key)+1;
//        console.log(resephd_id);
        if(resephd_id == ''){
//            console.log('Pilih Paket HD dahulu');
            alert('Pilih Paket HD dahulu');
            return false;
        }
        
        if(obatalkes_id == ''){
            alert('Pilih Obat/Alkes dahulu');
            return false;
        }
        
        $.ajax({
            url: "<?= $this->createUrl('setDetailresephd'); ?>",
            dataType: 'json',
            type: 'post',
            data: {resephd_id: resephd_id, obatalkes_id: obatalkes_id, key: keyNew},
            success: function(data){
                $('#tbl-obatalkes > tbody').append(data.form);
                clearForm();
//                $('#tbl-obatalkes > tbody').append(data.form);
            }
        })
    }
    function hapusBaris(obj){
//        console.log("ok");return false;
        $(obj).parents("tr").detach();
    }
    
    function clearForm(){
//        $('#resephd_id').val('');
        $('#obatalkes_id').val('');
        $('#obatalkes_nama').val('');
    }
    
    function setDetailPaket(obj){
//        console.log(obj.value);
        $('#tbl-obatalkes > tbody').html('');
        $.ajax({
            url: "<?= $this->createUrl('setDetailPaket'); ?>",
            dataType: 'json',
            type: 'post',
            data: {paket_id: obj.value},
            success: function(data){
                $('#tbl-obatalkes > tbody:last').append(data.form);
                clearForm();
//                $('#tbl-obatalkes > tbody').append(data.form);
            }
        })
    }
</script>
