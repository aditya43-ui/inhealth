<div class="row-fluid">
    <div class="col-md-12">
        <?php echo $form->textFieldRow($model, 'rencanaumumpengadaan_nomor', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'rencanaumumpengadaan_tanggal', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'rencanaumumpengadaan_tanggal',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('class' => 'dtPicker3 required span4', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'pegawaipembuat_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->hiddenField($model, 'pegawaipembuat_id', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                echo $form->textField($model, 'pegawaipembuat_nama', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'rencanaumumpengadaan_tahun', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'periodeanggaran_id', $model->getPeriodeAnggaran(), array('empty' => '--Pilih--', 'class' => 'span4 set_periodeanggaran_id', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onchange' => 'showPejabatPAKPA(this);load_unit()'));
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Unit Kerja<span class="required">*</span></label>
            <?php //echo $form->labelEx($model, 'unitkerja_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                //echo $form->hiddenField($model, 'unitkerja_id', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                //echo $form->textField($model, 'unitkerja_nama', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                echo $form->dropDownList($model, 'unitkerja_id', array(), array('class' => 'required span4 set_unitkerja_id', 'empty' => '-- Pilih --', 'onchange' => 'set_instalasi();'))
                ?>
            </div>
        </div>
        <?php //echo $form->dropDownListRow($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif IS TRUE ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --', 'onchange' => 'cekInstalasi(this); showPejabatPPK();'));?>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'instalasi_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->hiddenField($model, 'instalasi_id', array('readonly' => true, 'class' => 'set_instalasi_id span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                echo $form->textField($model, 'instalasi_nama', array('readonly' => true, 'class' => 'set_instalasi_nama span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">Kategori Pekerjaan</label>
            <div class="controls">
                <?php echo $form->radioButton($model, 'ispaket', array('uncheckValue' => null, 'value' => 'ada', 'id' => 'adapaket', 'onclick' => 'cekPaket();')); ?> <label>Paket</label>
            </div>
            <div class="controls">
                <?php echo $form->radioButton($model, 'ispaket', array('uncheckValue' => null, 'value' => 'tidak', 'id' => 'nonpaket', 'onclick' => 'cekPaket();')); ?> <label>Nonpaket</label>
            </div>
        </div>
        <div class="control-group" id="form-pilih-paket">
            <label class="control-label">&nbsp;</label>
            <div class="controls">
                <table class="table table-striped table-bordered table-condensed" id="tabel-paket-rup">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Paket</th>                            
                            <th style="text-align: center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        echo $this->renderPartial("_rowPaket", array(), true);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>   
        <div class="control-group">
            <label class="control-label">&nbsp;</label>
            <div class="controls form-subkegiatan">
                <?php
                echo $this->renderPartial("tabel/_tabelListSubKegiatan", array('model' => $model, 'tipe' => 'kosong', 'paket' => ''), true);
                /*
                  <div class="control-group">
                  <?php echo $form->labelEx($model, 'Program <span class="required">*</span>', array('class' => 'control-label')); ?>
                  <div class="controls">
                  <?php
                  echo CHtml::textField('program', !empty($model->subprogram_id) ? $model->subprogram->programkerja->programkerja_nama : "", array('readonly' => true, 'class' => 'span8 required', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                  ?>
                  </div>
                  </div>
                  <div class="control-group">
                  <?php echo $form->labelEx($model, 'Kegiatan <span class="required">*</span>', array('class' => 'control-label')); ?>
                  <div class="controls">
                  <?php echo CHtml::textField('kegiatan', !empty($model->subprogram_id) ? $model->subprogram->subprogramkerja_nama : "", array('readonly' => true, 'class' => 'span8 required', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                  </div>
                  </div>
                  <div class="control-group">
                  <?php echo $form->labelEx($model, 'Sub Kegiatan <span class="required">*</span>', array('class' => 'control-label')); ?>
                  <div class="controls">
                  <?php
                  echo $form->hiddenField($model, 'subprogram_id', array('readonly' => true, 'class' => 'span4'));
                  echo CHtml::hiddenField('mappingrekeninganggaran_id','',array('readonly'=>true));
                  if(!empty($model->subkegiatanprogram_id)){
                  $cek = SubkegiatanprogramM::model()->findByPk($model->subkegiatanprogram_id);
                  $model->subkegiatanprogram_nama = $cek->subkegiatanprogram_nama;
                  }
                  echo $form->hiddenField($model, 'subkegiatanprogram_id', array('readonly' => true, 'class' => 'span4', 'onchange' => "showRAB(this);"));
                  $this->widget('MyJuiAutoComplete', array(
                  'model' => $model,
                  'attribute' => 'subkegiatanprogram_nama',
                  'source' => 'js: function(request, response) {
                  $.ajax({
                  url: "' . $this->createUrl('AutocompleteKegiatan') . '",
                  dataType: "json",
                  data: {
                  term: request.term,
                  instalasi_id: $("#ADRencanaumumpengadaanT_instalasi_id").val(),
                  periodeanggaran_id: $("#ADRencanaumumpengadaanT_periodeanggaran_id").val(),
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
                  return false;
                  }',
                  'select' => 'js:function( event, ui ) {
                  setData(ui.item);
                  return false;
                  }',
                  ),
                  'htmlOptions' => array(
                  'class' => 'hurufs-only span8',
                  'placeholder' => 'Ketik Nama Kegiatan',
                  'onchange' => "showRAB();"
                  ),
                  'tombolDialog' => array('idDialog' => 'dialogSubKegiatan', 'jsFunction'=>'refreshSubKegiatan();$("#dialogSubKegiatan").dialog("open");'),
                  ));
                  ?>
                  </div>
                 * 
                 */
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'nama_pekerjaan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->textField($model, 'nama_pekerjaan', array('class' => 'span8', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Nama Pekerjaan'));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Lokasi Pekerjaan', array('class' => 'control-label')); ?>
            <div class="controls">
                <table class="table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Propinsi <span class="required">*</span></th>
                            <th>Kabupaten/Kota <span class="required">*</span></th>
                            <th>Detail Lokasi</th>
                            <th style="text-align: center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="lokasiPekerjaan">
                        <?php
                        if (isset($_GET['sukses'])) {
                            $tr = "";
                            if (count((array)$arrLokasi)) {
                                foreach ($arrLokasi as $key => $value) {
                                    $tr .= $this->renderPartial("_rowLokasiPekerjaan", array('sendiri' => true, 'modLokasi' => $value, 'form' => $form), true);
                                }
                                echo $tr;
                            }
                        } else {
                            echo $this->renderPartial("_rowLokasiPekerjaan", array('sendiri' => true, 'modLokasi' => $modLokasi, 'form' => $form), true);
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'is_hutang', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                    echo $form->radioButtonList($model, 'is_hutang', array('1' => "YA", '0' => 'TIDAK'), array('class' => 'span1', 'value' => 'pengunjung', 'inline' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"))
                ?>
            </div>
        </div>
        <?php echo $form->dropDownListRow($model, 'rencanaumumpengadaan_kategori', LookupM::getItems('kategoripengadaan'), array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onchange' => 'setJenisRUP(this)')); ?>
        <div class="swakelola">
            <div class="control-group swakelola">
                <?php echo $form->labelEx($model, 'swakelola_tipe', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo $form->radioButtonList($model, 'swakelola_tipe', LookupM::getItems("swakelolatipe"), array('class' => 'span1', 'value' => 'pengunjung', 'inline' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"))
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'swakelola_penyelenggara', array('class' => 'control-label')); ?>
                <div class="controls">
                    <label><b>K/L/P/D</b></label>
                    <br>
                    <?php
                    echo $form->textField($model, 'swakelola_penyelenggara', array('class' => 'span8', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'K/L/P/D', 'value' => 'Pemerintah Provinsi Jawa Timur'));
                    ?>
                    <br>
                    <label><b>Satker/OPD</b></label>
                    <br>
                    <?php
                    echo $form->textField($model, 'swakelola_satker', array('class' => 'span8', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Satker/ODP', 'value' => 'RSUD Dr. Soetomo'));
                    ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'volume_pekerjaan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->textField($model, 'volume_pekerjaan', array('class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Volume'));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'uraian_pekerjaan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->textArea($model, 'uraian_pekerjaan', array('class' => 'span8', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Uraian'));
                ?>
            </div>
        </div>
        <div class="penyedia">
            <div class="control-group">
                <?php echo $form->labelEx($model, 'spesifikasi_pekerjaan', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo $form->textArea($model, 'spesifikasi_pekerjaan', array('class' => 'span8', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Spesifikasi'));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'isprodukdalamnegeri', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo $form->radioButtonList($model, 'isprodukdalamnegeri', array('1' => "YA", '0' => 'TIDAK'), array('class' => 'span1', 'value' => 'pengunjung', 'inline' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"))
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'isusahakecil', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo $form->radioButtonList($model, 'isusahakecil', array('1' => "YA", '0' => 'TIDAK'), array('class' => 'span1', 'value' => 'pengunjung', 'inline' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"))
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogSubKegiatan',
    'options' => array(
        'title' => 'Daftar Sub Kegiatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));

$moKegiatan = new RupSubkegiatanprogramV;
$moKegiatan->default = 'kosong';

if (isset($_GET['RupSubkegiatanprogramV'])) {
    $moKegiatan->attributes = $_GET['RupSubkegiatanprogramV'];
    $moKegiatan->default = isset($_GET['RupSubkegiatanprogramV']['default']) ? $_GET['RupSubkegiatanprogramV']['default'] : null;
    $moKegiatan->kodeanggaran = isset($_GET['RupSubkegiatanprogramV']['kodeanggaran']) ? $_GET['RupSubkegiatanprogramV']['kodeanggaran'] : null;
}


$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'kegiatan-t-grid',
    'dataProvider' => $moKegiatan->searchDokAnggaran(),
    'filter' => $moKegiatan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $res = $data->attributes;

                $res['label'] = $data->subkegiatanprogram_nama;
                $res['value'] = $data->subkegiatanprogram_id;


                $res = json_encode($res);

                return CHtml::Link("<i class=\"icon-form-check\"></i>", "javascript:;", array(
                            "class" => "btn-small",
                            "onClick" => "setData(" . $res . ",null,'nonpaketsub');                                 
                                "
                                )
                );
            }
        ),
        array(
            'header' => 'Program',
            'name' => 'programkerja_nama',
            'filter' => CHtml::activeHiddenField($moKegiatan, 'default') .
            CHtml::activeHiddenField($moKegiatan, 'unitkerja_id', array('class' => 'subkeg_unitkerja_id')) .
            CHtml::activeHiddenField($moKegiatan, 'instalasi_id', array('class' => 'subkeg_instalasi_id')) .
            CHtml::activeHiddenField($moKegiatan, 'periodeanggaran_id', array('class' => 'subkeg_periodeanggaran_id')) .
            CHtml::activeTextField($moKegiatan, 'programkerja_nama'),
            'value' => '$data->programkerja_nama'
        ),
        array(
            'header' => 'Kegiatan',
            'name' => 'subprogramkerja_nama',
            'filter' => CHtml::activeTextField($moKegiatan, 'subprogramkerja_nama'),
            'value' => '$data->subprogramkerja_nama'
        ),
        array(
            'header' => 'Rekening',
            'name' => 'kodeanggaran',
            'filter' => CHtml::activeTextField($moKegiatan, 'kodeanggaran'),
            'value' => '$data->kodeanggaran." - ".$data->nama_rekeninganggaran5'
        ),
        array(
            'header' => 'Sub Kegiatan',
            'filter' => CHtml::activeTextField($moKegiatan, 'subkegiatanprogram_nama'),
            'value' => '$data->subkegiatanprogram_nama'
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>