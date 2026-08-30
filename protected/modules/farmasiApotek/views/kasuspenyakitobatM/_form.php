<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjkasuspenyakitobat-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#kasuspenyakit',
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
            <?php echo CHtml::label('Kasus Penyakit', '', array('class' => 'control-label required')); ?>
            <?php
            if (isset($_GET['id'])) {
                $jenispenyakit_id = $_GET['id'];
                $data = JeniskasuspenyakitM::model()->findByPK($_GET['id']);
            } else {
                $jenispenyakit_id = null;
                $data = null;
            }
            // if (isset($_GET['id'])) {
            //     $jenispenyakit_id = $_GET['id'];
            //     $data = JeniskasuspenyakitM::model()->findByPK($_GET['id']);
            //     $edit = true;
            // } else {
            //     $edit = false;
            // }
            ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('jeniskasuspenyakit_id', $jenispenyakit_id, array('readonly' => true)) ?>
                <?php $this->widget('MyJuiAutoComplete', array(
                    'name' => 'kasuspenyakit',
                    'value' => (isset($_GET['id']) ? $data->jeniskasuspenyakit_nama : null),
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
                            $(\'#jeniskasuspenyakit_id\').val(ui.item.value);
                            $(\'#kasuspenyakit\').val(ui.item.jeniskasuspenyakit_nama);
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        //'readonly'=>$edit,
                        'placeholder' => 'Kasus Penyakit',
                        'size' => 13,
                        'class' => 'span3',
                        'onkeypress' => "return $(this).focusNextInputField(event);",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogkasuspenyakit' . $jenispenyakit_id),
                )); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo CHtml::label('Obat Alkes', '', array('class' => 'control-label required')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('obatalkes_id', '', array('readonly' => true)) ?>
            <?php $this->widget(
                'MyJuiAutoComplete',
                array(
                    'name' => 'obatalkes',
                    'source' => 'js: function(request, response) {
                    $.ajax({
                        url: "' . Yii::app()->createUrl('ActionAutoComplete/Obatalkes') . '",
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
                        $(\'#obatalkes_id\').val(ui.item.obatalkes_id);
                        $(\'#obatalkes\').val("");
                        submitKasuspenyakitobat();
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
                    'tombolDialog' => array('idDialog' => 'dialogkasuspenyakitobat'),
                )
            ); ?>
        </div>
    </div>
</div>

<table id="tabelKasuspenyakitobat" class="table table-responsive table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th>Jenis Kasus Penyakit</th>
            <th>Kode Obat Alkes</th>
            <th>Nama Obat Alkes</th>
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
        $criteria = new CDbCriteria;
        $criteria->select = 'obatalkes.*,t.*,jeniskasuspenyakit.*';
        if (!empty($jenispenyakit_id)) {
            $criteria->addCondition("t.jeniskasuspenyakit_id = " . $jenispenyakit_id);
        }
        $criteria->join = 'LEFT JOIN obatalkes_m obatalkes ON t.obatalkes_id = obatalkes.obatalkes_id '
            . '  LEFT JOIN jeniskasuspenyakit_m jeniskasuspenyakit ON t.jeniskasuspenyakit_id = jeniskasuspenyakit.jeniskasuspenyakit_id';
        $modKasuspenyakitobat = FAKasuspenyakitobatM::model()->findAll($criteria);
        foreach ($modKasuspenyakitobat as $value) {
            $hapus = Yii::app()->createUrl('farmasiApotek/kasuspenyakitobatM/Delete', array('id' => "$value->jeniskasuspenyakit_id", 'obatalkes' => "$value->obatalkes_id"));
            $tr = '<tr>';
            $tr .= '<td>' . $value->jeniskasuspenyakit_nama . '</td>';
            $tr .= '<td>' . $value->obatalkes_kode . '&nbsp;' . '</td>';
            $tr .= '<td>' . $value->obatalkes_nama . '</td>';
            $tr .= '<td>' . CHtml::link("<i class='icon-form-sampah'></i>", $hapus) . '</td>';
            $tr .= '</tr>';
            echo $tr;
        }
        ?>
        <?php
        if (count((array)$modDetails) > 0) {
            foreach ($modDetails as $i => $row) {
                $modjeniskasuspenyakit = JeniskasuspenyakitM::model()->findByPK($row->jeniskasuspenyakit_id);
                $modobatalkes = ObatalkesM::model()->findByPK($row->obatalkes_id);
                $tr = "<tr>";
                $tr .= "<td>"
                    . $modjeniskasuspenyakit->jeniskasuspenyakit_nama
                    . CHtml::hiddenField('KasuspenyakitobatM[' . $i . '][jeniskasuspenyakit_id]', $row->jeniskasuspenyakit_id, array('readonly' => true))
                    . CHtml::hiddenField('KasuspenyakitobatM[' . $i . '][obatalkes_id]', $row->obatalkes_id, array('readonly' => true))
                    . "</td>";
                $tr .= "<td>" . $modobatalkes->obatalkes_kode . "</td>";
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
    <?php
    echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'onKeypress' => 'return formSubmit(this,event)')
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/kasuspenyakitobatM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Kasus Penyakit Obat', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('kasuspenyakitobatM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    );
    ?>
    <?php
    $content = $this->renderPartial('farmasiApotek.views.tips.tipsaddedit3', array(), true);
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
                                        "onClick" => "\$(\"#jeniskasuspenyakit_id\").val($data->jeniskasuspenyakit_id);
                                                              \$(\"#kasuspenyakit\").val(\"$data->jeniskasuspenyakit_nama\");
                                                              \$(\"#dialogkasuspenyakit\").dialog(\"close\");"
                                ))',
        ),
        array(
            'header' => 'Nama Kasus',
            'value' => '$data->jeniskasuspenyakit_nama',
            'filter' =>  CHtml::activeTextField($modJeniskasuspenyakit, 'jeniskasuspenyakit_nama'),
        ),
        array(
            'header' => 'Nama Lainnya',
            'value' => '$data->jeniskasuspenyakit_namalainnya',
            'filter' =>  CHtml::activeTextField($modJeniskasuspenyakit, 'jeniskasuspenyakit_namalainnya'),
        ),
        array(
            'header' => 'Urutan',
            'value' => '$data->jeniskasuspenyakit_urutan',
            'filter' =>  CHtml::activeTextField($modJeniskasuspenyakit, 'jeniskasuspenyakit_urutan'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<!--======================== endWidget dialogkasuspenyakit =====================================-->

<!--============================== Widget Dialog obatAlkes ====================================-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogkasuspenyakitobat',
    'options' => array(
        'title' => 'Pencarian Obat Alkes',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modobatalkes = new ObatalkesM;
$modobatalkes->unsetAttributes();
if (isset($_GET['ObatalkesM'])) {
    $modobatalkes->attributes = $_GET['ObatalkesM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-grid',
    'dataProvider' => $modobatalkes->searchObatFarmasi(),
    'filter' => $modobatalkes,
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
                                        "onClick" => "\$(\"#obatalkes_id\").val($data->obatalkes_id);
                                                              \$(\"#obatalkes\").val(\"\");
                                                              \$(\"#dialogkasuspenyakitobat\").dialog(\"close\");
                                                               submitKasuspenyakitobat();"
                                ))',
        ),
        array(
            'header' => 'Kode Obat Alkes',
            'value' => '$data->obatalkes_kode',
            'filter' =>  CHtml::activeTextField($modobatalkes, 'obatalkes_kode'),
        ),
        array(
            'header' => 'Obat Alkes',
            'value' => '$data->obatalkes_nama',
            'filter' =>  CHtml::activeTextField($modobatalkes, 'obatalkes_nama'),
        ),
        array(
            'header' => 'Jenis',
            'value' => '(isset($data->jenisobatalkes->jenisobatalkes_nama) ? $data->jenisobatalkes->jenisobatalkes_nama : "-")',
        ),
        array(
            'header' => 'Kategori',
            'value' => '$data->obatalkes_kategori',
        ),
        array(
            'header' => 'Golongan',
            'value' => '$data->obatalkes_golongan',
        ),
        //            array(
        //                'header'=>'Nama Lainnya',
        //                'value'=>'(isset($data->obatalkes_namalainnya) ? $data->obatalkes_namalainnya : "-"',
        //            ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<!--======================== endWidget dialogkasuspenyakit =====================================-->
<?php
$urlGetKasuspenyakitobat = $this->createUrl('KasuspenyakitobatM');
?>

<?php
$jscript = <<< JS
function submitKasuspenyakitobat()
{
    jeniskasuspenyakit_id = $('#jeniskasuspenyakit_id').val();
    obatalkes_id = $('#obatalkes_id').val();
    if(jeniskasuspenyakit_id==''){
        myAlert('Silakan pilih jenis kasus penyakit terlebih dahulu!');
    }else{
        $.post("${urlGetKasuspenyakitobat}", {jeniskasuspenyakit_id:jeniskasuspenyakit_id, obatalkes_id: obatalkes_id,},
        function(data){
            $('#tabelKasuspenyakitobat tbody').append(data.tr);
            renameInput();
        }, "json");
    }   
}

function renameInput(){
    nourut = 0;
    $('.jenispenyakit').each(function(){
        $(this).parents('tr').find('[name*="KasuspenyakitobatM"]').each(function(){
            var input = $(this).attr('name');
            var data = input.split('KasuspenyakitobatM[]');
            if (typeof data[1] === 'undefined'){} else{
                $(this).attr('name','KasuspenyakitobatM['+nourut+']'+data[1]);
            }
        });
        nourut++;
    });
}

JS;

Yii::app()->clientScript->registerScript('kasuspenyakitobat', $jscript, CClientScript::POS_HEAD);
?>

<script type="text/javascript">
    function hapusBaris(obj) {
        $(obj).parent().parent('tr').detach();
    }
</script>