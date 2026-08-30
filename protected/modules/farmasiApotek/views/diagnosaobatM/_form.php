<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjkasuspenyakitdiagnosa-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#diagnosa',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
)); ?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <div class="col-sm-6">
        <?php
        if (isset($modDetails)) {
            echo $form->errorSummary($modDetails);
        } else {
            echo $form->errorSummary($model);
        }
        ?>
        <div class="control-group">
            <?php
            if (isset($_GET['id'])) {
                $diagnosa_id = $_GET['id'];
                $data = DiagnosaM::model()->findByPK($diagnosa_id);
            } else {
                $diagnosa_id = null;
                $data = null;
            }
            // if (isset($_GET['id'])) {
            //     $diagnosa_id = $_GET['id'];
            //     $data = DiagnosaM::model()->findByPK($diagnosa_id);
            //     $edit = true;
            // } else {
            //     $edit = false;
            // }
            ?>
            <?php echo CHtml::label('Diagnosa', '', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('diagnosa_id', $diagnosa_id, array('readonly' => true)) ?>
                <?php $this->widget('MyJuiAutoComplete', array(
                    'name' => 'diagnosa',
                    'value' => (isset($_GET['id']) ? $data->diagnosa_nama : null),
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . Yii::app()->createUrl('ActionAutoComplete/Diagnosa') . '",
                            dataType: "json",
                            data: {
                                term: request.term,
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ){
                            $(this).val(ui.item.label);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            $(\'#diagnosa_id\').val(ui.item.value);
                            $(\'#diagnosa\').val(ui.item.label);
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        //'readonly'=>$edit,
                        'placeholder' => 'Diagnosa',
                        'size' => 13,
                        'class' => 'span3',
                        'onkeypress' => "return $(this).focusNextInputField(event);",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogDiagnosa' . (isset($edit) ? $edit : ""),),
                )); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Obat Alkes', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('obatalkes_id', '', array('readonly' => true)) ?>
                <?php $this->widget('MyJuiAutoComplete', array(
                    'name' => 'obatalkes',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . Yii::app()->createUrl('ActionAutoComplete/ObatAlkes') . '",
                            dataType: "json",
                            data: {
                                term: request.term,
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                            $(this).val(ui.item.label);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            $(\'#obatalkes_id\').val(ui.item.value);
                            $(\'#obatalkes\').val("");
                            submitDiagnosaobat();
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'readonly' => false,
                        'placeholder' => 'Obat Alkes',
                        'size' => 13,
                        'class' => 'span3',
                        'onkeypress' => "return $(this).focusNextInputField(event);",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogObatalkes'),
                )); ?>
            </div>
        </div>
    </div>
</div>

<table id="tabelDiagnosaobat" class="table table-striped table-bordered table-condensed table-responsive table-striped table-condensed">
    <thead>
        <tr>
            <th>Kode Diagnosa</th>
            <th>Diagnosa</th>
            <th>Obat Alkes</th>
            <th><?php if (isset($_GET['id'])) {
                    $status = 'Hapus';
                } else {
                    $status = 'Batal';
                }
                echo $status ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $modDiagnosaobat = DiagnosaobatM::model()->findAllByAttributes(array('diagnosa_id' => $diagnosa_id));
        foreach ($modDiagnosaobat as $value) {
            $hapus = Yii::app()->createUrl('farmasiApotek/diagnosaobatM/Delete', array('id' => "$value->diagnosa_id", 'obatalkes' => "$value->obatalkes_id"));
            $tr = '<tr>';
            $tr .= '<td>' . $value->diagnosa->diagnosa_kode . '</td>';
            $tr .= '<td>' . $value->diagnosa->diagnosa_nama . '</td>';
            $tr .= '<td>' . $value->obatalkes->obatalkes_nama . '&nbsp;' . '</td>';
            $tr .= '<td>' . CHtml::link("<i class='icon-form-sampah'></i>", $hapus) . '</td>';
            $tr .= '</tr>';
            echo $tr;
        }
        ?>
        <?php
        if (count((array)$modDetails) > 0) {
            foreach ($modDetails as $i => $row) {
                $moddiagnosa = DiagnosaM::model()->findByPK($row->diagnosa_id);
                $modobatalkes = ObatalkesM::model()->findByPK($row->obatalkes_id);
                $tr = "<tr>";
                $tr .= "<td>"
                    . $moddiagnosa->diagnosa_kode
                    . CHtml::activehiddenField($model, '[]diagnosa_id', array('readonly' => true, 'value' => $row->diagnosa_id, 'class' => 'diagnosa'))
                    . CHtml::activehiddenField($model, '[]obatalkes_id', array('readonly' => true, 'value' => $row->obatalkes_id))
                    . "</td>";
                $tr .= "<td>" . $moddiagnosa->diagnosa_nama . "</td>";
                $tr .= "<td>" . $modobatalkes->obatalkes_nama . "</td>";
                $tr .= "<td>" . CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick' => 'remove(this);')) . "</td>";
                $tr .= "</tr>";
                echo $tr;
            }
        }
        ?>
    </tbody>
</table>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'onKeypress' => 'return formSubmit(this,event)')
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/diagnosaobatM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Diagnosa Obat', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('diagnosaobatM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    );
    ?>
    <?php
    $content = $this->renderPartial('farmasiApotek.views.tips.tipsaddedit3', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>

<!--============================== Widget Dialog Diagnosa ====================================-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDiagnosa',
    'options' => array(
        'title' => 'Pencarian Diagnosa',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modDiagnosa = new DiagnosaM;
$modDiagnosa->unsetAttributes();
if (isset($_GET['DiagnosaM'])) {
    $modDiagnosa->attributes = $_GET['DiagnosaM'];
    $modDiagnosa->diagnosa_namalainnya = $_GET['DiagnosaM']['diagnosa_namalainnya'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'adiagnosa-grid',
    'dataProvider' => $modDiagnosa->search(),
    'filter' => $modDiagnosa,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                array(
                                        "class"=>"btn-small",
                                        "id" => "selectKasuspenyakit",
                                        "onClick" => "\$(\"#diagnosa_id\").val($data->diagnosa_id);
                                                              \$(\"#diagnosa\").val(\"$data->diagnosa_nama\");
                                                              \$(\"#dialogDiagnosa\").dialog(\"close\");"
                                ))',
        ),
        array(
            'header' => 'Kode Diagnosa',
            'name' => 'diagnosa_kode',
            'value' => '$data->diagnosa_kode',
        ),
        array(
            'header' => 'Diagnosa',
            'name' => 'diagnosa_nama',
            'value' => '$data->diagnosa_nama',
        ),
        array(
            'header' => 'Nama Lainnya',
            'name' => 'diagnosa_namalainnya',
            'value' => '$data->diagnosa_namalainnya',
        ),
        array(
            'header' => 'imunisasi',
            'name' => 'diagnosa_imunisasi',
            'type' => 'raw',
            'value' => '($data->diagnosa_imunisasi==1)? Yii::t("mds","Yes") : Yii::t("mds","No")',
            'filter' => CHtml::dropDownList('DiagnosaM[diagnosa_imunisasi]', $modDiagnosa->diagnosa_imunisasi, array('0' => 'Tidak', '1' => 'Ya'), array('empty' => '-- Pilih --'))

        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<!--============================== endWidget Dialog Diagnosa ====================================-->

<!--============================== Widget Dialog ObatAlkes ====================================-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogObatalkes',
    'options' => array(
        'title' => 'Pencarian Obat Alkes',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modObatalkes = new ObatalkesM;
$modObatalkes->unsetAttributes();
if (isset($_GET['ObatalkesM'])) {
    $modObatalkes->attributes = $_GET['ObatalkesM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-grid',
    'dataProvider' => $modObatalkes->searchObatFarmasi(),
    'filter' => $modObatalkes,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                array(
                                        "class"=>"btn-small",
                                        "id" => "selectObatalkes",
                                        "onClick" => "\$(\"#obatalkes_id\").val($data->obatalkes_id);
                                                              \$(\"#obatalkes\").val(\"\");
                                                              \$(\"#dialogObatalkes\").dialog(\"close\");
                                                              submitDiagnosaobat();"
                                ))',
        ),
        array(
            'header' => 'Kode Obat',
            'name' => 'obatalkes_kode',
            'value' => '$data->obatalkes_kode',
        ),
        array(
            'header' => 'Nama Obat',
            'name' => 'obatalkes_nama',
            'value' => '$data->obatalkes_nama',
        ),
        array(
            'header' => 'Jenis',
            'name' => 'jenisobatalkes_id',
            'value' => '(isset($data->jenisobatalkes_id) ? $data->jenisobatalkes->jenisobatalkes_nama : "-")',
            'filter' => CHtml::dropDownList('ObatalkesM[jenisobatalkes_id]', $modObatalkes->jenisobatalkes_id, CHtml::listData(JenisobatalkesM::model()->findAll("jenisobatalkes_aktif = TRUE ORDER BY jenisobatalkes_nama ASC"), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Kategori',
            'name' => 'obatalkes_kategori',
            'value' => '$data->obatalkes_kategori',
            'filter' => CHtml::dropDownList('ObatalkesM[obatalkes_kategori]', $modObatalkes->obatalkes_kategori, LookupM::getItems('obatalkes_kategori'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Golongan',
            'name' => 'obatalkes_golongan',
            'value' => '$data->obatalkes_golongan',
            'filter' => CHtml::dropDownList('ObatalkesM[obatalkes_golongan]', $modObatalkes->obatalkes_golongan, LookupM::getItems('obatalkes_golongan'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<!--============================== endWidget Dialog ObatAlkes ====================================-->
<?php
$urlGetDiagnosaobat = $this->createUrl('Kasuspenyakitdiagnosa');
$jscript = <<< JS
function submitDiagnosaobat()
{
    diagnosa_id = $('#diagnosa_id').val();
    obatalkes_id = $('#obatalkes_id').val();

    if(diagnosa_id == ''){
        myAlert('Silakan pilih diagnosa terlebih dahulu!');
    }else{
        $.post("${urlGetDiagnosaobat}", {diagnosa_id:diagnosa_id, obatalkes_id:obatalkes_id,},
        function(data){
            $('#tabelDiagnosaobat tbody').append(data.tr);
            renameInput();
        }, "json");
    }   
}

function renameInput(){
    nourut = 0;
    $('.diagnosa').each(function(){
        $(this).parents('tr').find('[name*="DiagnosaobatM"]').each(function(){
            var input = $(this).attr('name');
            var data = input.split('DiagnosaobatM[]');
            if (typeof data[1] === 'undefined'){} else{
                $(this).attr('name','FADiagnosaobatM['+nourut+']'+data[1]);
            }
        });
        nourut++;
    });
}

JS;

Yii::app()->clientScript->registerScript('diagnosaobat', $jscript, CClientScript::POS_HEAD);
?>

<script type="text/javascript">
    function hapusBaris(obj) {
        $(obj).parent().parent('tr').detach();
    }
</script>