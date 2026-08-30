<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-user"></i> Data <b>Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <form class="form-horizontal">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("No Rekam Medik", '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien,'no_rekam_medik',array('readonly'=>true)) ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Nama Pasien <span class='required'>*</span>", '', array('class' => 'control-label required')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeHiddenField($modPasien,'pasien_id'); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modPasien,
                            'attribute' => 'nama_pasien',
                            'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('AutocompleteNamaPasien') . '",
                                dataType: "json",
                                data: {
                                    nama_pasien: request.term,
                                },
                                success: function (data) {
                                    response(data);
                                }
                            })
                        }',
                            'options' => array(
                                'minLength' => 1,
                                'focus' => 'js:function( event, ui ) {
                                $(this).val("");
                                return false;
                            }',
                                'select' => 'js:function( event, ui ) {
                                $(this).val(ui.item.value);
                                $("#SADokrekammedisM_pasien_id").val(ui.item.pasien_id);
                                inputPasien(ui.item.pasien_id, ui.item.nama_pasien, ui.item.no_rekam_medik);
                                return false;
                            }',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPasien'),
                            'htmlOptions' => array(
                                'class' => 'span3 required', 'placeholder' => 'Nama Pasien', 'rel' => 'tooltip', 'title' => '"Ketik Nama Pasien" / klik icon untuk mencari data pasien', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value===""){ $("#' . CHtml::activeId($modPasien, 'pasien_id') . '").val(""); }'
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Tanggal Lahir", '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien,'tanggal_lahir',array('readonly'=>true)) ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Jenis Kelamin", '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien,'jeniskelamin',array('readonly'=>true)) ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Alamat", '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextArea($modPasien,'alamat_pasien',array('readonly'=>true)) ?>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>

<?php
//========= Dialog buat data pasien  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));
$modDataPasien = new RKPasienM();
$modDataPasien->unsetAttributes();
if(isset($_GET['RKPasienM'])){
    $modDataPasien->attributes = $_GET['RKPasienM'];
}
    
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pasien-v-grid',
    'dataProvider'=>$modDataPasien->searchDialogRekamMedik(),
    'filter'=>$modDataPasien,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>function($data){
                        $data->tanggal_lahir = MyFormatter::formatDateTimeForUser($data->tanggal_lahir);
                        return CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                        "id" => "selectPasien",
                        "onClick" => "setDataPasien($data->pasien_id,
                        \"$data->nama_pasien\", \"$data->no_rekam_medik\", \"$data->tanggal_lahir\", \"$data->jeniskelamin\", \"$data->alamat_pasien\");return false;"));
                    },
                    // 'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                    //                 "id" => "selectPasien",
                    //                 "onClick" => "inputPasien($data->pasien_id,
                    //                 \"$data->nama_pasien\", \'$data->no_rekam_medik\');return false;"))',
                ),  
                array(
                'name'=>'no_rekam_medik',
                'type'=>'raw',
                'value'=>'$data->no_rekam_medik'
                ),
                array(
                'name'=>'nama_pasien',
                'type'=>'raw',
                'value'=>'isset($data->namadepan)?$data->namadepan." ".$data->nama_pasien:$data->nama_pasien',
                ),
                array(
                    'header' => 'Jenis Kelamin',
                    'name'=>'jeniskelamin',					
                    'value'=>'$data->jeniskelamin',
                    'filter' => CHtml::dropDownList('SAPasienM[jeniskelamin]',$modPasien->jeniskelamin,LookupM::getItems("jeniskelamin"),array('empty'=>'-- Pilih --'))    
                ),                                                            
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end data pasien =============================
?>