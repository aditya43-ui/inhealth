<div class = "col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label("Kosong Tanpa Listrik", 'kosongtanpalistrik', array('class'=>'control-label')); ?>
        &emsp;&emsp;
        <?php echo CHtml::activeTextField($model, 'kosongtanpalistrik_suhu', array('class'=>'span1 desimal')); ?> &#8451;
        <div class="controls inline">
            <?php
            $this->widget('MyDateTimePicker',array(
            'model'=>$model,
            'attribute'=>'kosongtanpalistrik',
            'mode'=>'time',
            'options'=> array(
                'showOn' => false,
                'yearRange'=> "-150:+0",
                    'dateFormat' => Params::DATE_FORMAT,
                ),
            'htmlOptions'=>array('placeholder'=>'00:00:00','class'=>'dtPicker2 span2 monitor', 'onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'width:70px;'
            ),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Kosong Dengan Listrik", 'kosongdenganlistrik', array('class'=>'control-label')); ?>
        &emsp;&emsp;
        <?php echo CHtml::activeTextField($model, 'kosongdenganlistrik_suhu', array('class'=>'span1 desimal')); ?> &#8451;
        <div class="controls inline">
            <?php
            $this->widget('MyDateTimePicker',array(
            'model'=>$model,
            'attribute'=>'kosongdenganlistrik',
            'mode'=>'time',
            'options'=> array(
                'showOn' => false,
                'yearRange'=> "-150:+0",
                    'dateFormat' => Params::DATE_FORMAT,
                ),
            'htmlOptions'=>array('placeholder'=>'00:00:00','class'=>'dtPicker2 span2 monitor', 'onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'width:70px;'
            ),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Listrik dan Ice Pack", 'listrikdanicepack', array('class'=>'control-label')); ?>
        &emsp;&emsp;
        <?php echo CHtml::activeTextField($model, 'listrikdanicepack_suhu', array('class'=>'span1 desimal')); ?> &#8451;
        <div class="controls inline">
            <?php
            $this->widget('MyDateTimePicker',array(
            'model'=>$model,
            'attribute'=>'listrikdanicepack',
            'mode'=>'time',
            'options'=> array(
                'showOn' => false,
                'yearRange'=> "-150:+0",
                    'dateFormat' => Params::DATE_FORMAT,
                ),
            'htmlOptions'=>array('placeholder'=>'00:00:00','class'=>'dtPicker2 span2 monitor', 'onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'width:70px;'
            ),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Mulai Isi Kantong Darah", 'mulaiisikantong', array('class'=>'control-label')); ?>
        &emsp;&emsp;
        <?php echo CHtml::activeTextField($model, 'mulaiisikantong_suhu', array('class'=>'span1 desimal')); ?> &#8451;
        <div class="controls inline">
            <?php
            $this->widget('MyDateTimePicker',array(
            'model'=>$model,
            'attribute'=>'mulaiisikantong',
            'mode'=>'time',
            'options'=> array(
                'showOn' => false,
                'yearRange'=> "-150:+0",
                    'dateFormat' => Params::DATE_FORMAT,
                ),
            'htmlOptions'=>array('placeholder'=>'00:00:00','class'=>'dtPicker2 span2 monitor', 'onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'width:70px;'
            ),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Setelah Diisi Kantong Darah", 'setelahdiisikantong', array('class'=>'control-label')); ?>
        &emsp;&emsp;
        <?php echo CHtml::activeTextField($model, 'setelahdiisikantong_suhu', array('class'=>'span1 desimal')); ?> &#8451;
        <div class="controls inline">
            <?php
            $this->widget('MyDateTimePicker',array(
            'model'=>$model,
            'attribute'=>'setelahdiisikantong',
            'mode'=>'time',
            'options'=> array(
                'showOn' => false,
                'yearRange'=> "-150:+0",
                    'dateFormat' => Params::DATE_FORMAT,
                ),
            'htmlOptions'=>array('placeholder'=>'00:00:00','class'=>'dtPicker2 span2 monitor', 'onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'width:70px;'
            ),
            )); ?>
        </div>
    </div>
</div>
<div class = "col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label("Lepas Listrik", 'lepaslistrik', array('class'=>'control-label')); ?>
        &emsp;&emsp;
        <?php echo CHtml::activeTextField($model, 'lepaslistrik_suhu', array('class'=>'span1 desimal')); ?> &#8451;
        <div class="controls inline">
            <?php
            $this->widget('MyDateTimePicker',array(
            'model'=>$model,
            'attribute'=>'lepaslistrik',
            'mode'=>'time',
            'options'=> array(
                'showOn' => false,
                'yearRange'=> "-150:+0",
                    'dateFormat' => Params::DATE_FORMAT,
                ),
            'htmlOptions'=>array('placeholder'=>'00:00:00','class'=>'dtPicker2 span2 monitor', 'onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'width:70px;'
            ),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Kirim ke Lab ITD", 'kirimkelabitd', array('class'=>'control-label')); ?>
        &emsp;&emsp;
        <?php echo CHtml::activeTextField($model, 'kirimkelabitd_suhu', array('class'=>'span1 desimal')); ?> &#8451;
        <div class="controls inline">
            <?php
            $this->widget('MyDateTimePicker',array(
            'model'=>$model,
            'attribute'=>'kirimkelabitd',
            'mode'=>'time',
            'options'=> array(
                'showOn' => false,
                'yearRange'=> "-150:+0",
                    'dateFormat' => Params::DATE_FORMAT,
                ),
            'htmlOptions'=>array('placeholder'=>'00:00:00','class'=>'dtPicker2 span2 monitor', 'onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'width:70px;'
            ),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Sampai di Lab ITD", 'sampaidilabitd', array('class'=>'control-label')); ?>
        &emsp;&emsp;
        <?php echo CHtml::activeTextField($model, 'sampaidilabitd_suhu', array('class'=>'span1 desimal')); ?> &#8451;
        <div class="controls inline">
            <?php
            $this->widget('MyDateTimePicker',array(
            'model'=>$model,
            'attribute'=>'sampaidilabitd',
            'mode'=>'time',
            'options'=> array(
                'showOn' => false,
                'yearRange'=> "-150:+0",
                    'dateFormat' => Params::DATE_FORMAT,
                ),
            'htmlOptions'=>array('placeholder'=>'00:00:00','class'=>'dtPicker2 span2 monitor', 'onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'width:70px;'
            ),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Nama Petugas Monitoring <span class='required'>*</span>", 'petugasmonitoring_id', array('class'=>'control-label')); ?>
            <div class="controls">
                        <?php
                        echo $form->hiddenField($model,'petugasmonitoring_id',array('class'=>'span3','placeholder'=>'Ketik Nama Petugas')); 
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'petugasmonitoring_nama',
                            'source' => 'js: function(request, response) {
					$.ajax({
					url: "' . Yii::app()->createUrl('ActionAutoComplete/PegawaiRuangan') . '",
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
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
							$(this).val( ui.item.label);
							return false;
						}',
                                'select' => 'js:function( event, ui ) {
							$("#' . Chtml::activeId($model, 'petugasmonitoring_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'Ketik Nama Petugas Monitoring', 
                                'class' => 'span3 required',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'petugasmonitoring_id') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPegawai'),
                        ));
                        ?>
                    </div>
        </div>
    <div class="control-group">
        <?php echo CHtml::label("Keterangan", 'ket_monitoring', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextArea($model, 'ket_monitoring', array('class'=>'span3 monitor')); ?>
        </div>
    </div>
</div>
<?php
/**
 * Dialog untuk nama Pegawai
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawai',
    'options'=>array(
        'title'=>'Daftar Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>650,
        'resizable'=>false,
    ),
));
$modPegawai = new PegawairuanganV('searchPegawaiCRU');
$modPegawai->unsetAttributes();
if (isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
    $modPegawai->unitkerja_id = $_GET['PegawairuanganV']['unitkerja_id'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaiCRU-grid',
    'dataProvider' => $modPegawai->searchPegawaiCRU(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $res = CJSON::encode($data->attributes);
    
                return CHtml::Link("<i class='icon-form-check'></i>","#",array("class"=>"btn-small", 
                                "id" => "selectpegawai",
                                "onClick" => "
                                    $('#BDMonitoringkantongT_petugasmonitoring_id').val($data->pegawai_id);
                                    $('#petugasmonitoring_nama').val('".$data->namaLengkap."');
                                    $('#dialogPegawai').dialog('close');
                                    return false;"));
            },
        ),
        array(
            'header' => 'NIP',
            'filter' => CHtml::activeTextField($modPegawai, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPegawai, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function($data){
                        $hasil ='';
                        $j = JabatanM::model()->findByPk($data->jabatan_id);
                                
                        if (!empty($j)){
                            $hasil = $j->jabatan_nama;
                        }
                            return $hasil;
            },
            'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
        array(
                    'header'=>'Unit Kerja',
                    'filter'=>  CHtml::activeDropDownList($modPegawai, 'unitkerja_id', CHtml::listData(UnitkerjaM::model()->findAll("unitkerja_aktif = TRUE ORDER BY namaunitkerja ASC"), 'unitkerja_id', 'namaunitkerja'),array('empty'=>'-- Pilih --')),
                    'value'=> function($data){
                        $j = UnitkerjaM::model()->findByPk($data->unitkerja_id);

                        if (!empty($j)){
                            return $j->namaunitkerja;
                        }else{
                            return '-';
                        }
                    }   
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>        