<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'catatanobatpasien-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
    ));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->hiddenField($model, 'pendaftaran_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pasien_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>


<?php echo $form->errorSummary($model); ?>
<?php $labelRiwayat = ((Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RI || Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_VK)? "Injeksi/ Infus":""); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Riwayat Catatan Pemberian Obat</div>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Obat</th>
                    <th>Jenis Obat</th>
                    <th>Dosis</th>
                    <th>Aturan Pakai</th>
                    <th>Cara Pemberian</th>
                    <!-- <th>Jam Pemberian</th>-->
                    <th>Pemberian Obat Detail</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($riwayat_infus as $data){?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $data->obatalkes->obatalkes_nama; ?></td>
                        <td><?php echo $data->jenisinfus; ?></td>
                        <td><?php echo $data->dosisobat; ?></td>
                        <td><?php echo $data->aturanpakaiobat; ?></td>
                        <td><?php echo $data->carapemberian; ?></td>
                        <td>
                            <?php echo CHtml::link("<i class='icon-form-lihat'></i>", 'javascript:void(0);', array('onclick'=>'viewDetailKonsul('.$data->catatanpemberianobat_id.');return false;','rel'=>'tooltip','title'=>'Klik untuk melihat detail catatan pemberian obat')); ?>
                        </td>
                        <td><?php echo CHtml::link('<i class="icon-form-ubah"></i>', $this->createUrl('create', array('pendaftaran_id'=>$kunjungan->pendaftaran_id, 'pasienadmisi_id'=>$kunjungan->pasienadmisi_id, 'id'=>$data->catatanpemberianobat_id,'type'=>(!empty($_GET['type'])?$_GET['type']:""),'frame'=>(!empty($_GET['frame'])?$_GET['frame']:""))), array(
                            'rel'=>'tooltip', 'title'=>'Ubah Catatan'
                            )); ?>
                            <?php echo CHtml::link('<i class="icon-form-silang"></i>', 'javascript:void(0);', array(
                                'rel'=>'tooltip', 'title'=>'Hapus Catatan', 'onclick'=>'hapusCatatan('.$data->catatanpemberianobat_id.')',
                            )); ?>
                        </td>
                    </tr>
                <?php $no++;} ?>

            </tbody>
        </table>
        <div class="row-fluid">
      	<div class="form-actions">
          <?php
                // $cekData = EdukasiterintegrasiT::model()->findByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id));
                // if(!empty($cekData)){
                        echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}'=>'<i class="icon-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-default','onclick'=>"print('$model->pendaftaran_id','PRINT','obat');return false"));
                // }else{
                //         echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}'=>'<i class="icon-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-default','disabled'=>true));
                // }
          ?>
      	</div>
      </div>
    </div>
</div>

<?php if(Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RI || Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_VK){ ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Riwayat Catatan Pemberian Obat Oral dan Obat Luar</div>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Obat</th>
                    <th>Jenis Obat</th>
                    <th>Dosis</th>
                    <th>Aturan Pakai</th>
                    <th>Cara Pemberian</th>
                    <th>Pemberian Obat Detail</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($riwayat_oral as $data){?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $data->obatalkes->obatalkes_nama; ?></td>
                        <td><?php echo $data->jenisinfus; ?></td>
                        <td><?php echo $data->dosisobat; ?></td>
                        <td><?php echo $data->aturanpakaiobat; ?></td>
                        <td><?php echo $data->carapemberian; ?></td>
                        <td>
                            <?php echo CHtml::link("<i class='icon-form-lihat'></i>", 'javascript:void(0);', array('onclick'=>'viewDetailKonsul('.$data->catatanpemberianobat_id.');return false;','rel'=>'tooltip','title'=>'Klik untuk melihat detail catatan pemberian obat')); ?>
                        </td>
                        <td><?php echo CHtml::link('<i class="icon-form-ubah"></i>', $this->createUrl('create', array('pendaftaran_id'=>$kunjungan->pendaftaran_id, 'pasienadmisi_id'=>$kunjungan->pasienadmisi_id, 'id'=>$data->catatanpemberianobat_id,'type'=>(!empty($_GET['type'])?$_GET['type']:""),'frame'=>(!empty($_GET['frame'])?$_GET['frame']:""))), array(
                            'rel'=>'tooltip', 'title'=>'Ubah Catatan'
                            )); ?>
                            <?php echo CHtml::link('<i class="icon-form-silang"></i>', 'javascript:void(0);', array(
                                'rel'=>'tooltip', 'title'=>'Hapus Catatan', 'onclick'=>'hapusCatatan('.$data->catatanpemberianobat_id.')',
                            )); ?>
                        </td>
                    </tr>
                <?php $no++;} ?>

            </tbody>
        </table>
        <div class="row-fluid">
      	<div class="form-actions">
          <?php
                // $cekData = EdukasiterintegrasiT::model()->findByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id));
                // if(!empty($cekData)){
                        echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}'=>'<i class="icon-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-default','onclick'=>"print('$model->pendaftaran_id','PRINT','luar');return false"));
                // }else{
                //         echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}'=>'<i class="icon-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-default','disabled'=>true));
                // }
          ?>
      	</div>
      </div>
    </div>
</div>
<?php } ?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Catatan Pemberian Obat</div>
    </div>
    <div class="panel-body">


        <div class="row-fluid">

            <div class="col-sm-6">
              <div class="control-group ">
                  <?php echo CHtml::label('Jenis Resep', '', array('class' => 'control-label required')) ?>
                  <div class="controls">
                  <?php echo $form->dropDownList($model, 'jenisresep', array('Obat Racikan'=>'Obat Racikan','Obat Non Racikan'=>'Obat Non Racikan'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'onchange'=>'changeJenisResep()')); ?>
                  </div>
              </div>
                <div class="control-group ">
                        <?php echo $form->labelEx($model, 'obatalkes_id', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->hiddenField($model, 'obatalkes_id', array('id' => 'obatalkes_id', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'obatalkes_nama',
                                'source' => 'js: function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('autocompleteObatalkes') . '",
                                            dataType: "json",
                                            data: {
                                                term: request.term,
                                                pendaftaran_id : $("#'.CHtml::activeId($model, 'pendaftaran_id').'").val(),
                                                jenisresep : $("#'.CHtml::activeId($model, 'jenisresep').'").val()
                                            },
                                            success: function (data) {
                                                response(data);
                                            }
                                        })
                                    }',
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
                                            $(this).val("");
                                            return false;
                                        }',
                                    'select' => 'js:function( event, ui ) {
                                            $(this).val(ui.item.value);
                                            $("#obatalkes_id").val(ui.item.obatalkes_id);
                                            $("#obatalkes_nama").val(ui.item.obatalkes_nama);
                                            return false;
                                        }',
                                ),
                                'htmlOptions' => array(
                                    'id' => 'obatalkes_nama',
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'class' => 'span3'
                                ),
                                    'tombolDialog' => array('idDialog' => 'dialogObatAlkes'),
                            ));
                            ?>

                        </div>
                    </div>
                    <div class="control-group">                
                        <label class="control-label">Cairan Masuk</label>
                        <div class="controls">
                            <?php echo $form->radioButton($model,'cairanmasuk',array('uncheckValue'=>null,'value'=>true, 'onchange'=>'changeCairan(this);')); ?>
                        </div>
                        <div class="controls">
                            <label>Ya</label>
                        </div>
                        <div class="controls">
                            <?php echo $form->radioButton($model,'cairanmasuk',array('uncheckValue'=>null,'value'=>false, 'onchange'=>'changeCairan(this);')); ?>
                        </div>
                        <div class="controls">
                            <label>Tidak</label>
                        </div>
                        <div>
                        
                        </div>
                    </div>
                    <?php echo $form->dropDownListRow($model, 'jeniscairanmasuk', array('Enternal'=>'Enternal','Parental'=>'Parental'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>

                <div class="control-group">
                    <label class="control-label">Alergi Obat</label>
                    <div class="controls">
                        <?php echo $form->radioButton($model,'isalergiobat',array('uncheckValue'=>null,'value'=>true, 'onchange'=>'changeAlergi(this);')); ?>
                    </div>
                    <div class="controls">
                        <label>Ada</label>
                    </div>
                    <div class="controls">
                        <?php echo $form->radioButton($model,'isalergiobat',array('uncheckValue'=>null,'value'=>false, 'onchange'=>'changeAlergi(this);')); ?>
                    </div>
                    <div class="controls">
                        <label>Tidak</label>
                    </div>
                    <div>

                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->label($model, '', array('class' => 'control-label')) ?>
                    <div class="controls">
                    <?php echo $form->textArea($model, 'riwayatalergiobat', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    </div>
                </div>



                <?php //echo $form->textFieldRow($model, 'dosisobat', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <div class="control-group">
                    <!-- <label class="control-label">Dosis</label> -->
                    <div class="controls">
                        <?php echo $form->textFieldRow($model, 'dosisobat', array('disabled' => false, 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1 float2', 'onblur' => 'hitungJumlahObat()', 'style' => 'width:80px;')) ?>
                    </div>
                    <div class="controls">
                        <?php echo CHtml::dropDownList('', '', LookupM::getItems('satuankekuatan'), array('id' => 'satuan_kekuatan_reseptur', 'class' => 'inputFormTabel span1', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:80px;')); ?>
                    </div>
                </div>

                <?php //echo $form->textFieldRow($model, 'aturanpakaiobat', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <div class="control-group">
                    <label class="control-label">Aturan Pakai</label>
                    <div class="controls">
                        <?php // echo CHtml::dropDownList('etiketracikan', '', LookupM::getItems('etiket'),array('style'=>'width:150px;')); 
                        ?>
                        <?php echo $form->dropDownList($model, 'aturanpakaiobat', LookupM::getItems('etiket_1'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
                        <?php echo $form->dropDownList($model, 'aturanpakaiobat', LookupM::getItems('etiket_2'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
                        <?php echo $form->dropDownList($model, 'aturanpakaiobat',LookupM::getItems('etiket_3'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
                        <?php echo $form->dropDownList($model, 'aturanpakaiobat', LookupM::getItems('etiket_4'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
                    </div>
                </div>

                <?php echo $form->dropDownListRow($model, 'jadwalpemberianobat', LookupM::getItems('jadwalpemberianobat'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>

            </div>
            <div  class="col-sm-6">
              <div class="control-group ">
                  <?php echo CHtml::label('Jenis Obat <span class="required">*</span>', '', array('class' => 'control-label required')) ?>
                  <div class="controls">
                  <?php echo $form->dropDownList($model, 'jenisinfus', LookupM::getItems('jenisinfus'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                  </div>
              </div>

                <?php echo $form->textFieldRow($model, 'carapemberian', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <div class="control-group ">
                    <?php echo $form->label($model, 'keteragan', array('class' => 'control-label','label'=>'Keterangan atau Rekasi Obat')) ?>
                    <div class="controls">
                    <?php echo $form->textArea($model, 'keteragan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    </div>
                </div>

                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'pegawai_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'pegawai_id', array('id' => 'pegawai_id', 'class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'petugaspengisi_nama',
                            'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . $this->createUrl('autocompletePetugas') . '",
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
                                'focus' => 'js:function( event, ui ) {
                                        $(this).val("");
                                        return false;
                                    }',
                                'select' => 'js:function( event, ui ) {
                                        $(this).val(ui.item.value);
                                        $("#pegawai_id").val(ui.item.pegawai_id);
                                        $("#petugaspengisi_nama").val(ui.item.namaLengkap);
                                        return false;
                                    }',
                            ),
                            'htmlOptions' => array(
                                'id' => 'petugaspengisi_nama',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'class' => 'span3'
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPegawai'),
                        ));
                        ?>
                    </div>
                </div>

            </div>

        </div>
        <br/>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Catatan Pemberian Obat</div>
            </div>
            <div class="panel-body">


                <div class="row-fluid">

                    <div class="col-sm-6">
                        <div class="control-group ">
                            <?php echo CHtml::label('Tanggal Pemberian','', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'id' => 'tanggal_pemberian',
                                    'name' => 'tanggal_pemberian',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span2', 'onclick' => "return $(this).focusNextInputField(event)"),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo CHtml::label('Jam Pemberian','', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'id' => 'jam_pemberian',
                                    'name' => 'jam_pemberian',
                                    'mode' => 'time',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span2', 'onclick' => "return $(this).focusNextInputField(event)"),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo CHtml::label('Waktu Monitoring','', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo CHtml::dropDownList('waktu_monitoring','', LookupM::getItems('jammonitoring'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group ">
                            <?php echo CHtml::label('Tanda','', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo CHtml::dropDownList('tanda','', LookupM::getItems('tandapemberianobat'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo CHtml::label('Initial Pemberi','', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo CHtml::textField('initial','', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            </div>
                        </div>

                        <div class="control-group ">
                        <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                        <?php
                                        echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
                                            array('onclick' => 'inputDetailObat();',
                                                'class' => 'btn btn-primary',
                                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                                'rel' => "tooltip",
                                                'title' => "Klik untuk menambahkan detail pemberian obat",));
                                        ?>
                                    </div>
                            </div>
                    </div>
                </div>

                <table width="100%" id ="riwayatobat" class = "table table-bordered table-striped table-condensed">
                    <thead>
                        <tr>
                            <th>Tanggal Pemberian</th>
                            <th>Jam Pemberian</th>
                            <th>Waktu Monitoring</th>
                            <th>Tanda</th>
                            <th>Initial</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (!empty($model->catatanpemberianobat_id)){
                    $modPemberianObatDet = CatatanpemberianobatdetT::model()->findAllByAttributes(array('catatanpemberianobat_id'=>$model->catatanpemberianobat_id));
                    if (count($modPemberianObatDet) > 0){
                        foreach ($modPemberianObatDet as $i=>$data){?>
                            <tr>
                                <td> <?php echo Chtml::activeHiddenField($data, '['.$i.']tanggal_pemberian', array('class'=>'', 'readonly'=>TRUE)); echo MyFormatter::formatDateTimeForUser($data->tanggal_pemberian); ?> </td>
                                <td> <?php echo Chtml::activeHiddenField($data, '['.$i.']jam_pemberian', array('class'=>'', 'readonly'=>TRUE)); echo $data->jam_pemberian; ?> </td>
                                <td> <?php echo Chtml::activeHiddenField($data, '['.$i.']tanda', array('class'=>'', 'readonly'=>TRUE)); echo $data->tanda; ?> </td>
                                <td> <?php echo Chtml::activeHiddenField($data, '['.$i.']initial', array('class'=>'', 'readonly'=>TRUE)); echo $data->initial; ?> </td>
                                <td style="text-align:center;"><?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick'=>'delRow(this); return false;')) ?></td>
                            </tr>
                        <?php }
                    }}?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
<div class="row-fluid">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')),
            $this->createUrl('create', array('pendaftaran_id' => $kunjungan->pendaftaran_id, 'pasienadmisi_id' => $kunjungan->pasienadmisi_id,'type'=>(!empty($_GET['type'])?$_GET['type']:""),'frame'=>(!empty($_GET['frame'])?$_GET['frame']:""))),
            array('class' => 'btn btn-danger',
                'onclick' => 'return refreshForm(this);'));
        ?>
        <?php // echo CHtml::link(Yii::t('mds','{icon} Pengaturan CatatanobatpasienT',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));  ?>
        <?php $this->widget('UserTips', array('content' => '')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>




<?php
//===============Dialog buat pegawai
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Pencarian Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 450,
        'resizable' => false,
    ),
));

$modPetugas = new PegawairuanganV('searchDialogPegRuangan');
$modPetugas->unsetAttributes();

$modPetugas->pegawai_aktif = true;
if (isset($_GET['PegawairuanganV'])) {
    $modPetugas->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-m-grid',
    'dataProvider' => $modPetugas->searchDialogPegRuangan(),
    'filter' => $modPetugas,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"$(\"#pegawai_id\").val(\"".$data->pegawai_id."\");
                            $(\"#petugaspengisi_nama\").val(\"".$data->namaLengkap."\");
                            $(\"#dialogPegawai\").dialog(\"close\");
                            return false;"
                ))'
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => Chtml::activeTextField($modPetugas, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => Chtml::activeTextField($modPetugas, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function($data) {
                return $data->jabatan_nama;
            },
            'filter' => Chtml::dropDownList('PegawairuanganV[jabatan_id]', $modPetugas->jabatan_id, Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
    . '}',
));

$this->endWidget();
?>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogObatAlkes',
    'options' => array(
        'title' => 'Obat Alkes Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 600,
        'resizable' => false,
    ),
));
$modObatAlkes = new RIObatalkesM('search');
$modObatAlkes->unsetAttributes();
$modObatAlkes->pendaftaran_id = $kunjungan->pendaftaran_id;
if (isset($_GET['RIObatalkesM'])) {
    $modObatAlkes->attributes = $_GET['RIObatalkesM'];
    $modObatAlkes->jenisresep = $_GET['RIObatalkesM']['jenisresep'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-premedikasi-grid',
    'dataProvider' => $modObatAlkes->searchObatAlkesPasienDijual(),
    'filter' => $modObatAlkes,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                                    "id" => "selectObat",
                                    "onClick" => "
                                        $(\'#obatalkes_id\').val($data->obatalkes_id);
                                        $(\'#obatalkes_nama\').val(\'$data->obatalkes_nama\');
                                        $(\'#dialogObatAlkes\').dialog(\'close\');
                                        return false;"
                                        ))',
        ),
        array(
            'header' => 'Kode Obat',
            'type' => 'raw',
            'value' => '$data->obatalkes_kode',
            'filter'=>CHtml::activeTextField($modObatAlkes,'obatalkes_kode').CHtml::activeHiddenField($modObatAlkes,'jenisresep')
        ),
        'obatalkes_nama',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogDetailKonsul',
    'options'=>array(
        'title'=>'Detail Pemberian Obat',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'resizable'=>false,
        'position'=>'top',
    ),
));

    echo '<div id="contentDetailKonsul">dialog content here</div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<script type="text/javascript">
  function changeJenisResep(){
    var jenisresep = $("#<?php echo CHtml::activeId($model, 'jenisresep'); ?>").val();
    $.fn.yiiGridView.update('obatalkes-premedikasi-grid', {
      data: {
        "RIObatalkesM[jenisresep]":jenisresep
      }
    });
  }

function inputDetailObat()
    {
       var buttonMinus = '<?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick'=>'delRow(this); return false;')) ?>';
       var tanggal_pemberian = $("#tanggal_pemberian").val();
       var jam_pemberian = $("#jam_pemberian").val();
       var waktu_monitoring = $("#waktu_monitoring").val();
       var tanda = $("#tanda").val();
       var initial = $("#initial").val();
       var no = $("#riwayatobat tbody").find("tr").length;

       $('#riwayatobat tbody').append("<tr>\n\
                                                <td><input readonly = TRUE type = 'hidden' id = 'CatatanpemberianobatdetT_"+(no+1)+"_tanggal_pemberian' name = 'CatatanpemberianobatdetT["+(no+1)+"][tanggal_pemberian]' value = '"+tanggal_pemberian+"' >"+tanggal_pemberian+"</td>"+
                                                "<td><input readonly = TRUE type = 'hidden' id = 'CatatanpemberianobatdetT_"+(no+1)+"_jam_pemberian' name = 'CatatanpemberianobatdetT["+(no+1)+"][jam_pemberian]' value = '"+jam_pemberian+"' >"+jam_pemberian+"</td>"+
                                                "<td><input readonly = TRUE type = 'hidden' id = 'CatatanpemberianobatdetT_"+(no+1)+"_waktu_monitoring' name = 'CatatanpemberianobatdetT["+(no+1)+"][waktu_monitoring]' value = '"+waktu_monitoring+"' >"+waktu_monitoring+"</td>"+
                                                "<td><input readonly = TRUE type = 'hidden' id = 'CatatanpemberianobatdetT_"+(no+1)+"_tanda' name = 'CatatanpemberianobatdetT["+(no+1)+"][tanda]' value = '"+tanda+"' >"+tanda+"</td>"+
                                               "<td><input readonly = TRUE type = 'hidden' id = 'CatatanpemberianobatdetT_"+(no+1)+"_initial' name = 'CatatanpemberianobatdetT["+(no+1)+"][initial]' value = '"+initial+"' >"+initial+"</td>\n\
                                                <td style='text-align:center;'>"+buttonMinus+"</td>\n\
                                            </tr>");

       resetRiwayat();
    }

    function resetRiwayat()
    {
        $("#tanggal_pemberian").val('');
        $("#jam_pemberian").val('');
        $("#tanda").val('');
        $("#initial").val('');
        $("#waktu_monitoring").val('');
    }

    function delRow(obj)
    {
         myConfirm('Apakah Anda yakin ingin menghapus data detail obat ini ?','Perhatian!',function(r){
            if (r){
                $(obj).parent().parent().remove();
           }
        });

    }


    function hapusCatatan(id) {
        myConfirm("Anda yakin untuk menghapus catatan ini?", "Pertahian", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('delete'); ?>', {id: id}, function(data) {
                    if (data.ok == 1) {
                        myAlert(data.msg);
                        window.location.replace('<?php echo $this->createUrl('create', array('pendaftaran_id' => $kunjungan->pendaftaran_id, 'pasienadmisi_id' => $kunjungan->pasienadmisi_id)); ?>');
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }

    function changeAlergi(obj){

        if($(obj).val() == true && $(obj).is(':checked')==true){
            $('#<?php echo CHtml::activeId($model, 'riwayatalergiobat'); ?>').attr('disabled',false);

        }else{
            $('#<?php echo CHtml::activeId($model, 'riwayatalergiobat'); ?>').attr('disabled',true);
        }
    }

    function print(pendaftaran_id,caraprint, typeoa)
    {
    window.open('<?php echo $this->createUrl('printNew'); ?>&pendaftaran_id='+pendaftaran_id+'&caraprint='+caraprint+'&typeoa='+typeoa,'printwin','left=100,top=100,width=1000,height=640');
    }

    function viewDetailKonsul(id)
    {
        $.post('<?php echo $this->createUrl('ajaxDetail') ?>', {catatanpemberianobat_id: id}, function(data){
            $('#contentDetailKonsul').html(data.result);
        }, 'json');
        $('#dialogDetailKonsul').dialog('open');
    }

    $(document).ready(function($){
        changeAlergi($('#<?php echo CHtml::activeId($model, 'riwayatalergiobat'); ?>'));
   });


</script>
