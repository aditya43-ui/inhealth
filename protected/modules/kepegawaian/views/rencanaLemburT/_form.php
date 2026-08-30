<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rencana-lembur-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);', 'style' => 'margin-top: 0 !important;', ),
    'focus' => '#',
)); ?>

<?php echo $form->errorSummary($modRencanaLembur); ?>
<?php if (isset($modRealisasiLembur)) echo $form->errorSummary($modRealisasiLembur); ?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Rencana Lembur</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($modRencanaLembur, 'tglrencana', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $modRencanaLembur->tglrencana = (!empty($modRencanaLembur->tglrencana) ? date("d/m/Y", strtotime($modRencanaLembur->tglrencana)) : null);
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modRencanaLembur,
                            'attribute' => 'tglrencana',
                            'mode' => 'date',
                            'options' => array(
                                //                                            'dateFormat'=>Params::DATE_FORMAT,
                                'showOn' => false,
                                'minDate' => '-2',
                            ),
                            'htmlOptions' => array(
                                'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask span2', 'onkeyup' => "return $(this).focusNextInputField(event)"
                            ),
                        )); ?>
                        <?php echo $form->error($modRencanaLembur, 'tglrencana'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php
                    echo $form->labelEx($modRencanaLembur, 'norencana', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modRencanaLembur, 'norencana', array('readonly' => true, 'class' => 'span3 isRequired', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 20)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRencanaLembur, 'keterangan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modRencanaLembur, 'keterangan', array('placeholder' => 'Keterangan', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Pemberi Tugas <span class='required'>*</span>", 'pemberitugas_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeHiddenField($modRencanaLembur, 'pemberitugas_id'); ?>
                        <div style="float:left;">
                            <?php $this->widget('MyJuiAutoComplete', array(
                                'model' => $modRencanaLembur,
                                'attribute' => 'pemberitugas_nama',
                                'sourceUrl' => Yii::app()->createUrl('kepegawaian/ActionAutoCompleteKP/PemberiTugas'),
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'select' => 'js:function( event, ui ) {
                                                          $("#KPRencanaLemburT_pemberitugas_id").val(ui.item.pegawai_id);                                                  
                                        }',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogPemberiTugas'),
                                'htmlOptions' => array(
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modRencanaLembur, 'pemberitugas_id') . '").val(""); ',
                                    'placeholder' => 'Pemberi Tugas',
                                    'class' => 'span4 required', 'style' => 'float:left;'
                                ),
                            )); ?>
                        </div>
                    </div>
                </div>
                <!--<div class= "control-group">-->
                <?php // echo CHtml::label("Mengetahui <span class='required'>*</span>",'mengetahui_id', array('class'=>'control-label')) 
                ?>
                <!--<div class="controls">-->
                <?php // echo CHtml::activeHiddenField($modRencanaLembur,'mengetahui_id');
                ?>
                <!--<div style="float:left;">-->
                <?php // $this->widget('MyJuiAutoComplete',array(
                //                                    'model'=>$modRencanaLembur,
                //                                    'attribute'=>'mengetahui_nama',
                //                                    'sourceUrl'=> $this->createUrl('Mengetahui'),
                //                                    'options'=>array(
                //                                       'showAnim'=>'fold',
                //                                       'minLength' => 2,
                //                                       'select'=>'js:function( event, ui ) {
                //                                            $("#KPRencanaLemburT_mengetahui_id").val(ui.item.pegawai_id);
                //                                        }',
                //                                    ),
                //                                    'tombolDialog'=>array('idDialog'=>'dialogMengetahui'),
                //                                    'htmlOptions'=>array(
                //                                        'onkeyup'=>"return $(this).focusNextInputField(event)",
                //                                        'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modRencanaLembur, 'mengetahui_id') . '").val(""); ',
                //                                        'class'=>'span3 required','style'=>'float:left;'),
                //                                )); 
                ?>
                <!--</div>
                        </div>
                    </div>-->
                <div class="control-group">
                    <?php //echo $form->textFieldRow($modRencanaLembur,'menyetujui_id',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); 
                    ?>
                    <?php //echo $form->labelEx($modRencanaLembur,'menyetujui_id', array('class'=>'control-label')) 
                    ?>
                    <?php echo CHtml::label("Menyetujui <span class='required'>*</span>", 'menyetujui_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeHiddenField($modRencanaLembur, 'menyetujui_id'); ?>
                        <div style="float:left;">
                            <?php echo $form->textField($modRencanaLembur, 'menyetujui_nama', array('readonly' => true, 'class' => 'span4 isRequired', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 20)); ?>

                            <?php
                            //  $this->widget('MyJuiAutoComplete', array(
                            //     'model' => $modRencanaLembur,
                            //     'attribute' => 'menyetujui_nama',
                            //     'sourceUrl' => $this->createUrl('Menyetujui'),
                            //     'options' => array(
                            //         'showAnim' => 'fold',
                            //         'minLength' => 2,
                            //         'select' => 'js:function( event, ui ) {
                            //                                       $("#KPRencanaLemburT_menyetujui_id").val(ui.item.pegawai_id);
                            //                     }',
                            //     ),
                            //     'tombolDialog' => array('idDialog' => 'dialogMenyetujui'),
                            //     'htmlOptions' => array(
                            //         'onkeyup' => "return $(this).focusNextInputField(event)",
                            //         'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modRencanaLembur, 'menyetujui_id') . '").val(""); ',
                            //         'class' => 'span3 required',
                            //         'style' => 'float:left;',
                            //         'placeholder' => 'Menyetujui',
                            //     ),
                            // )); 
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Rencana Lembur</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($modRencanaLembur, 'nama_pegawai', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::hiddenField('pegawailembur_id'); ?>
                        <div style="float:left;">
                            <?php $this->widget('MyJuiAutoComplete', array(
                                'model' => $modRencanaLembur,
                                'attribute' => 'karlembur_nama',
                                'sourceUrl' => $this->createUrl('PegawaiLembur'),
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'select' => 'js:function( event, ui ) {
                                                $("#pegawailembur_id").val(ui.item.pegawai_id);
                                                $("#' . CHtml::activeId($modRencanaLembur, 'karlembur_nama') . '").val(ui.item.nama_pegawai);
                                                $("#' . CHtml::activeId($modRencanaLembur, 'rencana_nip') . '").val(ui.item.nomorindukpegawai);
                                            }',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogPegawaiLembur'),
                                'htmlOptions' => array(
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'onblur' => 'if(this.value === "") $("#pegawailembur_id").val(""); ',
                                    'class' => 'span3', 'style' => 'float:left;',
                                    'placeholder' => 'Nama Pegawai',
                                ),
                            )); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php /*
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo $form->labelEx($modRencanaLembur,'rencana_nip', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modRencanaLembur, 'rencana_nip', array('class'=>'span3','onkeypress'=>"if(event.keyCode == 13){submitPegawaiLembur();} return $(this).focusNextInputField(event);" )); ?>
                            <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
                                array('onclick'=>'submitPegawaiLembur();return false;',
                                    'class' => 'btn btn-danger',
                                    'onkeypress'=>"if(event.keyCode == 13){submitPegawaiLembur();} return $(this).focusNextInputField(event);",
                                    'rel'=>"tooltip",
                                    'title'=>"Klik untuk Menambahkan Pegawai Lembur",

                                )); ?>
                        </div>
                    </div>
                </div>
                 * 
                 */ ?>
            <?php if (isset($modDetails)) {
                echo $form->errorSummary($modDetails);
            } ?>
        </div>

        <table id="tabelPegawaiLembur" class="table table-striped table-bordered table-condensed">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>No. Induk Pegawai</th>
                    <th>Nama Pegawai</th>
                    <!--<th>Jabatan</th>-->
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Jenis Lembur</th>
                    <th>Alasan Lembur</th>
                    <?php if (count((array)$rencana) == 0) : ?><th>Batal</th> <?php endif; ?>

                </tr>
            </thead>
            <tbody>
                <?php
                $tr = '';
                $no = 1;
                $format = new MyFormatter;
                if (count((array)$rencana) > 0) {
                    foreach ($rencana as $key => $modDetail) {
                        $rencana[$key]->jamMulai = date('H:i:s', strtotime($rencana[$key]->tglmulai));
                        $rencana[$key]->jamSelesai = date('H:i:s', strtotime($rencana[$key]->tglselesai));
                        $lembur = BiayalemburM::model()->findByPk($modDetail->biayalembur_id);
                        $tr .= "<tr>
                                        <td>" . CHtml::TextField('noUrut', $no++, array('class' => 'span1 noUrut', 'readonly' => TRUE)) . "</td>
                                        <td>" . $rencana[$key]->pegawai->nomorindukpegawai . "</td>
                                        <td>" . $rencana[$key]->pegawai->nama_pegawai . "</td>
                                        <td>" . $rencana[$key]->jamMulai . "</td>
                                        <td>" . $rencana[$key]->jamSelesai . "</td>
                                        <td>" . $lembur->biayalembur_nama . "</td>
                                        <td>" . $rencana[$key]->alasanlembur . "</td>
                                    </tr>   
                                "; // <td>".$modDetail[$key]->pegawai->departement->departement_nama."</td>

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
    $disableSave = false;
    $disableSave = (!empty($_GET['id'])) ? true : (($sukses > 0) ? true : false);
    $disablePrint = ($disableSave) ? false : true;
    ?>
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'validasiLembur();', 'onkeypress' => 'validasiLembur();', 'disabled' => $disableSave)
    ); //formSubmit(this,event)        
    //  jika tanpa validasiLembur 
    /**echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                        array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disableSave));
     * 
     */
    ?>

    <?php if (!isset($_GET['frame'])) {
        echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl($this->id . '/buat'),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/buat') . '";}); return false;'
            )
        );
    } ?>
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => $disablePrint, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
    ?>
    <?php
    $tips = array(
        '0' => 'tanggal',
        '1' => 'autocomplete-search',
        '2' => 'time',
        '3' => 'simpan',
        '4' => 'ulang',
        '5' => 'print',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('modRencanaLembur' => $modRencanaLembur)); ?>
<?php echo $this->renderPartial($this->path_view . '_jsMultiSelectDialog', array('modRencanaLembur' => $modRencanaLembur)); ?>
<?php
$karlembur_nama = CHtml::activeId($modRencanaLembur, 'karlembur_nama');
$karlembur_nomorindukpegawai = CHtml::activeId($modRencanaLembur, 'rencana_nip');
$jscript = <<< JS
var nomorindukpegawaiPegawaiLembur;

JS;
Yii::app()->clientScript->registerScript('inputPegawai', $jscript, CClientScript::POS_HEAD);

?>

<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
//$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
//    'id'=>'dialogMengetahui',
//    'options'=>array(
//        'title'=>'Pencarian Mengetahui Pegawai',
//        'autoOpen'=>false,
//        'modal'=>true,
//        'width'=>600,
//        'resizable'=>false,
//    ),
//));

//$modMengetahui = new PegawaiM('search');
//$modMengetahui->unsetAttributes();
//$modMengetahui->jabatan_id = Params::getKepalaUnitApp();
//if(isset($_GET['PegawaiM'])) {
//    $modMengetahui->attributes = $_GET['PegawaiM'];
//	$modMengetahui->jabatan_id = Params::getKepalaUnitApp();
//}
//$this->widget('ext.bootstrap.widgets.BootGridView',array(
//	'id'=>'mengetahui-m-grid',
//	'dataProvider'=>$modMengetahui->search(),
//	'filter'=>$modMengetahui,
//    'template'=>"{summary}\n{items}\n{pager}",
//    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//	'columns'=>array(
//            array(
//                'header'=>'Pilih',
//                'type'=>'raw',
//                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
//                                "id" => "selectMengetahui",
//                                "onClick" => "$(\"#KPRencanaLemburT_mengetahui_id\").val(\"$data->pegawai_id\");
//                                              $(\"#'.CHtml::activeId($modRencanaLembur,'mengetahui_nama').'\").val(\"$data->nama_pegawai\");
//                                              $(\"#dialogMengetahui\").dialog(\"close\");    
//                                              return false;
//                                    "))',
//            ),
//            array(
//                'header'=>'No.',
//                'type'=>'raw',
//                'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
//                'filter'=>false,
//            ),
//            'nomorindukpegawai',                
//                    
//            array(
//                'name'=>'nama_pegawai',
//                'value'=>'$data->namaLengkap',
//            ),
//			array(
//				'header' => 'Jabatan',
//				'name' => 'jabatan_id',
//				'filter' => CHtml::activeDropDownList($modMengetahui, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'),array('empty'=>'-- Pilih --')),
//				'value' => function($data){
//					$j = JabatanM::model()->findByPk($data->jabatan_id);
//					
//					if (!empty($j)){
//						return $j->jabatan_nama;
//					}
//				}
//			),
//
//	),
//    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
//));
//
//$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>

<?php
//========= Dialog buat cari data Pegawai Menyetujui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMenyetujui',
    'options' => array(
        'title' => 'Pencarian Menyetujui Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modMenyetujui = new PegawaiM('search');
$modMenyetujui->unsetAttributes();
$modMenyetujui->jabatan_nama = "Manager";
if (isset($_GET['PegawaiM'])) {
    $modMenyetujui->attributes = $_GET['PegawaiM'];
    //	$modMenyetujui->jabatan_id = Params::JABATAN_ID_MANAGER;
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'menyetujui-m-grid',
    'dataProvider' => $modMenyetujui->search(),
    'filter' => $modMenyetujui,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectMenyetujui",
                            "onClick" => "$(\"#KPRencanaLemburT_menyetujui_id\").val(\"$data->pegawai_id\");
                                          $(\"#' . CHtml::activeId($modRencanaLembur, 'menyetujui_nama') . '\").val(\"$data->nama_pegawai\");
                                          $(\"#dialogMenyetujui\").dialog(\"close\");    
                                          return false;
                                "))',
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modMenyetujui, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("lower(jabatan_nama) ilike lower('%Manager%') and jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Pegawai Menyetujui dialog =============================
?>

<?php
//========= Dialog buat cari data Pegawai Lembur =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiLembur',
    'options' => array(
        'title' => 'Pencarian Pegawai Lembur',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_KEPEGAWAIAN) {
    $classPegawai = 'PegawaiV';
    $modPegawaiLembur = new $classPegawai('search');
    $modPegawaiLembur->unsetAttributes();
} else {
    $classPegawai = 'PegawairuanganV';
    $modPegawaiLembur = new $classPegawai('search');
    $modPegawaiLembur->unsetAttributes();
    $modPegawaiLembur->ruangan_id = Yii::app()->user->getState('ruangan_id');
}

if (isset($_GET[$classPegawai])) {
    $modPegawaiLembur->attributes = $_GET[$classPegawai];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'karlembur-m-grid',
    'dataProvider' => $modPegawaiLembur->searchNonDokter(),
    'filter' => $modPegawaiLembur,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::checkBox('dialog_pegawai_lembur', false, array(
                    'class' => 'check_pegawai', 'onchange' => 'ceklis_pegawai(this);',
                    'data-id' => $data->pegawai_id,
                ));
            },
            'htmlOptions' => array(
                'style' => 'text-align: center;',
            ),
            /*
                'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                    "id" => "selectPegawaiLembur",
                    "onClick" => "$(\"#pegawailembur_id\").val(\"$data->pegawai_id\");
                                  $(\"#'.CHtml::activeId($modRencanaLembur,'karlembur_nama').'\").val(\"$data->nama_pegawai\");
								  $(\"#'.CHtml::activeId($modRencanaLembur,'rencana_nip').'\").val(\"$data->nomorindukpegawai\");
                                  $(\"#dialogPegawaiLembur\").dialog(\"close\");    
                                  return false;
                        "))',
                 * 
                 */
        ),
        /*
            array(
                'header'=>'No.',
                'type'=>'raw',
                'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                'filter'=>false,
            ),
                     * 
                     */
        'nomorindukpegawai',
        'nama_pegawai',
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modPegawaiLembur, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); update_ceklis_pegawai();}',
));

echo CHtml::htmlButton('<i class="entypo-check"></i> Tambah', array('onclick' => 'tambahPegawaiLembur();', 'class' => 'btn btn-primary'));

$this->endWidget();
//========= end Pegawai Lembur dialog =============================
?>

<?php
//========= Dialog buat cari data Pemberi Tugas =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPemberiTugas',
    'options' => array(
        'title' => 'Pencarian Pemberi Tugas',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_KEPEGAWAIAN) {
    $classPegawai = 'PegawaiV';
    $modPemberiTugas = new $classPegawai('search');
    $modPemberiTugas->unsetAttributes();
} else {
    $classPegawai = 'PegawairuanganV';
    $modPemberiTugas = new $classPegawai('search');
    $modPemberiTugas->unsetAttributes();
    $modPemberiTugas->ruangan_id = Yii::app()->user->getState('ruangan_id');
}

// $modPemberiTugas = new PegawaiM('search');
// $modPemberiTugas -> unsetAttributes();
if (isset($_GET[$classPegawai])) {
    $modPemberiTugas->attributes = $_GET[$classPegawai];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pemberitugas-m-grid',
    'dataProvider' => $modPemberiTugas->searchPegawaiRuangan(),
    'filter' => $modPemberiTugas,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                "id" => "selectPemberiTugas",
                                "onClick" => "$(\"#KPRencanaLemburT_pemberitugas_id\").val(\"$data->pegawai_id\");
                                              $(\"#' . CHtml::activeId($modRencanaLembur, 'pemberitugas_nama') . '\").val(\"$data->nama_pegawai\");
                                              $(\"#dialogPemberiTugas\").dialog(\"close\");    
                                              return false;
                                    "))',
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modPemberiTugas, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            }
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Pemberi Tugas dialog =============================
?>