<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjkasuspenyakitruangan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
)); ?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->
    <?php
    if (isset($modDetails)) {
        echo $form->errorSummary($modDetails);
    } else {
        echo $form->errorSummary($model);
    }
    ?>
    <div class="col-sm-6">
        <?php
        $instalasi_id = Yii::app()->user->instalasi_id;
        $modInstalasi = InstalasiM::model()->findByPK($instalasi_id);
        echo CHtml::hiddenField('instalasi_id', $instalasi_id);
        echo $form->textFieldRow($model, 'instalasi_nama', array('value' => $modInstalasi->instalasi_nama, 'readonly' => true, 'class' => 'span2'));
        ?>
        <?php
        $ruangan_id = Yii::app()->user->ruangan_id;
        $modruangan = RuanganM::model()->findByPK($ruangan_id);
        echo CHtml::hiddenField('ruangan_id', $ruangan_id, array('readonly' => true));
        echo $form->textFieldRow($model, 'ruangan_nama', array('value' => $modruangan->ruangan_nama, 'readonly' => true, 'class' => 'span2',));
        ?>
    </div>
    <div class="col-sm-6">
        <?php echo CHtml::label('Kasus Penyakit', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->hiddenField($model, 'jeniskasuspenyakit_id', array('readonly' => true)) ?>
            <?php $this->widget('MyJuiAutoComplete', array(
                'name' => 'kasuspenyakit',
                'source' => 'js: function(request, response) {
				$.ajax({
					url: "' . Yii::app()->createUrl('ActionAutoComplete/JenisKasusPenyakit') . '",
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
					$(\'#SAKasuspenyakitruanganM_jeniskasuspenyakit_id\').val(ui.item.value);
					$(\'#kasuspenyakit\').val("");
					submitKasuspenyakitruangan();
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
            )); ?>
        </div>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Kasus Penyakit Ruangan</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table id="tabelKasuspenyakitruangan" class="table table-responsive table-bordered table-striped table-condensed">
            <thead>
                <tr>
                    <th>Instalasi</th>
                    <th>Ruangan</th>
                    <th>Nama Kasus</th>
                    <th>Nama Lain</th>
                    <th>Hapus/<br>Batal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $ruangan_id = $_GET['id'];
                $tr = '';
                $modKasuspenyakitruangan = KasuspenyakitruanganM::model()->findAllByAttributes(array('ruangan_id' => $ruangan_id));
                foreach ($modKasuspenyakitruangan as $value) {
                    $hapus = Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/Delete', array('ruangan_id' => "$value->ruangan_id", 'jeniskasuspenyakit_id' => "$value->jeniskasuspenyakit_id"));
                    $tr .= '<tr>';
                    $tr .= '<td>' . $modInstalasi->instalasi_nama . '</td>';
                    $tr .= '<td>' . $value->ruangan->ruangan_nama . '</td>';
                    $tr .= '<td>' . $value->jeniskasuspenyakit->jeniskasuspenyakit_nama . '</td>';
                    $tr .= '<td>' . $value->jeniskasuspenyakit->jeniskasuspenyakit_namalainnya . '</td>';
                    $tr .= '<td>' . CHtml::link("<i class='icon-form-sampah'></i>", $hapus) . '</td>';
                    $tr .= '</tr>';
                }
                echo $tr;

                if (count((array)$modDetails) > 0) {
                    foreach ($modDetails as $i => $row) {
                        $modruangan = RuanganM::model()->findByPK($row->ruangan_id);
                        $modJeniskasuspenyakit = JeniskasuspenyakitM::model()->findByPK($row->jeniskasuspenyakit_id);
                        $tr = "<tr>";
                        $tr .= "<td>"
                            . $modruangan->instalasi->instalasi_nama
                            . CHtml::hiddenField('ruangan_id[' . $i . ']', $row->ruangan_id, array('readonly' => true))
                            . CHtml::hiddenField('jeniskasuspenyakit_id[' . $i . ']', $row->jeniskasuspenyakit_id, array('readonly' => true))
                            . "</td>";
                        $tr .= "<td>" . $modruangan->ruangan_nama . "</td>";
                        $tr .= "<td>" . $modJeniskasuspenyakit->jeniskasuspenyakit_nama . "</td>";
                        $tr .= "<td>" . $modJeniskasuspenyakit->jeniskasuspenyakit_namalainnya . "</td>";
                        $tr .= "<td>" . CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick' => 'remove(this);')) . "</td>";
                        $tr .= "</tr>";
                        echo $tr;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'onKeypress' => 'return formSubmit(this,event)')
    );
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        '',
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Kasus Penyakit Ruangan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    );
    ?>
    <?php
    $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit2e', array(), true);
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
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","#",
                                array(
                                        "class"=>"btn-small",
                                        "id" => "selectKasuspenyakit",
                                        "onClick" => "\$(\"#SAKasuspenyakitruanganM_jeniskasuspenyakit_id\").val($data->jeniskasuspenyakit_id);
                                                              \$(\"#kasuspenyakit\").val(\"$data->jeniskasuspenyakit_nama\");
                                                              \$(\"#dialogkasuspenyakit\").dialog(\"close\");
                                                              submitKasuspenyakitruangan();"
                                ))',
        ),
        array(
            'header' => 'Nama Kasus',
            'value' => '$data->jeniskasuspenyakit_nama',
        ),
        array(
            'header' => 'Nama Lainnya',
            'value' => '$data->jeniskasuspenyakit_namalainnya',
        ),
        array(
            'header' => 'Urutan',
            'value' => '$data->jeniskasuspenyakit_urutan',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<!--======================== endWidget dialogkasuspenyakit =====================================-->
<?php
$urlGetKasuspenyakitruangan = $this->createUrl('Jeniskasuspenyakitruangan');
?>

<?php
$jscript = <<< JS
function submitKasuspenyakitruangan()
{
    instalasi_id = $('#instalasi_id').val();
    ruangan_id = $('#ruangan_id').val();
    jeniskasuspenyakit_id = $('#SAKasuspenyakitruanganM_jeniskasuspenyakit_id').val();

    if(jeniskasuspenyakit_id==''){
        myAlert('Silakan pilih jenis kasus penyakit terlebih dahulu!');
    }else{
        $.post("${urlGetKasuspenyakitruangan}", {instalasi_id:instalasi_id, ruangan_id: ruangan_id, jeniskasuspenyakit_id:jeniskasuspenyakit_id,},
        function(data){
            $('#tabelKasuspenyakitruangan tbody').append(data.tr);
        }, "json");
    }
}
JS;

Yii::app()->clientScript->registerScript('Jeniskasuspenyakitruangan', $jscript, CClientScript::POS_HEAD);
?>

<script type="text/javascript">
    function hapusBaris(obj) {
        $(obj).parent().parent('tr').detach();
    }
</script>