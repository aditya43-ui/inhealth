<style>
.tbl-visual {
    width: 100%l
}

.tbl-visual tr,
.tbl-visual td {
    border: 1px solid black;
}
</style>
<div class="panel-heading">
    <div class="panel-title">Rujukan</div>
</div>
<div class="panel-body">
    <!--- MULAI RUJUKAN --->
    <label>
        <p style="font-weight: bold"> Data Dokter Pengirim </p>
    </label>
    <div class="control-group">
        <?php echo CHtml::label("Nama DPJP <span class='required'>*</span> ", '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->hiddenField($modKirimKeUnitLain, 'pegawai_id', array('class' => 'span3 dokter_id3')) ?>
            <?php
    // var_dump($modKirimKeUnitLain->dpjp_nama);die;
        $this->widget('MyJuiAutoComplete', array(
            'name' => 'dpjp_nama',
            'value' => isset($modKirimKeUnitLain->pegawai_id) ? $modKirimKeUnitLain->pegawai->nama_pegawai : '-',
            'source' => 'js: function(request, response) {
                           $.ajax({
                               url: "' . $this->createUrl('AutocompletePetugas') . '",
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
                                        $(this).val("");
                                        return false;
                                    }',
                'select' => 'js:function( event, ui ) {
                                $(this).val(ui.item.value);
                                $("#dpjp_nama").val(ui.item.nama_pegawai);
                                $("#' . CHtml::activeId($modKirimKeUnitLain, 'pegawai_id') . '").val(ui.item.pegawai_id);
                                return false;
                        }',
            ),
            'htmlOptions' => array(
                'onkeyup' => "return $(this).focusNextInputField(event)",
                'class' => 'span3 dokter_nama3',
            ),
            'tombolDialog' => array('idDialog' => 'dialogDokter3'),
        ));
        ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Nama PPDS</label>
        <div class="controls">
            <?php echo $form->hiddenField($modKirimKeUnitLain, 'ppds_id', array('class' => 'span3 ppds_id3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modKirimKeUnitLain,
                    'attribute' => 'ppds_nama',
                    'source' => 'js: function(request, response) {
                            $.ajax({
                                    url: "' . $this->createUrl('/actionAutoComplete/PPDS') . '",
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
                        'select' => 'js:function( event, ui ) {
                                    $(this).val( ui.item.ppds_nama );
                                    $(".ppds_id3").val( ui.item.ppds_id);
                                    setPpds(ui.item.ppds_id);
                                    return false;
                        }',
                    ),
                    'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 ppds_nama3', 'placeholder' => 'Ketikkan Nama PPDS  '),
                    'tombolDialog' => array('idDialog' => 'dialogPpds3', 'idTombol' => 'tombolPpds'),
                ));
            ?>
        </div>
    </div>

    <label>
        <p style="font-weight: bold"> Informasi Sampel </p>
    </label>
    <div class="control-group">
        <label class="control-label required" for="RJPasienKirimKeUnitLainT_tgl_kirimpasien">
            Tanggal Permintaan
            <span class="required">*</span>
        </label>
        <?php $modKirimKeUnitLain->tgl_kirimpasien = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modKirimKeUnitLain->tgl_kirimpasien, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
        <div class="controls">
            <?php   
					$this->widget('MyDateTimePicker',array(
						'model'=>$modKirimKeUnitLain,
						'attribute'=>'tgl_kirimpasien',
						'mode'=>'datetime',
						'options'=> array(
							'dateFormat'=>Params::DATE_FORMAT,
							'maxDate' => 'd',
						),
						'htmlOptions'=>array('readonly'=>true, 'class'=>'realtime'),
				)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Tanggal Pengambilan Sampel</label>
        <div class="controls">
            <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modKirimKeUnitLain,
                            'attribute' => 'waktuambilspesimen',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 'class' => 'dtPicker1', 'onkeypress' => "return $(this).focusNextInputField(event)", 'width' => '140px;'
                            ),
                        ));
                        ?>
            <?php echo $form->error($modKirimKeUnitLain, 'waktuambilspesimen'); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Jenis Sampel <span class="required">*</span></label>
        <div class="controls">
            <?php echo $form->dropDownList($modPenunjang2, 'samplelab_id_hiv', CHtml::listData(SamplelabM::model()->findAll('is_hiv = true'), 'samplelab_id', 'samplelab_nama'), array('readonly'=>false,'empty' => '-- Pilih --','class' => 'span3 ', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Keterangan</label>
        <div class="controls">
            <?php echo $form->textField($modKirimKeUnitLain, 'catatandokterpengirim', array('class' => 'span3', 'readonly' => false, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>

    <div class='control-group'>
        <?php echo CHtml::label("Cyto", CHtml::activeId($modKirimKeUnitLain, 'is_cito'), array('class' => 'control-label')) ?>
        <div class='controls'>
            <?php echo CHtml::activeDropDownList($modKirimKeUnitLain, 'is_cito', array('0'=>'Biasa','1'=>'Cyto'), array('onchange'=>'','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span3')); ?>
        </div>
    </div>


</div>

<script></script>