<?php
$this->breadcrumbs = array(
    'Informasi Pencarian Pasien',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> Informasi <b>Pencarian Pasien</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'caripasien-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#' . CHtml::activeId($model, 'no_rekam_medik'),
            'method' => 'GET',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
        Yii::app()->clientScript->registerScript('cariPasien', "
    $('#caripasien-form').submit(function(){
            $.fn.yiiGridView.update('pencarianpasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="control-group">
                        <?php echo CHtml::label(CHtml::activeCheckBox($model, 'tgl_rekam_medik') . " <label for='PPPasienM_ceklis'>Tgl. Rekam Medik</label>", 'tgl_rekam', array('class' => 'control-label')) ?>
                            <?php /*echo CHtml::label("Tgl. Rekam Medik", 'tgl_rekam', array('class' => 'control-label'))*/ ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_rm_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_rm_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d M Y', strtotime($model->tgl_rm_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_rm_akhir)) ?></span>
                                    <?php echo $form->hiddenField($model, 'tgl_rm_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($model, 'tgl_rm_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php /*
                      <div class="control-group">
                      <label class="control-label">
                      <?php echo CHtml::activecheckBox($model, 'ceklis', array('uncheckValue'=>0,'rel'=>'tooltip' ,'onClick'=>'cekTanggal()',
                      'data-original-title'=>'Cek untuk pencarian berdasarkan tanggal','onclick'=>'cekAll();')); ?>                             Tanggal Rekam Medik
                    </label>
                      <div class="controls">
                      <?php
                      $model->tgl_rm_awal= MyFormatter::formatDateTimeForUser($model->tgl_rm_awal);
                      $model->tgl_rm_akhir = MyFormatter::formatDateTimeForUser($model->tgl_rm_akhir);
                      $this->widget('MyDateTimePicker',array(
                      'model'=>$model,
                      'attribute'=>'tgl_rm_awal',
                      'mode'=>'date',
                      'options'=> array(
                      'dateFormat'=>Params::DATE_FORMAT,
                      'maxDate' => 'd',
                      ),
                      'htmlOptions'=>array('class'=>'dtPicker2', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                      ),
                      )); ?>
                      </div>
                      </div>
                      <div class="control-group">
                      <?php echo $form->label($model,'Sampai Dengan', array('class'=>'control-label inline')) ?>
                      <div class="controls">
                      <?php
                      $this->widget('MyDateTimePicker',array(
                      'model'=>$model,
                      'attribute'=>'tgl_rm_akhir',
                      'mode'=>'date',
                      'options'=> array(
                      'dateFormat'=>Params::DATE_FORMAT,
                      'maxDate' => 'd',
                      ),
                      'htmlOptions'=>array('class'=>'dtPicker2', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                      ),
                      )); ?>
                      </div>
                      </div>
                     * 
                     */ ?>
                        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('class' => 'span4 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'No. Rekam Medik')); ?>
                        <?php echo $form->textFieldRow($model, 'nama_pasien', array('class' => 'span4 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Nama Pasien')); ?>
                        <?php echo $form->textFieldRow($model, 'alamat_pasien', array('class' => 'span4 custom-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Alamat Pasien')); ?>
                        <?php
                        echo $form->dropDownListRow($model, 'statusrekammedis', array(Params::STATUSREKAMMEDIS_AKTIF => 'Aktif', Params::STATUSREKAMMEDIS_NON_AKTIF => "Non Aktif"), array(
                            'class' => 'span4', 'empty' => '-- Pilih --',
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                        ));
                        ?>
                        <div class="control-group">
                            <?php $model->tgl_awall = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awall, 'yyyy-MM-dd'), 'medium', null); ?>
                            <?php echo CHtml::label(CHtml::activeCheckBox($model, 'ceklis') . " <label for='PPPasienM_ceklis'>Tanggal Lahir</label>", 'tanggal_lahir', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tgl_awall',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'dtPicker3 span2', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php $model->tgl_akhirl = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_akhirl, 'yyyy-MM-dd'), 'medium', null); ?>
                            <?php echo CHtml::label('Sampai Dengan', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tgl_akhirl',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'dtPicker3 span2', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php //echo $form->textFieldRow($model,'nama_bin',array('class'=>'span4 hurufs-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'placeholder'=>'nama panggilan'));  
                        ?>
                        <?php /*
                      <div class="control-group">
                      <?php echo $form->labelEx($model,'rt', array('class'=>'control-label inline')) ?>
                      <div class="controls">
                      <?php echo $form->textField($model,'rt', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numberOnly','maxlength'=>3)); ?>   /
                      <?php echo $form->textField($model,'rw', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numberOnly','maxlength'=>3)); ?>
                      </div>
                      </div>
                     */
                        ?>
                        <?php
                        echo $form->dropDownListRow($model, 'propinsi_id', CHtml::listData($modProp, 'propinsi_id', 'propinsi_nama'), array(
                            'empty' => '-- Pilih --',
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'class' => 'span4',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('SetDropdownKabupaten', array('encode' => false, 'model_nama' => get_class($model))),
                                'update' => '#PPPasienM_kabupaten_id',
                            )
                        ));
                        ?>
                        <?php
                        echo $form->dropDownListRow($model, 'kabupaten_id', array(), array(
                            'empty' => '-- Pilih --',
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'class' => 'span4',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('SetDropdownKecamatan', array('encode' => false, 'model_nama' => get_class($model))),
                                'update' => '#PPPasienM_kecamatan_id',
                            )
                        ));
                        ?>
                        <?php
                        echo $form->dropDownListRow($model, 'kecamatan_id', array(), array(
                            'empty' => '-- Pilih --',
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'class' => 'span4',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('SetDropdownKelurahan', array('encode' => false, 'model_nama' => get_class($model))),
                                'update' => '#PPPasienM_kelurahan_id',
                            )
                        ));
                        ?>
                        <?php
                        echo $form->dropDownListRow($model, 'kelurahan_id', array(), array(
                            'empty' => '-- Pilih --',
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'class' => 'span4',
                        ));
                        ?>
                        <div class="control-group">
                            <?php echo CHtml::label('Kode Diagnosa', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'diagnosa_kode', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Kode Diagnosa')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Nama Diagnosa', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'diagnosa_nama', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Nama Diagnosa')); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'title' => 'Cari')); ?>
                    <?php
                    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/cariPasien'), array(
                        'class' => 'btn btn-default', 'title' => 'Ulang',
                        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('cariPasien') . '";} ); return false;'
                    ));
                    ?>
                    <?php
                    $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasiPencarianPasien', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pencarian Pasien</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                    'id' => 'pencarianpasien-grid',
                    'dataProvider' => $model->searchPasien(),
                    //                'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed table-bordered',
                    'replaceUrl' => true,
                    'mergeHeaders' => array(
                        array(
                            'name' => '<p style="margin: 0; text-align: center;">Daftarkan</p>',
                            'start' => 11, //indeks kolom 3
                            'end' => 12, //indeks kolom 4
                        ),
                    ),
                    'columns' => array(
                        array(
                            'name' => 'tgl_rekam_medik',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_rekam_medik)'
                        ),
                        array(
                            'name' => 'no_rekam_medik',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\"icon-form-print\"></i>", "javascript:print(\'$data->pasien_id\',\'$data->umur\');", array("rel"=>"tooltip","title"=>"Klik untuk mencetak kartu pasien"))." ".CHtml::link($data->no_rekam_medik, "javascript:print(\'$data->pasien_id\',\'$data->umur\');", array("rel"=>"tooltip","title"=>"Klik untuk mencetak kartu pasien"))',
                        ), /*
                              array(
                              'name'=>'namadepan',
                              'value'=>'$data->namadepan',
                              ), */
                        array(
                            'name' => 'Nama Pasien',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\"icon-form-ubah\"></i>", Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ubahPasien",array("id"=>"$data->pasien_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data pasien"))." ".CHtml::link($data->namadepan.$data->nama_pasien, Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ubahPasien",array("id"=>"$data->pasien_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data pasien"))',
                        ),
                        array(
                            'header' => 'Tgl. Lahir',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
                        ),
                        array(
                            'name' => 'jeniskelamin',
                            'value' => '$data->jeniskelamin',
                        ),
                        array(
                            'name' => 'alamat_pasien',
                            'value' => '$data->alamat_pasien',
                        ),
                        array(
                            'header' => 'Pekerjaan',
                            'name' => 'pekerjaan_id',
                            'value' => '($data->pekerjaan_id)?$data->pekerjaan->pekerjaan_nama:"-"',
                        ),
                        'agama',
                        /*
                              array(
                              'name'=>'Rt/Rw',
                              'value'=>'$data->rt." / ".$data->rw',
                              ), */
                        /*
                             * Jangan Dihapus, takutnya nanti kepake lagi  . . .You Know lah :p
                              array(
                              'name'=>'Penanggung Jawab',
                              'type'=>'raw',
                              'value'=>'(!empty($data->penanggungjawab_id) ? CHtml::link($data->penanggungJawab->nama_pj, Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/ubahPenanggungJawab",array("id"=>"$data->penanggungjawab_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data penanggung jawab"))." ".CHtml::link("<i class=\"icon-pencil\"></i>", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/ubahPenanggungJawab",array("id"=>"$data->penanggungjawab_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data penanggung jawab")) : "-") ',
                              ),
                             */ /*
                              array(
                              'name'=>'propinsi_id',
                              'filter'=>  CHtml::listData($modProp, 'propinsi_id', 'propinsi_nama'),
                              'value'=>  'PropinsiM::model()->findByPk($data->propinsi_id)->propinsi_nama',
                              ),
                              array(
                              'name'=>'kabupaten_id',
                              'filter'=>  CHtml::listData($modKab, 'kabupaten_id', 'kabupaten_nama'),
                              'value'=>  'KabupatenM::model()->findByPk($data->kabupaten_id)->kabupaten_nama',
                              ),
                              array(
                              'name'=>'kecamatan_id',
                              'filter'=>  CHtml::listData($modKec, 'kecamatan_id', 'kecamatan_nama'),
                              'value'=> ' KecamatanM::model()->findByPk($data->kecamatan_id)->kecamatan_nama',
                              ),
                              array(
                              'name'=>'kelurahan_id',
                              'filter'=>  CHtml::listData($modKel, 'kelurahan_id', 'kelurahan_nama'),
                              'value'=>'(isset($data->kelurahan_id) ? KelurahanM::model()->findByPk($data->kelurahan_id)->kelurahan_nama : "-")',
                              ),
                             * */
                        array(
                            'header' => 'Status RM',
                            'type' => 'raw',
                            'value' => '$data->statusrekammedis',
                        ),
                        array(
                            'header' => 'Dok File RM',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<icon class=\"icon-file\" ></icon>", Yii::app()->createUrl("pendaftaranPenjadwalan/PencarianPasien/riwayatDokfilerm", array("pasien_id" => $data->pasien_id)),
                                        array("target" => "frameRiwayatDokfilerm",
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk melihat File Rekam Medik",
                                        "onclick" => "$(\"#dialogDokFilerm\").dialog(\"open\");",
                                    ))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Riwayat <br> Kunjungan',
                            'type' => 'raw',
                            //                        'value'=>'CHtml::link("<icon class=\'icon-list-alt\'></icon>","", 
                            //                            array("href"=>"", "onclick"=>"getListKunjungan(".$data->pasien_id.");return false;"))',
                            //                        'htmlOptions'=>array('style'=>'text-align:left;'),
                            'value' => 'CHtml::Link("<i class=\"icon-form-kunjungan\"></i>",Yii::app()->createUrl("pendaftaranPenjadwalan/PencarianPasien/riwayatKunjungan",array("pasien_id"=>$data->pasien_id)),
                                    array("class"=>"", 
                                          "target"=>"iframeRiwayatKunjungan",
                                          "onclick"=>"$(\"#dialogRiwayatKunjungan\").dialog(\"open\");",
                                          "rel"=>"tooltip",
                                          "title"=>"Klik untuk Lihat Riwayat Kunjungan ",
                                    ))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Rawat<br>Jalan',
                            'type' => 'raw',
                            'value' => '(empty($data->ruangan_id)  ? CHtml::link("<i class=\'icon-form-rj\'></i> ", 
                                    "index.php?r=pendaftaranPenjadwalan/PendaftaranRawatJalan/index&pasien_id=$data->pasien_id",array("id"=>"$data->pasien_id",
                                        "title"=>"Klik untuk Mendaftarkan ke Rawat Jalan","rel"=>"tooltip")) : "Pasien Sudah Didaftarkan <br> Ke Rawat Jalan") ',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Rawat <br> Darurat',
                            'type' => 'raw',
                            'value' => '(empty($data->ruangan_id)  ? CHtml::link("<i class=\'icon-form-rd\'></i> ", 
                                    "index.php?r=pendaftaranPenjadwalan/PendaftaranRawatDarurat/index&pasien_id=$data->pasien_id",array("id"=>"$data->pasien_id",
                                        "title"=>"Klik untuk Mendaftarkan ke Rawat Darurat","rel"=>"tooltip")) : "Pasien Sudah Didaftarkan <br> Ke Rawat Darurat") ',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Riwayat<br>Pasien',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => function ($data) {
                                return CHtml::link("<i class='icon-form-riwayatpasien'></i>", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getRiwayatPasien&id=' . $data->pasien_id), array("rel" => "tooltip", "title" => "Klik untuk Riwayat Pemeriksaan Pasien"));
                            },
                        ),
                        array(
                            'header' => 'Non Aktif',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if ($data->statusrekammedis == Params::STATUSREKAMMEDIS_NON_AKTIF)
                                    return "-";
                                return CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick' => 'nonaktifPasien(' . $data->pasien_id . ', "' . $data->namadepan . $data->nama_pasien . '", "' . $data->no_rekam_medik . '"); return false;'));
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                            'visible' => Yii::app()->user->getState('ruangan_id') == 6,
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $url = Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/printKartuPasien', array('pasien_id' => ''));
        $cetak = Yii::app()->createUrl('pendaftaranPenjadwalan/pencarianPasien/printKartu', array('id' => ''));
        $urlPendaftaranRJ = Yii::app()->createAbsoluteUrl('pendaftaranPenjadwalan/Pendaftaran/RawatJalan');
        $urlPendaftaranRD = Yii::app()->createAbsoluteUrl('pendaftaranPenjadwalan/Pendaftaran/RawatDarurat');
        $js = <<< JSCRIPT
//function daftarRj(noRM)
//   {
//           
//            $('#norek').val(noRM);
//            document.getElementById("daftarRJ").submit();
//           
//   }
// ==* Fungsi Print *== //
function print(id,umur)
   {    
               window.open('${url}'+id,'printwin','left=100,top=100,width=310,height=250,scrollbars=0');
   }
function getListKunjungan(id){
    if (jQuery.isNumeric(id)){
        $.fn.yiiGridView.update('pencarianlistkunjungan-grid', {
		data: 'PendaftaranT[pasien_id]='+id, 
                success: function (data) {
                        var hasil = $('<div>' + data + '</div>');
                        var updateId = '#pencarianlistkunjungan-grid';
                        var update2 = '#dataPasienKunjungan';
                        $(updateId).replaceWith($(updateId, hasil));
                        $(update2).replaceWith($(update2, hasil));
                        $("#dialogRiwayatKunjungan").dialog("open");
                }
	});
	return false;
    }
}
function daftarKeRJ(pasien_id)
{
    $('#pasien_id').val(pasien_id);
    $('#form_hidden_rj').submit();
}
function daftarKeRD(pasien_id)
{
    $('#pasien_id').val(pasien_id);
    $('#form_hidden_rd').submit();
}
JSCRIPT;
        Yii::app()->clientScript->registerScript('jsPencarianPasien', $js, CClientScript::POS_HEAD);
        $js = <<< JS
$('.numberOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
// value = value.replace(/[0-9]*/g, "");
value = value.replace(/[0-9]/g, "");
var msg = "Only Integer Values allowed.";
if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}
if (value != '') {
// orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
orignalValue = orignalValue.replace(/([^0-9].)/g, "")
$(this).val(orignalValue);
}
});
JS;
        Yii::app()->clientScript->registerScript('numberOnly', $js, CClientScript::POS_READY);
        ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'form_hidden_rj',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'method' => 'GET',
            'action' => $urlPendaftaranRJ,
            'htmlOptions' => array('style' => 'margin-top: 0 !important;', 'target' => '_new'),
        ));
        ?>
        <?php echo CHtml::hiddenField('pasien_id', '', array('readonly' => true)); ?>
        <?php //echo CHtml::hiddenField('pendaftaran_id','',array('readonly'=>true));
        ?>
        <?php $this->endWidget(); ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'form_hidden_rd',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'method' => 'GET',
            'action' => $urlPendaftaranRD,
            'htmlOptions' => array('style' => 'margin-top: 0 !important;', 'target' => '_new'),
        ));
        ?>
        <?php echo CHtml::hiddenField('pasien_id', '', array('readonly' => true)); ?>
        <?php $this->endWidget(); ?>
        <?php $urlna = $this->createUrl('nonAktifPasien'); ?>
        <script>
            document.getElementById('PPPasienM_tgl_rm_awal_date').setAttribute("style", "display:none;");
            document.getElementById('PPPasienM_tgl_rm_akhir_date').setAttribute("style", "display:none;");

            function cekTanggal() {
                var checklist = $('#PPPasienM_ceklis');
                var pilih = checklist.attr('checked');
                if (pilih) {
                    document.getElementById('PPPasienM_tgl_rm_awal_date').setAttribute("style", "display:block;");
                    document.getElementById('PPPasienM_tgl_rm_akhir_date').setAttribute("style", "display:block;");
                } else {
                    document.getElementById('PPPasienM_tgl_rm_awal_date').setAttribute("style", "display:none;");
                    document.getElementById('PPPasienM_tgl_rm_akhir_date').setAttribute("style", "display:none;");
                }
            }
            //    cekAll();
            function cekAll() {
                if ($("#PPPasienM_ceklis").is(":checked")) {
                    $("#PPPasienM_tgl_rm_awal").removeAttr('disabled');
                    $("#PPPasienM_tgl_rm_akhir").removeAttr('disabled');
                } else {
                    $("#PPPasienM_tgl_rm_awal").attr('disabled', 'true');
                    $("#PPPasienM_tgl_rm_akhir").attr('disabled', 'true');
                }
            }
            // untuk me-resize ukuran dalog box
            function resetIframe(obj) {
                obj.style.height = 10 + 'px';
            }

            function autoResizeIframe(obj, id) {
                var frameObj = document.getElementById(id);
                resetIframe(frameObj);
                obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';
            }

            function nonaktifPasien(id, nama, rm) {
                if (confirm("Anda yakin untuk menonaktifkan pasien " + nama + " (" + rm + ")?\nAnda tidak dapat mengaktifkan kembali.")) {
                    $.post("<?php echo $urlna; ?>", {
                        id: id
                    }, function(data) {
                        $.fn.yiiGridView.update("pencarianpasien-grid");
                    }, 'json');
                }
            }
        </script>
        <?php
        // Dialog buat Copy Resep =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogRiwayatKunjungan',
            'options' => array(
                'title' => 'Riwayat Kunjungan',
                'autoOpen' => false,
                'modal' => true,
                'minWidth' => 980,
                'resizable' => false,
            ),
        ));
        ?>
        <iframe src="" name="iframeRiwayatKunjungan" width="100%" id="iframeRiwayatKunjungan" marginheight="0" frameborder="0" onLoad="autoResizeIframe(this, 'iframeRiwayatKunjungan');"></iframe>
        <?php
        $this->endWidget();
        //========= end Copy Resep dialog =============================
        ?>
        <?php
        // Dialog Riwayat
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogRiwayatPasien',
            'options' => array(
                'title' => 'Riwayat Pasien',
                'autoOpen' => false,
                'modal' => true,
                'width' => 900,
                'height' => 550,
                'resizable' => false,
            ),
        ));
        ?>
        <iframe name='frameRiwayatPasien' style="width: 100%; height: 98%;"></iframe>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
// Dialog untuk Melihat pemeriksaan pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDokFilerm',
    'options' => array(
        'title' => 'Riwayat Dokumen File Rekam Medis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'height' => 550,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('pencarianpasien-grid', {
                        data: $('#caripasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe name='frameRiwayatDokfilerm' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>