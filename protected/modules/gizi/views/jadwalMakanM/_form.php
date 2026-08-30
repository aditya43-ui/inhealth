<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gzjadwalmakan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#jenisdiet',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
?>
<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->
<?php echo $form->errorSummary($model); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Jenis Diet', 'jjenisdiet', array('class' => "control-label")) ?>
            <div class="controls">
                <?php
                echo CHtml::dropDownList('jenisdietid', null, CHtml::listData(JenisdietM::model()->findAll(array(
                    'condition' => 'jenisdiet_aktif = true',
                    'order' => 'jenisdiet_nama',
                )), 'jenisdiet_id', 'jenisdiet_nama'), array('empty' => '-- Pilih --', 'onchange' => 'updateDialogMenuDiet()'));
                ?>
            </div>
            <?php /*
              <?php echo CHtml::label('Jenis Diet', 'jjenisdiet', array('class' => "control-label")) ?>
              <div class="controls">
              <?php echo CHtml::hiddenField('jenisdietid', '', array('readonly' => true)) ?>
              <?php
              /* $jenisdiet = JenisdietM::model()->findAll();
              foreach($jenisdiet as $valuejenisdiet):
              $returnJenisdiet[] = array(
              'label'=>$valuejenisdiet->jenisdiet_nama,
              'value'=>$valuejenisdiet->jenisdiet_id,
              'id'=>$valuejenisdiet->jenisdiet_id,);
              endforeach; */ /*
              ?>
              <?php
              $this->widget('MyJuiAutoComplete', array(
              'name' => 'jenisdiet',
              'source' => 'js: function(request, response) {
              $.ajax({
              url: "' . $this->createUrl('Jenisdiet') . '",
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
              'focus' => 'js:function( event, ui )
              {
              $(this).val(ui.item.label);
              return false;
              }',
              'select' => 'js:function( event, ui ) {
              $("#jenisdietid").val(ui.item.jenisdiet_id);
              $("#jenisdiet_nama").val(ui.item.jenisdiet_nama);
              return false;
              }',
              ),
              'htmlOptions' => array(
              'readonly' => false,
              'placeholder' => 'Jenis Diet',
              'size' => 13,
              'onkeypress' => "return $(this).focusNextInputField(event);",
              ),
              'tombolDialog' => array('idDialog' => 'dialogJenisdiet'),
              ));
              ?>
              <!--<td>
              <?php
              echo CHtml::htmlButton('<i class="entypo-search"></i>', array(
              'onclick' => '$("#dialogJenisdiet").dialog("open");return false;',
              'class' => 'btn btn-danger',
              'onkeypress' => "return $(this).focusNextInputField(event)",
              'rel' => "tooltip",
              'title' => "Klik untuk Pencarian Jenis Diet Lebih Lanjut",
              'id' => 'buttonPemilihanMenuDiet',
              ));
              ?>
              </td>-->
              </div> */ ?>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tipe Diet', 'ttipediet', array('class' => "control-label")) ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('tipedietid', '', array('readonly' => true)) ?>
                <?php
                /* $tipediet = TipeDietM::model()->findAll();
                  foreach($tipediet as $valuetipediet):
                  $returnTipeDiet[] = array(
                  'label'=>$valuetipediet->tipediet_nama,
                  'value'=>$valuetipediet->tipediet_id,
                  'id'=>$valuetipediet->tipediet_id,);
                  endforeach; */
                ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'tipediet',
                    'source' => 'js: function(request, response) {
                                                                       $.ajax({
                                                                           url: "' . $this->createUrl('TipeDiet') . '",
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
                        'focus' => 'js:function( event, ui )
                                                                               {
                                                                                $(this).val(ui.item.label);
                                                                                return false;
                                                                                }',
                        'select' => 'js:function( event, ui ) {
                                                                               $("#tipedietid").val(ui.item.tipediet_id);
                                                                               $("#tipediet_nama").val(ui.item.tipediet_nama);
                                                                                return false;
                                                                            }',
                    ),
                    'htmlOptions' => array(
                        'readonly' => false,
                        'placeholder' => 'Tipe Diet',
                        'size' => 13,
                        'onkeypress' => "return $(this).focusNextInputField(event);",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogTipeDiet'),
                ));
                ?>
                <!--<td>
                <?php
                echo CHtml::htmlButton('<i class="entypo-search"></i>', array(
                    'onclick' => '$("#dialogTipeDiet").dialog("open");return false;',
                    'class' => 'btn btn-primary',
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'rel' => "tooltip",
                    'title' => "Klik untuk Pencarian Tipe Diet Lebih Lanjut",
                    'id' => 'buttonPemilihanMenuDiet',
                ));
                ?>
                        </td>-->
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Menu Diet', 'mmenudiet', array('class' => "control-label")) ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('menudietid', '', array('readonly' => true)) ?>
                <?php
                /* $menudiet = MenuDietM::model()->findAll();
                  foreach($menudiet as $valuemenudiet):
                  $returnMenuDiet[] = array(
                  'label'=>$valuemenudiet->menudiet_nama,
                  'value'=>$valuemenudiet->menudiet_nama,
                  'id'=>$valuemenudiet->menudiet_id,);
                  endforeach; */
                ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'menudiet',
                    'source' => 'js: function(request, response) {
                                                                                   $.ajax({
                                                                                       url: "' . $this->createUrl('MenuDiet') . '",
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
                        'focus' => 'js:function( event, ui )
                                                                                           {
                                                                                            $(this).val(ui.item.label);
                                                                                            return false;
                                                                                            }',
                        'select' => 'js:function( event, ui ) {
                                                                                           $("#menudietid").val(ui.item.menudiet_id);
                                                                                            return false;
                                                                                        }',
                    ),
                    'htmlOptions' => array(
                        'readonly' => false,
                        'placeholder' => 'Menu Diet',
                        'size' => 13,
                        'onkeypress' => "return $(this).focusNextInputField(event);",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogMenuDiet'),
                ));
                ?>
            </div>
            <!--<?php
                echo CHtml::htmlButton('<i class="entypo-search"></i>', array(
                    'onclick' => '$("#dialogMenuDiet").dialog("open");return false;',
                    'class' => 'btn btn-primary',
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'rel' => "tooltip",
                    'title' => "Klik untuk Pencarian Menu Diet Lebih Lanjut",
                    'id' => 'buttonPemilihanMenuDiet',
                ));
                ?>-->
        </div>
    </div>
    <div class="col-sm-6">
        <div class="controls">
            <table>
                <tr>
                    <td style="width:250px;">
                        <?php
                        $waktu = JenisWaktuM::model()->findAll("jeniswaktu_aktif=TRUE ORDER BY jeniswaktu_id");
                        $returnVal = array();
                        $returnVal = "<table style='width:250px;'><tr>";
                        $i = 0;
                        $tr = "";
                        foreach ($waktu as $data) {
                            $tr .= "<td style='text-align:left;'>";
                            $tr .= CHtml::checkbox('jeniswaktuid[]', false, array('value' => $data->getAttribute('jeniswaktu_id'), 'onkeypress' => "return $(this).focusNextInputField(event);"));
                            $tr .= ' ' . $data->getAttribute('jeniswaktu_nama');
                            $tr .= '</td>';
                            $i++;
                        }
                        $returnVal .= $tr;
                        $returnVal .= '</table>';
                        echo $returnVal;
                        ?>
                    </td>
                    <td>
                        <?php
                        echo CHtml::htmlButton(
                            '<i class="icon-plus icon-white"></i>',
                            array(
                                'onkeypress' => 'return $(this).focusNextInputField(event)',
                                'class' => 'btn btn-primary',
                                'onclick' => "\$(\"#menudiet_id\").val();
                                                                                                  \$(\"#menudiet\").val();
                                                                                                  \$(\"#dialogMenuDiet\").dialog(\"close\");
                                                                                                    submitJadwalMakan();",
                                'rel' => "tooltip",
                                'id' => 'tambahJadwal',
                                'title' => "Klik untuk Menambahkan Jadwal",
                            )
                        );
                        ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Jadwal Makanan</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <div class="control-group">
            <table id="tableJadwalMakan" class="table table-condensed">
                <thead>
                    <tr>
                        <th hidden><?php echo CHtml::checkBox('checkListUtama', true, array('onclick' => 'checkAll(\'cekList\',this);', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?></th>
                        <th>Jenis Diet</th>
                        <th>Tipe Diet</th>
                        <th>Snack Pagi</th>
                        <th>Pagi</th>
                        <th>Siang</th>
                        <th>Malam</th>
                        <th>Snack Sore</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'onKeyUp' => 'return formSubmit(this,event)'));
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/jadwalMakanM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jadwal Makan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('jadwalMakanM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit3d', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogJenisdiet',
    'options' => array(
        'title' => 'Pencarian Jenis Diet',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
        'resizable' => false,
    ),
));

$modJenisdiet = new GZJenisdietM('search');
$modJenisdiet->unsetAttributes();
if (isset($_GET['GZJenisdietM'])) {
    $modJenisdiet->attributes = $_GET['GZJenisdietM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'jenisdiet-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modJenisdiet->search(),
    'filter' => $modJenisdiet,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                            array(
                                                    "class"=>"btn-small",
                                                    "id" => "selectJenisdiet",
                                                    "onClick" => "\$(\"#jenisdietid\").val($data->jenisdiet_id);
                                                                          \$(\"#jenisdiet\").val(\"$data->jenisdiet_nama\");
                                                                          \$(\"#dialogJenisdiet\").dialog(\"close\");"
                                             )
                             )',
        ),
        'jenisdiet_nama',
        'jenisdiet_namalainnya',
        'jenisdiet_keterangan',
        'jenisdiet_catatan',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
/* -------------------------------------------------------------------------- endWidget Jenisdiet ---------------------------------------------- */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogTipeDiet',
    'options' => array(
        'title' => 'Pencarian Tipe Diet',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
        'resizable' => false,
    ),
));

$modTipeDiet = new GZTipeDietM('search');
$modTipeDiet->unsetAttributes();
if (isset($_GET['GZTipeDietM'])) {
    $modTipeDiet->attributes = $_GET['GZTipeDietM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'tipediet-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modTipeDiet->search(),
    'filter' => $modTipeDiet,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                            array(
                                                    "class"=>"btn-small",
                                                    "id" => "selectTipeDiet",
                                                    "onClick" => "\$(\"#tipedietid\").val($data->tipediet_id);
                                                                          \$(\"#tipediet\").val(\"$data->tipediet_nama\");
                                                                          \$(\"#dialogTipeDiet\").dialog(\"close\");"
                                             )
                             )',
        ),
        'tipediet_nama',
        'tipediet_namalainnya',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
/* -------------------------------------------------------------------------- endWidget TipeDiet ---------------------------------------------- */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMenuDiet',
    'options' => array(
        'title' => 'Pencarian Menu Diet',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
        'resizable' => false,
    ),
));

$modMenuDiet = new GZMenuDietM('searchDialogDiet');
$modMenuDiet->unsetAttributes();
if (isset($_GET['GZMenuDietM'])) {
    $modMenuDiet->attributes = $_GET['GZMenuDietM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'menudiet-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modMenuDiet->searchDialogDiet(),
    'filter' => $modMenuDiet,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                            array(
                                                    "class"=>"btn-small",
                                                    "id" => "selectTipeDiet",
                                                    "onClick" => "\$(\"#menudietid\").val($data->menudiet_id);
                                                                          \$(\"#menudiet\").val(\"$data->menudiet_nama\");
                                                                          \$(\"#dialogMenuDiet\").dialog(\"close\");"
                                             )
                             )',
            'filter' => CHtml::activeHiddenField($modMenuDiet, "jenisdiet_id"),
        ),
        'jenisdiet.jenisdiet_nama',
        'menudiet_nama',
        'menudiet_namalain',
        'jml_porsi',
        'ukuranrumahtangga',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
/* -------------------------------------------------------------------------- endWidget MenuDiet ---------------------------------------------- */
?>

<?php
$urlGetJadwalMakan = $this->createUrl('GetJadwalMakan');
?>
<script type="text/javascript">
    function updateDialogMenuDiet() {
        var id = $("#jenisdietid").val();
        $("#GZMenuDietM_jenisdiet_id").val(id);
        $.fn.yiiGridView.update("menudiet-grid", {
            data: $("#menudiet-grid :input").serialize()
        });
    }

    function submitJadwalMakan() {
        jenisdietid = $('#jenisdietid').val();
        tipedietid = $('#tipedietid').val();
        jeniswaktuid = $('#jeniswaktuid').val();
        menudietid = $('#menudietid').val();
        var params = $("#gzjadwalmakan-m-form").serialize();
        if (jenisdietid == '') {
            myAlert('Silakan pilih jenis diet terlebih dahulu!');
        } else if (tipedietid == '') {
            myAlert('Silakan pilih tipe diet terlebih dahulu!');
        } else if (menudietid == '') {
            myAlert('Silakan pilih menu diet terlebih dahulu!');
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('GetJadwalMakan'); ?>',
                data: params,
                dataType: "json",
                success: function(data) {
                    $('#tableJadwalMakan').append(data.return);
                    renameInput('#tableJadwalMakan');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }

    }

    function renameInput(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function() {
            $(this).find('span[name*="[ii]"]').each(function() { //element <span>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
                if (old_name_arr.length == 4) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + old_name_arr[3]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + old_name_arr[3] + "]");
                }
            });
            row++;
        });

    }

    function hapusRowJadwalMakan(obj) {
        myConfirm('Apakah Anda akan membatalkan jadwal makan ini?', 'Perhatian!',
            function(r) {
                if (r) {
                    $(obj).parents('tr').detach();
                    renameInput('#tableJadwalMakan');
                }
            });
    }

    function checkAll(kelas, obj) {
        if (obj.checked) {
            $('.' + kelas + '').each(function() {
                $(this).attr('checked', 'checked');
            });
        } else {
            obj.checked = false;
            $('.' + kelas + '').each(function() {
                $(this).removeAttr('checked');
            });
        }
    }
</script>