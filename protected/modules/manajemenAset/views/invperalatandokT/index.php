<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'invperalatandok-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);','onkeyup'=>(!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '','onclick'=>(!isset($_GET['sukses']))? 'cekDisabled(this);' : ''),
    'focus' => '#',
        ));
?>    

<div class="row-fluid">
    <div class="span6">
        <div class="control-group ">
                <?php echo $form->labelEx($model, 'invperalatandok_no', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'invperalatandok_no', array('placeholder'=>'Ketik No. Dokumen','class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group ">
                <?php echo $form->labelEx($model, 'invperalatandok_nama', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'invperalatandok_nama', array('placeholder'=>'Ketik Nama Dokumen','class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::label("Dokumen",'invperalatandok_file');?><span class="required"> *</span>
            </label>
            <div class="controls">
                <?php echo $form->fileField($model, 'invperalatandok_file', array('class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::label("",'invperalatandok_file');?>
            </label>
            <div class="controls">
                <div class="form-actions">
                    <?php
                    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-plus icon-white"></i>')) :
                    Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-plus icon-white"></i>')), array('class' =>(isset($_GET['sukses']))? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)','disabled'=>(isset($_GET['sukses']))? true : false));
                    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
                    ?>
                </div>
            </div>
        </div>
        
    </div>
</div>


<br>
<table width="100%" class="table table-bordered table-striped table-condensed">
    <thead>
        <td style="text-align: center; font-weight: bold">No.</td>            
        <td style="text-align: center; font-weight: bold">No. Dokumen</td>
        <td style="text-align: center; font-weight: bold">Nama Dokumen</td>
        <td style="text-align: center; font-weight: bold">Dokumen</td>
        <td style="text-align: center; font-weight: bold">Hapus</td>
    </thead>
    <tbody>
        <?php
        if(count($modShow) > 0){
            foreach($modShow AS $i=>$value){ 
        ?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo (!empty($value->invperalatandok_no) ? $value->invperalatandok_no : ""); ?></td>
                <td><?php echo (!empty($value->invperalatandok_nama) ? $value->invperalatandok_nama: ""); ?></td>
                <td style="text-align: center"><?php echo !empty($value->invperalatandok_file) ? CHtml::link($value->invperalatandok_file,$this->createUrl('Unduh',array('id'=>$value->invperalatandok_id)),array('title'=>'Download Dokumen','rel'=>'tooltip')) : "";?></td>
                <td style="text-align: center">
                    <?php echo CHtml::link("<i class='glyphicon glyphicon-trash'></i> ", "javascript:deleteRecord(".$value->invperalatandok_id.")",array("id"=>"$value->invperalatandok_id","rel"=>"tooltip","title"=>"Hapus"));?>
            </tr>
        <?php    
            }
        }
        ?>
    </tbody>
</table>
<?php $this->endWidget(); ?>
<?php
/* ====================================== Widget Dialog Nama Pelaksana ====================================== */
    
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id'=>'dialogPegawai',
        'options'=>array(
            'title'=>'Daftar Kegiatan',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>900,
            'height'=>400,
            'resizable'=>false,
            ),
    ));
   
$modPegawai = new PegawaiM('search');
$modPegawai->unsetAttributes();
if(isset($_GET['PegawaiM'])) {
    $modPegawai->attributes = $_GET['PegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawai-m-grid',
    'dataProvider'=>$modPegawai->search(),
    'filter'=>$modPegawai,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                        array(
                            "class"=>"btn-small",
                            "id" => "subkegiatanprogram",
                            "onClick" => "\$(\"#MAInvperizinanT_pelaksana_id\").val($data->pegawai_id);
                                          \$(\"#pelaksana\").val(\"$data->nama_pegawai\");
                                          \$(\"#pelaksana_id\").val(\"$data->pegawai_id\");

                                          \$(\"#dialogPegawai\").dialog(\"close\");"

                         )
                     )',
                ),
                'nama_pegawai',
                
    ),
        'afterAjaxUpdate'=>'function(id, data){
            // $("#kategoritindakan_id").val($("#idKategori").val());
        jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
/* ====================================== endWidget Dialog Nama Pelaksana ====================================== */
?>
<script>
function myFunction() {
    var x = document.getElementById("lampiran2");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}
function myFunction2() {    
    var x = document.getElementById("lampiran3");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

    function deleteRecord(id){
        var id = id;

        console.log(id);
        var url = '<?php echo $url."/delete"; ?>';
        myConfirm('Apakah anda yakin untuk menghapus data ini ?','Perhatian!',function(r){
            if (r){
                $.post(url, {id: id},
                function(data){
                    if(data.status == 'sukses'){
                        window.location.reload();
                    }else{
                        myAlert('Data Gagal di Hapus')
                    }
                },"json");
            }
        });
    }
</script>