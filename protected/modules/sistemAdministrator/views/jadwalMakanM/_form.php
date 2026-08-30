<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sajadwalmakan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#jenisdiet',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td>
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
                            endforeach; */
                ?>
                <?php $this->widget('MyJuiAutoComplete', array(
                    'name' => 'jenisdiet',
                    'source' => 'js: function(request, response) {
                                                       $.ajax({
                                                           url: "' . Yii::app()->createUrl('ActionAutoComplete/Jenisdiet') . '",
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
                )); ?>
                <!--<td>
                                    <?php echo CHtml::htmlButton(
                                        '<i class="entypo-search"></i>',
                                        array(
                                            'onclick' => '$("#dialogJenisdiet").dialog("open");return false;',
                                            'class' => 'btn btn-danger',
                                            'onkeypress' => "return $(this).focusNextInputField(event)",
                                            'rel' => "tooltip",
                                            'title' => "Klik untuk Pencarian Jenis Diet Lebih Lanjut",
                                            'id' => 'buttonPemilihanMenuDiet',
                                        )
                                    );
                                    ?>
                        </td>-->
            </div>
        </td>
        <td>
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
                <?php $this->widget('MyJuiAutoComplete', array(
                    'name' => 'tipediet',
                    'source' => 'js: function(request, response) {
                                                       $.ajax({
                                                           url: "' . Yii::app()->createUrl('ActionAutoComplete/TipeDiet') . '",
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
                )); ?>
                <!--<td>
                                        <?php echo CHtml::htmlButton(
                                            '<i class="entypo-search"></i>',
                                            array(
                                                'onclick' => '$("#dialogTipeDiet").dialog("open");return false;',
                                                'class' => 'btn btn-danger',
                                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                                'rel' => "tooltip",
                                                'title' => "Klik untuk Pencarian Tipe Diet Lebih Lanjut",
                                                'id' => 'buttonPemilihanMenuDiet',
                                            )
                                        );
                                        ?>
                                </td>-->
            </div>
        </td>
        <td>
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
                <?php $this->widget('MyJuiAutoComplete', array(
                    'name' => 'menudiet',
                    'source' => 'js: function(request, response) {
                                                       $.ajax({
                                                           url: "' . Yii::app()->createUrl('ActionAutoComplete/MenuDiet') . '",
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
                )); ?>
                <!--<td>
                            <?php echo CHtml::htmlButton(
                                '<i class="entypo-search"></i>',
                                array(
                                    'onclick' => '$("#dialogMenuDiet").dialog("open");return false;',
                                    'class' => 'btn btn-danger',
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'rel' => "tooltip",
                                    'title' => "Klik untuk Pencarian Menu Diet Lebih Lanjut",
                                    'id' => 'buttonPemilihanMenuDiet',

                                )
                            ); ?>
                        </td>-->
            </div>
        </td>
    </tr>
</table>
<div class="controls">
    <table style="width: 100%; border: none;">
        <tr>
            <td>
                <?php
                $waktu = JenisWaktuM::model()->findAll("jeniswaktu_aktif=TRUE ORDER BY jeniswaktu_id");
                $returnVal = array();
                $returnVal = "<table><tr>";
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
                <?php echo CHtml::htmlButton(
                    '<i class="icon-plus icon-white"></i>',
                    array(
                        'onkeypress' => 'return $(this).focusNextInputField(event)',
                        'class' => 'btn btn-danger',
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



<div class="control-group">
    <!--<table class="table-striped">
                        <tr>
                            <td style="text-align:center;"> Jenis Diet </td>
                            <td style="text-align:center;"> Tipe Diet </td>
                            <td style="text-align:center;"> Pagi </td>
                            <td style="text-align:center;"> Siang </td>
                            <td style="text-align:center;"> Malam </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">
                                <?php /* echo CHtml::textField('jenisdiet_nama', '', array('readonly'=>true,'class'=>'span2')) ?>
                            </td>
                            <td style="text-align:center;">
                                <?php echo CHtml::textField('tipediet_nama', '', array('readonly'=>true,'class'=>'span2')) ?>
                            </td>
                            <td style="text-align:center;">
                        <?php echo CHtml::hiddenField('menudiet_id[2]', '', array('readonly'=>true,'id'=>'menudiet_id_0')) ?>
                            <?php 
                                /* $menudiet0 = MenuDietM::model()->findAll();
                                foreach($menudiet0 as $valuemenudiet0):
                                    $returnMenuDiet0[] = array(    
                                      'label'=>$valuemenudiet0->menudiet_nama,
                                      'value'=>$valuemenudiet0->menudiet_id,
                                      'id'=>$valuemenudiet0->menudiet_nama,);
                                endforeach; */
                                ?>
                            <?php /* $this->widget('MyJuiAutoComplete', array(
                                                   'name'=>'menudietpagi', 
                                                    'source'=>'js: function(request, response) {
                                                           $.ajax({
                                                               url: "'.Yii::app()->createUrl('ActionAutoComplete/MenuDiet').'",
                                                               dataType: "json",
                                                               data: {
                                                                   term: request.term,
                                                               },
                                                               success: function (data) {
                                                                       response(data);
                                                               }
                                                           })
                                                        }',
                                                    'options'=>array(
                                                               'showAnim'=>'fold',
                                                               'minLength' => 2,
                                                               'focus'=> 'js:function( event, ui )
                                                                   {
                                                                    $(this).val(ui.item.label);
                                                                    return false;
                                                                    }',
                                                               'select'=>'js:function( event, ui ) {
                                                                    $("#menudiet_id_0").val(ui.item.menudiet_id); 
                                                                    return false;
                                                                }',
                                                    ),
                                                    'htmlOptions'=>array(
                                                        'readonly'=>false,
                                                        'placeholder'=>'Menu Diet Pagi',
                                                        'class'=>'span2',
                                                    ),
                                            )); */ ?>
                            </td>
                            <td style="text-align:center;">
                            <?php /* echo CHtml::hiddenField('menudiet_id[3]', '', array('readonly'=>true,'id'=>'menudiet_id_1')) ?>
                            <?php 
                                /* $menudiet1 = MenuDietM::model()->findAll();
                                foreach($menudiet1 as $valuemenudiet1):
                                    $returnMenuDiet1[] = array(    
                                      'label'=>$valuemenudiet1->menudiet_nama,
                                      'value'=>$valuemenudiet1->menudiet_id,
                                      'id'=>$valuemenudiet1->menudiet_id,);
                                endforeach; */
                            ?>
                            <?php /* $this->widget('MyJuiAutoComplete', array(
                                                   'name'=>'menudietsiang', 
                                                    'source'=>'js: function(request, response) {
                                                           $.ajax({
                                                               url: "'.Yii::app()->createUrl('ActionAutoComplete/MenuDiet').'",
                                                               dataType: "json",
                                                               data: {
                                                                   term: request.term,
                                                               },
                                                               success: function (data) {
                                                                       response(data);
                                                               }
                                                           })
                                                        }',
                                                    'options'=>array(
                                                               'showAnim'=>'fold',
                                                               'minLength' => 2,
                                                               'focus'=> 'js:function( event, ui )
                                                                   {
                                                                    $(this).val(ui.item.label);
                                                                    return false;
                                                                    }',
                                                               'select'=>'js:function( event, ui ) {
                                                                    $("#menudiet_id_1").val(ui.item.menudiet_id); 
                                                                    return false;
                                                                }',
                                                    ),
                                                    'htmlOptions'=>array(
                                                        'readonly'=>false,
                                                        'placeholder'=>'Menu Diet Siang',
                                                        'class'=>'span2',
                                                    ),
                                            )); */ ?>
                            </td>
                            <td style="text-align:center;">
                            <?php // echo CHtml::hiddenField('menudiet_id[4]', '', array('readonly'=>true,'id'=>'menudiet_id_2')) 
                            ?>
                            <?php /* 
                                $menudiet2 = MenuDietM::model()->findAll();
                                foreach($menudiet2 as $valuemenudiet2):
                                    $returnMenuDiet2[] = array(    
                                      'label'=>$valuemenudiet2->menudiet_nama,
                                      'value'=>$valuemenudiet2->menudiet_id,
                                      'id'=>$valuemenudiet2->menudiet_id,);
                                endforeach;
                             */ ?>
                            <?php /* $this->widget('MyJuiAutoComplete', array(
                                                   'name'=>'menudietmalam', 
                                                    'source'=>'js: function(request, response) {
                                                           $.ajax({
                                                               url: "'.Yii::app()->createUrl('ActionAutoComplete/MenuDiet').'",
                                                               dataType: "json",
                                                               data: {
                                                                   term: request.term,
                                                               },
                                                               success: function (data) {
                                                                       response(data);
                                                               }
                                                           })
                                                        }',
                                                    'options'=>array(
                                                               'showAnim'=>'fold',
                                                               'minLength' => 2,
                                                               'focus'=> 'js:function( event, ui )
                                                                   {
                                                                    $(this).val(ui.item.label);
                                                                    return false;
                                                                    }',
                                                               'select'=>'js:function( event, ui ) {
                                                                    $("#menudiet_id_2").val(ui.item.menudiet_id); 
                                                                    return false;
                                                                }',
                                                    ),
                                                    'htmlOptions'=>array(
                                                        'readonly'=>false,
                                                        'placeholder'=>'Menu Diet Malam',
                                                        'class'=>'span2',
                                                    ),
                                            )); */ ?>
                            </td>
                        </tr>
                    </table>
                </div>-->

    <table id="tableJadwalMakan" class="table table-bordered table-condensed">
        <thead>
            <tr>
                <th><?php echo CHtml::checkBox('checkListUtama', true, array('onclick' => 'checkAll(\'cekList\',this);', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?></th>
                <th>Jenis Diet</th>
                <th>Tipe Diet</th>
                <th>Snack Pagi</th>
                <th>Pagi</th>
                <th>Siang</th>
                <th>Malam</th>
                <th>Snack Sore</th>
            </tr>
        </thead>
    </table>

    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'onKeyUp' => 'return formSubmit(this,event)')
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            Yii::app()->createUrl($this->module->id . '/jadwalMakanM/admin'),
            array(
                'title' => 'Ulang',
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
        $content = $this->renderPartial('../tips/tipsaddedit3c', array(), true);
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

    $modJenisdiet = new SAJenisdietM('search');
    $modJenisdiet->unsetAttributes();
    if (isset($_GET['SAJenisdietM'])) {
        $modJenisdiet->attributes = $_GET['SAJenisdietM'];
    }
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'jenisdiet-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
        'dataProvider' => $modJenisdiet->search(),
        'filter' => $modJenisdiet,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","#",
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

    $modTipeDiet = new SATipeDietM('search');
    $modTipeDiet->unsetAttributes();
    if (isset($_GET['SATipeDietM'])) {
        $modTipeDiet->attributes = $_GET['SATipeDietM'];
    }
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'tipediet-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
        'dataProvider' => $modTipeDiet->search(),
        'filter' => $modTipeDiet,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","#",
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

    $modMenuDiet = new SAMenuDietM('search');
    $modMenuDiet->unsetAttributes();
    if (isset($_GET['SAMenuDietM'])) {
        $modMenuDiet->attributes = $_GET['SAMenuDietM'];
    }
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'menudiet-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
        'dataProvider' => $modMenuDiet->search(),
        'filter' => $modMenuDiet,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","#",
                                            array(
                                                    "class"=>"btn-small",
                                                    "id" => "selectTipeDiet",
                                                    "onClick" => "\$(\"#menudietid\").val($data->menudiet_id);
                                                                          \$(\"#menudiet\").val(\"$data->menudiet_nama\");
                                                                          \$(\"#dialogMenuDiet\").dialog(\"close\");"
                                             )
                             )',
            ),
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

    <?php
    $jscript = <<< JS
function submitJadwalMakan()
{
    jenisdietid = $('#jenisdietid').val();
    tipedietid = $('#tipedietid').val();
    jeniswaktuid = $('#jeniswaktuid').val();
    menudietid = $('#menudietid').val();
    if(jenisdietid==''){
        myAlert('Silakan pilih jenis diet terlebih dahulu!');
    }else{
        $.post("${urlGetJadwalMakan}", $("#sajadwalmakan-m-form").serialize(),
        function(data){
            $('#tableJadwalMakan').append(data.return);
        }, "json");
    }   
}
function checkAll(kelas,obj)
{
    if(obj.checked) {
        $('.'+kelas+'').each(function() {
            $(this).attr('checked', 'checked');
        });
    }
    else
    {
        obj.checked = false;
        $('.'+kelas+'').each(function() {
            $(this).removeAttr('checked');
        });
    }
}
JS;

    Yii::app()->clientScript->registerScript('jadwalMakan', $jscript, CClientScript::POS_HEAD);
    ?>