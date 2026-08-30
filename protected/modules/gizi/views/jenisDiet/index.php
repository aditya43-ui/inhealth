<?php
    $this->breadcrumbs=array(
            'Anamnesa',
    );
    $this->widget('bootstrap.widgets.BootAlert');
?>

<?php 
//    if(empty($pasienadmisi_id))
//        $this->renderPartial('/_ringkasDataPasienPendaftaran',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien));
//    else
//        $this->renderPartial('/_ringkasDataPasienPendaftaranRI',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien));
?>
<?php //$this->renderPartial('/_tabulasi', array('modPendaftaran'=>$modPendaftaran)); ?>

<?php
    $this->widget('application.extensions.moneymask.MMask',array(
        'element'=>'.number',
        'config'=>array(
            'defaultZero'=>true,
            'allowZero'=>true,
            'decimal'=>',',
            'thousands'=>'.',
            'precision'=>0,
        )
    ));

    $this->widget('application.extensions.moneymask.MMask',array(
        'element'=>'.numbers',
        'config'=>array(
            'defaultZero'=>true,
            'allowZero'=>true,
            'decimal'=>'.',
            'thousands'=>'.',
            'precision'=>1,
        )
    ));
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php 
    $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'dietpasien-t-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',),
            'focus'=>'#',
    )); 
?>

<?php  
    if(!$modDietPasien->isNewRecord){
?>
    <div class="mds-form-message error">
            <?php Yii::app()->user->setFlash('success',"Data berhasil disimpan"); ?>
    </div>
<?php } ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
	<?php echo $form->errorSummary($modDietPasien); ?>
        <table style="width: 100%; border: none;">
            <tr>
                <td>
                    <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
                    <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>

                    <?php echo CHtml::label('Dokter / Konselor', 'dokter/konselor', array('class' => 'control-label')) ?>
                    <div class="controls"> 
                        <?php 
                                echo CHtml::dropDownList('pegawai_id','pegawai_id', CHtml::listData($modDietPasien->DokterItemsKonsul, 'pegawai_id', 'namaLengkap'), 
                                        array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'empty'=>'-- Pilih --')); 
                        ?>                      

                    </div> 

                </td>
                <td>
                    <?php echo $form->labelEx($modDietPasien, 'tgljenisdiet', array('class' => 'control-label')) ?>
                    <div class="controls">  
                        <?php
                        $this->widget('MyDateTimePicker', array(
        //                    'model' => $modAnamnesa,
        //                    'attribute' => 'tglanamesadiet',
                            'value'=>  MyFormatter::formatDateTimeForUser(date("Y-m-d H:i:s")),
                            'name'=>'tglJenisDiet',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                                //'dateFormat'=>'yy-mm-dd',
                                //'timeFormat'=>'hh:ii:ss',
                            ),
                            'htmlOptions' => array('readonly' => true,
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </div> 

                </td>
            </tr>
            <tr>
                <td>
                    <?php echo CHtml::label('Ahli Gizi', 'Ahli Gizi', array('class' => 'control-label')) ?>
                    <div class="controls"> 
                        <?php 
                                echo CHtml::dropDownList('ahligizi','ahligizi', CHtml::listData($modDietPasien->getAhliGiziItems(), 'pegawai_id', 'namaLengkap'), 
                                        array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'empty'=>'-- Pilih --')); 
                        ?>                      
                       
                    </div>
                    <?php //echo $form->dropDownListRow($modDietPasien,'ahligizi', CHtml::listData($modDietPasien->getAhliGiziItems(), 'pegawai_id', 'nama_pegawai'),
                                                            //array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
            </tr>
        </table>
        <legend class="rim">Pilih Jenis Diet</legend>
        <table>
            <tr>
                <td>
                      <div class="control-group">
                       <?php echo CHtml::label('Jenis Diet','jenisDiet', array('class'=>'control-label')) ?>
                       <div class="controls">
                         <?php echo CHtml::hiddenField('idJenisDiet');?>                            
                        <?php $this->widget('MyJuiAutoComplete',array(
                                        'model'=>$modJenisDiet,
                                        'attribute'=>'jenisdietNama',
                                        'sourceUrl'=> Yii::app()->createUrl('ActionAutoComplete/jenisDiet'),
                                        'options'=>array(
                                           'showAnim'=>'fold',
                                           'minLength' => 2,
                                           'select'=>'js:function( event, ui ) {
                                                      $("#idJenisDiet").val(ui.item.jenisdiet_id);
                                            }',
                                        ),
                                        'htmlOptions'=>array(
                                            'onkeypress'=>"if(event.keyCode == 13 ){submitDietPasien();}return $(this).focusNextInputField(event)",
//                                            'onclick'=>'submitObat(); return false;',
                                            'class'=>'span3',
                                            'placeholder'=>'Jenis Diet',
                                        ),'tombolDialog'=>array('idDialog'=>'dialogJenisDiet'),
                            )); ?>   
                           </div>
                        </div>
                </td>
            </tr>
        </table>
        
<?php
        $this->renderPartial('_formTableDietPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'modJenisDiet'=>$modJenisDiet,'modDietPasien'=>$modDietPasien));
?>

    <div class="form-actions">
        <?php 
            echo CHtml::htmlButton($modDietPasien->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                        array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan')); 
        ?>
        <?php 
            $tips = array(
                '0' => 'waktutime',
                '1' => 'autocomplete-search',
                '2' => 'simpan'
            );
           $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
                      $this->widget('UserTips',array('type'=>'admin','content'=>$content));
        ?>
    </div>
<?php $this->endWidget(); ?>

<?php 
    //========= Dialog buat cari data obatAlkes =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id'=>'dialogJenisDiet',
        'options'=>array(
            'title'=>'Daftar Jenis Diet',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>700,
            'height'=>400,
            'resizable'=>false,
        ),
    ));

    $modJenisdietM = new JenisdietM('search');
    $modJenisdietM->unsetAttributes();
    if(isset($_GET['JenisdietM'])) {
        $modJenisdietM->attributes = $_GET['JenisdietM'];
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'jenisdiet-m-grid',
            //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
            'dataProvider'=>$modJenisdietM->search(),
            'filter'=>$modJenisdietM,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                            array(
                                'header'=>'Pilih',
                                'type'=>'raw',
                                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                                "id" => "selectPasien",
                                                "onClick" => "$(\"#idJenisDiet\").val(\"$data->jenisdiet_id\");
                                                              $(\"#'.CHtml::activeId($modJenisDiet,'jenisdietNama').'\").val(\"$data->jenisdiet_nama\");
                                                            submitDietPasien();
                                                              $(\"#dialogJenisDiet\").dialog(\"close\");    
                                                    "))',
                            ),
                    array(
                        'header'=>'Nama Jenis Diet',
                        'name'=>'jenisdiet_nama',
                        'type'=>'raw',
                        'value'=>'$data->jenisdiet_nama',
                    ),
                    array(
                        'header'=>'Nama Lain Jenis Diet',
                        'name'=>'jenisdiet_namalainnya',
                        'type'=>'raw',
                        'value'=>'$data->jenisdiet_namalainnya',
                    ),
                    array(
                        'header'=>'Keterangan',
                        'name'=>'jenisdiet_keterangan',
                        'type'=>'raw',
                        'value'=>'$data->jenisdiet_keterangan',
                    ),
                    array(
                        'header'=>'Catatan',
                        'name'=>'jenisdiet_catatan',
                        'type'=>'raw',
                        'value'=>'$data->jenisdiet_catatan',
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));

    $this->endWidget();
    //========= end obatAlkes dialog =============================
?>
        
<?php
$urlGetJenisDietPasien = $this->createUrl('getDietPasien');

$jscript = <<< JS
function submitDietPasien()
{
    idJenisDiet = $('#idJenisDiet').val();

    if(idJenisDiet =='')
    {
        myAlert('Silakan pilih jenis diet terlebih dahulu!');
    }else{
            $.post("${urlGetJenisDietPasien}", { idJenisDiet: idJenisDiet,},
            function(data){
                $('#tableDietPasien tbody').append(data.tr);
                $('#tableDietPasien tbody tr:last').find('.numbersOnly').maskMoney({"defaultZero":true,"allowZero":true,"decimal":".","thousands":"","precision":1,"symbol":null});
                setAll(this);
                clear();
            }, "json");
    }   
    clear();
}

function removeJDiet(obj) {
    $(obj).parents('tr').remove();
    clear();
    return false;
}

function clear(){
    $("#GZJenisdietM_jenisdietNama").val("");
    urut = 1;
    $(".noUrut").each(function(){
        $(this).val(urut);
        urut++;
    });
}

function setAll(obj){
    totProtein = 0;
    totEnergiKalori = 0;
    totLemak = 0;
    totHidratArang = 0;
    totBdd = 0;
    totDietKandungan = 0;
    $('.noUrut').each(function(){
              
        dietKandungan = $(this).parents('tr').find('input[name$="[diet_kandungan]"]').val();
        protein = $(this).parents('tr').find('input[name$="[protein]"]').val();
        energiKalori = $(this).parents('tr').find('input[name$="[energikalori]"]').val();
        lemak = $(this).parents('tr').find('input[name$="[lemak]"]').val();
        hidratArang = $(this).parents('tr').find('input[name$="[hidratarang]"]').val();
        bdd = $(this).parents('tr').find('input[name$="[bdd]"]').val();
       
        if (jQuery.isNumeric(dietKandungan)){
            totDietKandungan += parseFloat(dietKandungan);
        }
        if (jQuery.isNumeric(protein)){
            totProtein += parseFloat(protein);
        }
        if (jQuery.isNumeric(energiKalori)){
            totEnergiKalori += parseFloat(energiKalori);
        }
        if (jQuery.isNumeric(lemak)){
            totLemak += parseFloat(lemak);
        }
        if (jQuery.isNumeric(hidratArang)){
            totHidratArang += parseFloat(hidratArang);
        }
        
    });    
    
    $('#totDietKandungan').val(totDietKandungan);
    $('#totEnergiKalori').val(totEnergiKalori);
    $('#totProtein').val(totProtein);
    $('#totLemak').val(totLemak);
    $('#totHidratArang').val(totHidratArang);
}

function setEnergiKalori(obj){
    setAll();
}

function setProtein(obj){
    setAll();
}

function setLemak(obj){
    setAll();
}

function setHidratArang(obj){
    setAll();
}

function setDietKandungan(obj){
    setAll();
}
JS;
            
Yii::app()->clientScript->registerScript('jenidDiet',$jscript, CClientScript::POS_HEAD); ?>