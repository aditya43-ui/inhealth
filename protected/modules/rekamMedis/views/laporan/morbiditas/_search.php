<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));
    ?>
    <style>
        #penjamin,
        #ruangan {
            width: 250px;
        }

        #penjamin label.checkbox,
        #ruangan label.checkbox {
            width: 150px;
            display: inline-block;
        }
    </style>

    <div class="row">
        <div class="col-sm-12">
            <?php echo CHtml::hiddenField('type', ''); ?>
            <div class="control-group">
                <?php echo $form->hiddenField($model, 'jns_periode', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'bln_awal', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'bln_akhir', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'thn_awal', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'thn_akhir', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'diagnosa_id', array('class' => 'span2')); ?>
                <?php echo CHtml::label("Periode Laporan", 'tgl_rekam', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    $insDrop = new CDbCriteria();
                    $insDrop->addCondition(" instalasi_aktif = TRUE ");
                    $insDrop->addInCondition(" instalasi_id ", Params::getArrayInstalasiPelayanan());
                    $insDrop->order = " instalasi_nama ASC ";

                    echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll($insDrop), 'instalasi_id', 'instalasi_nama'), array(
                        'class' => 'form-control', 'multiple' => 'multiple'
                    )); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList(
                        $model,
                        'ruangan_id',
                        array(),
                        array('class' => 'form-control', 'multiple' => 'multiple')
                    ); ?>
                </div>
            </div>
            <?php if($controller === 'LaporanDiagnosaPasien') {?>
                <div class="control-group">
            <?php echo CHtml::label("Pasien", 'pasien_id', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'nama_pasien',
                    'value' => function($data){
                       return $data->nama_pasien;
                    },
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
                        $("#SADokrekammedisM_nama_pasien").val(ui.item.nama_pasien);
                        inputPasien(ui.item.pasien_id, ui.item.nama_pasien);
                        return false;
                    }',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPasien'),
                    'htmlOptions' => array(
                        'class' => 'span3 required', 'placeholder' => 'Nama Pasien', 'rel' => 'tooltip', 'title' => '"Ketik Nama Pasien" / klik icon untuk mencari data pasien', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value===""){ $("#' . CHtml::activeId($model, 'pasien_id') . '").val(""); }'
                    ),
                ));
                ?>
            </div>
        </div>
        <?php
        echo $form->error($model, 'pasien_id');
        echo $form->hiddenField($model, 'pasien_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10));
        ?>
                <?php } else {?>
                    <div class="control-group">
                <?php echo CHtml::label("Diagnosa ", 'diagnosa_nama', array('class' => 'control-label required')); ?>
                    <div class="controls">
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'diagnosa_nama',
                                'value' => $model->diagnosa_nama,
                                'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('AutocompleteDiagnosaNama') . '",
                                    dataType: "json",
                                    data: {
                                        diagnosa_nama: request.term,
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
                                    $("#SADokrekammedisM_diagnosa_nama").val(ui.item.diagnosa_nama);
                                    inputDiagnosa(ui.item.diagnosa_nama);
                                    return false;
                                }',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogDiagnosa'),
                                'htmlOptions' => array(
                                    'class' => 'span3', 'placeholder' => 'Nama Diagnosa', 'rel' => 'tooltip', 'title' => '"Ketik Nama Diagnosa" / klik icon untuk mencari data pasien', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'onblur' => 'if(this.value===""){ $("#' . CHtml::activeId($model, 'diagnosa_nama') . '").val(""); }'
                                ),
                            ));
                        ?>
                        </div>
                    </div>
                    <?php }?>
        </div>
    </div>
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
        );
        ?>
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'konfirmasi()', 'onKeypress' => 'return formSubmit(this,event)')
        );
        ?>
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); 
    ?>

</div>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php
//========= Dialog buat data pasien  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDiagnosa',
    'options' => array(
        'title' => 'Data Diagnosa',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));

    $modDiagnosa = new DiagnosaM();
    $modDiagnosa->unsetAttributes();
    if(isset($_GET['DiagnosaM'])){
        $modDiagnosa->attributes = $_GET['DiagnosaM'];
        $modDiagnosa->diagnosa_nama = $_GET['DiagnosaM']['diagnosa_nama'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'diagnosa-v-grid',
        'dataProvider'=>$modDiagnosa->searchDialog(),
        'filter'=>$modDiagnosa,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectDiagnosa",
                                        "onClick" => "inputDiagnosa($data->diagnosa_id,
                                        \"$data->diagnosa_nama\");return false;"))',
                    ),  
					array(
					'name'=>'diagnosa_nama',
					'type'=>'raw',
					'value'=>'$data->diagnosa_nama'
					),                                                       
        ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); 

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end data pasien =============================
?>

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

    $modPasien = new SAPasienM;
    $modPasien->unsetAttributes();
    if(isset($_GET['SAPasienM'])){
        $modPasien->attributes = $_GET['SAPasienM'];
        $modPasien->nama_pasien = $_GET['SAPasienM']['nama_pasien'];

    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'pasien-v-grid',
        'dataProvider'=>$modPasien->searchDialogRM(),
        'filter'=>$modPasien,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPasien",
                                        "onClick" => "inputPasien($data->pasien_id,
                                        \"$data->nama_pasien\", \'$data->no_rekam_medik\');return false;"))',
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
//========= End Dialog data pasien  =========================
?>
<script>
    function checkAll() {
        if ($('#checkAllRuangan').is(':checked')) {
            $('#searchLaporan input[name*="ruangan_id"]').each(function() {
                $(this).attr('checked', true);
            });
        } else {
            $('#searchLaporan input[name*="ruangan_id"]').each(function() {
                $(this).removeAttr('checked');
            });
        }
    }

    function inputDiagnosa (diagnosa_id ,diagnosa_nama){
        $("#RKLaporanmorbiditasV_diagnosa_id").val(diagnosa_id);
        $("#RKLaporanmorbiditasV_diagnosa_nama").val(diagnosa_nama);
        $("#dialogDiagnosa").dialog('close');
    }

    function inputPasien(pasien_id, namaPasien, noRM) {
        $("#RKLaporanmorbiditasV_pasien_id").val(pasien_id);
        $("#RKLaporanmorbiditasV_nama_pasien").val(namaPasien);
        $("#dialogPasien").dialog('close');
    }
</script>