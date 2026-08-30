<div class="row-fluid">
    <div class="col-md-12">
        <?php echo $form->textFieldRow($model, 'rencanaumumpengadaan_nomor', array('disabled' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'rencanaumumpengadaan_status', array('disabled' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'rencanaumumpengadaan_tanggal', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $model->rencanaumumpengadaan_tanggal = date('d ', strtotime($model->rencanaumumpengadaan_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->rencanaumumpengadaan_tanggal))) . date(' Y', strtotime($model->rencanaumumpengadaan_tanggal));
                echo $form->textField($model, 'rencanaumumpengadaan_tanggal', array('disabled' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'pegawaipembuat_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->hiddenField($model, 'pegawaipembuat_id', array('disabled' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                echo $form->textField($model, 'pegawaipembuat_nama', array('disabled' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'unitkerja_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->hiddenField($model, 'unitkerja_id', array('disabled' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                echo $form->textField($model, 'unitkerja_nama', array('disabled' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
        </div>
        <?php echo $form->dropDownListRow($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif IS TRUE ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array('disabled' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'rencanaumumpengadaan_tahun', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'periodeanggaran_id', $model->getPeriodeAnggaran(), array('disabled' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)"));
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Kategori Pekerjaan</label>
            <div class="controls">
                <?php echo $form->radioButton($model,'ispaket',array('uncheckValue'=>null, 'value'=>'ada', 'id'=>'adapaket', 'onclick'=>'cekPaket();', 'disabled'=>true)); ?> <label>Paket</label>
            </div>
             <div class="controls">
                <?php echo $form->radioButton($model,'ispaket',array('uncheckValue'=>null, 'value'=>'tidak', 'id'=>'nonpaket', 'onclick'=>'cekPaket();', 'disabled'=>true)); ?> <label>Nonpaket</label>
            </div>
        </div>
        <div class="control-group" id="form-pilih-paket">
            <label class="control-label">&nbsp;</label>
            <div class="controls" style="width: 240px">
                 <table class="table table-striped table-bordered table-condensed" id="tabel-paket-rup" width="100%">
                    <thead>
                        <tr>
                            <th style="width: 35px; text-align: center;">No.</th>
                            <th>Paket</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $cekDet = RencanaumumpengadaandetT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $model->rencanaumumpengadaan_id));
                        $no = 1;
                        if(!empty($cekDet)){
                            foreach ($cekDet as $val) :
                                echo $this->renderPartial($this->path_view_ubah."_rowPaket", array('model'=>$val, 'no'=>$no++), true); 
                            endforeach;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>  
        <div class="control-group">
            <label class="control-label">&nbsp;</label>
            <div class="controls form-subkegiatan">
                        <?php 
                        
                            echo $this->renderPartial($this->path_view_ubah."tabel/_tabelListSubKegiatan", array('model' => $model, 'tipe' => 'kosong','paket'=>''), true);
                       ?>
            </div>
        </div>
        <?php /*
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Program <span class="required">*</span>', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo CHtml::textField('program', !empty($model->subprogram_id) ? $model->subprogram->programkerja->programkerja_nama : "-", array('disabled' => true, 'class' => 'span8 required', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'subprogram_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->hiddenField($model, 'subprogram_id', array('disabled' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                echo $form->textField($model, 'subprogram_nama', array('disabled' => true, 'class' => 'span8', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Sub Kegiatan <span class="required">*</span>', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->hiddenField($model, 'subkegiatanprogram_id', array('readonly' => true, 'class' => 'span4', 'onchange' => "showRAB(this);"));
                echo $form->textField($model, 'subkegiatanprogram_nama', array('readonly' => true, 'class' => 'span8', ));
//                $this->widget('MyJuiAutoComplete', array(
//                    'model' => $model,
//                    'attribute' => 'subkegiatanprogram_nama',
//                    'source' => 'js: function(request, response) {
//                            $.ajax({
//                                url: "' . $this->createUrl('AutocompleteKegiatan') . '",
//                                dataType: "json",
//                                data: {
//                                    term: request.term,
//                                    instalasi_id: $("#ADRencanaumumpengadaanT_instalasi_id").val(),
//                                    periodeanggaran_id: $("#ADRencanaumumpengadaanT_periodeanggaran_id").val(),
//                                },
//                                success: function (data) {
//                                    response(data);
//                                }
//                            })
//                        }',
//                    'options' => array(
//                        'showAnim' => 'fold',
//                        'minLength' => 2,
//                        'focus' => 'js:function( event, ui ) {
//                                return false;
//                            }',
//                        'select' => 'js:function( event, ui ) {
//                                setData(ui.item);
//                                return false;
//                            }',
//                    ),
//                    'htmlOptions' => array(
//                        'class' => 'hurufs-only span8',
//                        'placeholder' => 'Ketik Nama Kegiatan',
//                    ),
//                    'tombolDialog' => array('idDialog' => 'dialogSubKegiatan'),
//                ));
                ?>
            </div>
        </div>
         * 
         */ ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'nama_pekerjaan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->textField($model, 'nama_pekerjaan', array('disabled' => false, 'class' => 'span8', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Nama Pekerjaan'));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Lokasi Pekerjaan', array('class' => 'control-label')); ?>
            <div class="controls">
                <table class="table table-striped table-bordered table-condensed" id="tabelPekerjaan">
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
                            echo $this->renderPartial($this->path_view_ubah."_rowLokasiPekerjaan", array('sendiri'=>true,'modLokasi'=>$modLokasi,'form'=>$form), true);
                        ?>
                    </tbody>
                </table>
                <table class="hide" id="tabelHapusPekerjaan">
                    <tbody>
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
        <?php echo $form->dropDownListRow($model, 'rencanaumumpengadaan_kategori', LookupM::getItems('kategoripengadaan'), array('disabled' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onchange' => 'setJenisRUP(this)')); ?>
        <div class="swakelola">
            <div class="control-group swakelola">
                <?php echo $form->labelEx($model, 'Tipe Swakelola', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo $form->textField($model, 'swakelola_tipe', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'swakelola_penyelenggara', array('class' => 'control-label')); ?>
                <div class="controls" style="padding-top: 6px !important">
                    <label><b>K/L/P/D</b></label>
                    <br>
                    <?php
                    echo $form->textField($model, 'swakelola_penyelenggara', array('readonly' => false, 'class' => 'span8', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'K/L/P/D'));
                    ?>
                    <br>
                    <label><b>Satker/OPD</b></label>
                    <br>
                    <?php
                    echo $form->textField($model, 'swakelola_satker', array('readonly' => false, 'class' => 'span8', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Satker/ODP'));
                    ?>
                </div>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo $form->labelEx($model, 'volume_pekerjaan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->textField($model, 'volume_pekerjaan', array('disabled' => false, 'class' => 'span8', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Volume'));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'uraian_pekerjaan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->textArea($model, 'uraian_pekerjaan', array('disabled' => false, 'class' => 'span8', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Uraian'));
                ?>
            </div>
        </div>
        <div class="penyedia">
            <div class="control-group">
                <?php echo $form->labelEx($model, 'spesifikasi_pekerjaan', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo $form->textArea($model, 'spesifikasi_pekerjaan', array('readonly' => false, 'class' => 'span8', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Spesifikasi'));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'isprodukdalamnegeri', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                        echo $form->radioButtonList($model, 'isprodukdalamnegeri', array('1'=>"YA", '0'=>'TIDAK'), array('class'=>'span1', 'value' => 'pengunjung', 'inline' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"))
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'isusahakecil', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                        echo $form->radioButtonList($model, 'isusahakecil', array('1'=>"YA", '0'=>'TIDAK'), array('class'=>'span1', 'value' => 'pengunjung', 'inline' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"))
                    ?>
                </div>
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

$moKegiatan = new DokumenpelaksanaananggarandetT('searchSubkegiatan');
$moKegiatan->unsetAttributes();
if (isset($_GET['DokumenpelaksanaananggarandetT'])) {
    $moKegiatan->programkerja_nama = isset($_GET['DokumenpelaksanaananggarandetT']['programkerja_nama'])?$_GET['DokumenpelaksanaananggarandetT']['programkerja_nama']:null; 
    $moKegiatan->subprogramkerja_nama = isset($_GET['DokumenpelaksanaananggarandetT']['subprogramkerja_nama'])?$_GET['DokumenpelaksanaananggarandetT']['subprogramkerja_nama']:null;
    $moKegiatan->subkegiatanprogram_nama = isset($_GET['DokumenpelaksanaananggarandetT']['subkegiatanprogram_nama'])?$_GET['DokumenpelaksanaananggarandetT']['subkegiatanprogram_nama']:null;
    if(!empty($_GET['DokumenpelaksanaananggarandetT']['unitkerja_id'])){
        $moKegiatan->unitkerja_id = $_GET['DokumenpelaksanaananggarandetT']['unitkerja_id'];
    }
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'kegiatan-t-grid',
    'dataProvider' => $moKegiatan->searchSubkegiatan(),
    'filter' => $moKegiatan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $res = $data->attributes;
                if(!empty($data->subkegiatanprogram_id)){
                    $cekSubKegiatan = SubkegiatanprogramM::model()->findByPk($data->subkegiatanprogram_id);
                    if (!empty($cekSubKegiatan->kegiatanprogram_id)) {
                        $cekKegiatanprogram = KegiatanprogramM::model()->findByPk($cekSubKegiatan->kegiatanprogram_id);
                        if (!empty($cekKegiatanprogram)) {
                            $cekSubprogramkerja = SubprogramkerjaM::model()->findByPk($cekKegiatanprogram->subprogramkerja_id);
                            if (!empty($cekSubprogramkerja)) {
                                $subprogramkerja_nama = $cekSubprogramkerja->subprogramkerja_nama;
                                $cekProgramkerja = ProgramkerjaM::model()->findByPk($cekSubprogramkerja->programkerja_id);
                                if (!empty($cekProgramkerja)) {
                                    $programkerja_nama = $cekProgramkerja->programkerja_nama;
                                }
                            }
                        }
                    }
                }
                $res['label'] = $cekSubKegiatan->subkegiatanprogram_nama;
                $res['value'] = $data->subkegiatanprogram_id;

                $cekSubprogramkerja = SubprogramkerjaM::model()->findByPk($cekKegiatanprogram->subprogramkerja_id);
                if (!empty($cekSubprogramkerja)) {
                    $res['subprogramkerja_nama'] = $subprogramkerja_nama;
                    $res['subprogramkerja_id'] =  $cekSubprogramkerja->subprogramkerja_id;
                    $cekProgramkerja = ProgramkerjaM::model()->findByPk($cekSubprogramkerja->programkerja_id);
                    if (!empty($cekProgramkerja)) {
                        $res['programkerja_nama'] = $cekProgramkerja->programkerja_nama;
                    }
                }
                $total = '';

                $res = json_encode($res);

                return CHtml::Link("<i class=\"icon-form-check\"></i>", "#", array(
                            "class" => "btn-small",
                            "onClick" => "setData(" . $res . "); 
                               $('#dialogSubKegiatan').dialog('close');return false;"
                    )
                );
            }
        ),
        array(
            'header'=>'Program Kerja',
            'filter' => CHtml::activeTextField($moKegiatan, 'programkerja_nama'),
            'value'=>'$data->subkegiatanprogram->kegiatanprogram->subprogramkerja->programkerja->programkerja_nama'
        ),
       
        array(
           
            'header'=>'Sub Program Kerja',
            'filter' => CHtml::activeTextField($moKegiatan, 'subprogramkerja_nama'),
            'value'=>'$data->subkegiatanprogram->kegiatanprogram->subprogramkerja->subprogramkerja_nama'
        ),
        array(
            
            'header'=>'Sub Kegiatan Program',
            'filter' => CHtml::activeTextField($moKegiatan, 'subkegiatanprogram_nama'),
            'value'=>'$data->subkegiatanprogram->subkegiatanprogram_nama'
        ),     
                
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>