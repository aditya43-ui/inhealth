<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rikasuspenyakitdiagnosa-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#kasuspenyakit',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'return requiredCheck(this);'),
));
?>
<!--<p class="help-block">
<?php
// echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
?>
</p>-->
<?php
if (isset($modDetails)) {
    echo $form->errorSummary($modDetails);
} else {
    echo $form->errorSummary($model);
}
?>
<div class="row">
    <div class="col-sm-6">
        <?php
        $instalasi_id = Yii::app()->user->instalasi_id;
        $modInstalasi = InstalasiM::model()->findByPK($instalasi_id);
        echo CHtml::hiddenField('instalasi_id', $instalasi_id);
        echo $form->textFieldRow($model, 'instalasi_nama', array('value' => $modInstalasi->instalasi_nama, 'readonly' => true, 'class' => 'span3'));
        ?>
        <?php
        $ruanganid = Yii::app()->user->ruangan_id;
        $modruangan = RuanganM::model()->findByPK($ruanganid);
        echo CHtml::hiddenField('ruanganid', $ruanganid, array('readonly' => true));
        echo $form->textFieldRow($model, 'ruangan_nama', array('value' => $modruangan->ruangan_nama, 'readonly' => true, 'class' => 'span3',));
        ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Kasus Penyakit', '', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'jeniskasuspenyakit_id', array('readonly' => true)) ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'kasuspenyakit',
                    'source' => 'js: function(request, response) {
						$.ajax({
							url: "' . $this->createUrl('AutocompleteJenisKasusPenyakit') . '",
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
							$(\'#SAKasuspenyakitdiagnosaM_jeniskasuspenyakit_id\').val(ui.item.value);
							$(\'#kasuspenyakit\').val(ui.item.jeniskasuspenyakit_nama);
							 return false;
						}',
                    ),
                    'htmlOptions' => array(
                        'readonly' => false,
                        'placeholder' => 'Kasus Penyakit',
                        'size' => 13,
                        'onkeypress' => "return $(this).focusNextInputField(event);",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogkasuspenyakit'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Diagnosa', '', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'diagnosa_id', array('readonly' => true)) ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'diagnosa',
                    'source' => 'js: function(request, response) {
						$.ajax({
							url: "' . $this->createUrl('AutocompleteDiagnosa') . '",
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
							$(\'#SAKasuspenyakitdiagnosaM_diagnosa_id\').val(ui.item.value);
							$(\'#diagnosa\').val("");
							submitKasuspenyakitdiagnosa();
							 return false;
						}',
                    ),
                    'htmlOptions' => array(
                        'readonly' => false,
                        'placeholder' => 'Diagnosa',
                        'size' => 13,
                        'onkeypress' => "return $(this).focusNextInputField(event);",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogkasuspenyakitdiagnosa'),
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Kasus Penyakit Diagnosa</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table id="tabelKasuspenyakitdiagnosa" class="table table-responsive table-bordered datatable">
            <thead>
                <tr>
                    <th>Jenis Kasus Penyakit</th>
                    <th>Nama Diagnosa</th>
                    <th>Nama Lain</th>
                    <th>Hapus/<br>Batal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_GET['id'])) {
                    $tr = '';
                    $jenispenyakit_id = $_GET['id'];
                    $modKasuspenyakitdiagnosa = SAKasuspenyakitdiagnosaM::model()->findAllByAttributes(array('jeniskasuspenyakit_id' => $jenispenyakit_id));
                    foreach ($modKasuspenyakitdiagnosa as $value) {
                        $hapus = $this->createUrl('delete', array('jeniskasuspenyakit_id' => "$value->jeniskasuspenyakit_id", 'diagnosa_id' => "$value->diagnosa_id"));
                        $tr .= '<tr>';
                        $tr .= '<td>' . $value->jeniskasuspenyakit->jeniskasuspenyakit_nama . '</td>';
                        $tr .= '<td>' . $value->diagnosa->diagnosa_nama . '</td>';
                        $tr .= '<td>' . $value->diagnosa->diagnosa_namalainnya . '&nbsp;' . '</td>';
                        $tr .= '<td>' . CHtml::link("<i class='icon-form-sampah'></i>", $hapus) . '</td>';
                        $tr .= '</tr>';
                    }
                    echo $tr;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Kasus Penyakit Diagnosa', array('{icon}' => '<i class="entypo-folder"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    );
    ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips/tipsCreateUpdate', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<!--============================== Widget Dialog Jenis Kasus Penyakit ===============================-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogkasuspenyakit',
    'options' => array(
        'title' => 'Pencarian Kasus Penyakit',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modJeniskasuspenyakit = new JeniskasuspenyakitM;
$modJeniskasuspenyakit->unsetAttributes();
if (isset($_GET['JeniskasuspenyakitM'])) {
    $modJeniskasuspenyakit->attributes = $_GET['JeniskasuspenyakitM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'jeniskasuspenyakit-grid',
    'dataProvider' => $modJeniskasuspenyakit->search(),
    'filter' => $modJeniskasuspenyakit,
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
                                        "onClick" => "\$(\"#SAKasuspenyakitdiagnosaM_jeniskasuspenyakit_id\").val($data->jeniskasuspenyakit_id);
                                                              \$(\"#kasuspenyakit\").val(\"$data->jeniskasuspenyakit_nama\");
                                                              \$(\"#dialogkasuspenyakit\").dialog(\"close\");"
                                ))',
        ),
        array(
            'name' => 'jeniskasuspenyakit_nama',
            'header' => 'Nama Kasus',
            'value' => '$data->jeniskasuspenyakit_nama',
        ),
        array(
            'name' => 'jeniskasuspenyakit_namalainnya',
            'header' => 'Nama Lainnya',
            'value' => '$data->jeniskasuspenyakit_namalainnya',
        ),/*
            array(
                'header' => 'Urutan',
                'value' => '$data->jeniskasuspenyakit_urutan',
            ),*/
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<!--======================== endWidget dialogkasuspenyakit =====================================-->

<!--============================== Widget Dialog Diagnosa ====================================-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogkasuspenyakitdiagnosa',
    'options' => array(
        'title' => 'Pencarian Diagnosa',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modDiagnosa = new DiagnosaV;
$modDiagnosa->unsetAttributes();
if (isset($_GET['DiagnosaV'])) {
    $modDiagnosa->attributes = $_GET['DiagnosaV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'diagnosa-grid',
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
                                        "onClick" => "\$(\"#SAKasuspenyakitdiagnosaM_diagnosa_id\").val($data->diagnosa_id);
                                                              \$(\"#diagnosa\").val(\"\");
                                                              \$(\"#dialogkasuspenyakitdiagnosa\").dialog(\"close\");
                                                              submitKasuspenyakitdiagnosa();"
                                ))',
        ),
        array(
            'header' => 'Tabular List',
            'name' => 'tabularlist_chapter',
        ),
        array(
            'header' => 'DTD',
            'name' => 'dtd_kode',
            'value' => '$data->dtd_kode',
        ),
        array(
            'header' => 'Kode Klasifikasi',
            'name' => 'klasifikasidiagnosa_kode',
            'value' => '$data->klasifikasidiagnosa_kode',
        ),
        array(
            'header' => 'Nama Klasifikasi',
            'name' => 'klasifikasidiagnosa_nama',
            'value' => '$data->klasifikasidiagnosa_nama',
        ),
        array(
            'header' => 'Diagnosa Kode',
            'name' => 'diagnosa_kode',
            'value' => '$data->diagnosa_kode',
        ),
        array(
            'header' => 'Nama Diagnosa',
            'name' => 'diagnosa_nama',
            'value' => '$data->diagnosa_nama',
        ),
        array(
            'header' => 'Nama Lain',
            'name' => 'diagnosa_namalainnya',
            'value' => '$data->diagnosa_namalainnya',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<!--======================== endWidget dialogkasuspenyakit =====================================-->
<?php
$urlGetKasuspenyakitdiagnosa = $this->createUrl('GetKasusPenyakitDiagnosa');
?>

<?php
$jscript = <<< JS
function submitKasuspenyakitdiagnosa()
{
    jeniskasuspenyakit_id = $('#SAKasuspenyakitdiagnosaM_jeniskasuspenyakit_id').val();
    diagnosa_id = $('#SAKasuspenyakitdiagnosaM_diagnosa_id').val();

    if(jeniskasuspenyakit_id==''){
        myAlert('Silakan pilih jenis kasus penyakit terlebih dahulu!');
    }else{
        $.post("${urlGetKasuspenyakitdiagnosa}", {jeniskasuspenyakit_id:jeniskasuspenyakit_id, diagnosa_id: diagnosa_id,},
        function(data){
            $('#tabelKasuspenyakitdiagnosa tbody').append(data.tr);
            renameInput();
        }, "json");
    }
}

function renameInput(){
    nourut = 0;
    $('.jenispenyakit').each(function(){
        $(this).parents('tr').find('[name*="SAKasuspenyakitdiagnosaM"]').each(function(){
            var input = $(this).attr('name');
            var data = input.split('SAKasuspenyakitdiagnosaM[]');
            if (typeof data[1] === 'undefined'){} else{
                $(this).attr('name','SAKasuspenyakitdiagnosaM['+nourut+']'+data[1]);
            }
        });
        nourut++;
    });
}
JS;

Yii::app()->clientScript->registerScript('kasuspenyakitdiagnosa', $jscript, CClientScript::POS_HEAD);
?>

<script type="text/javascript">
    function hapusBaris(obj) {
        $(obj).parent().parent('tr').detach();
    }
</script>