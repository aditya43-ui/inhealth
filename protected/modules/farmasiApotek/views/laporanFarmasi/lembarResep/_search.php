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
        #penjamin, #ruangan{
            width:250px;
        }
        #penjamin label.checkbox, #ruangan label.checkbox{
            width: 150px;
            display:inline-block;
        }

    </style><legend class="rim">Berdasarkan Tanggal Resep</legend>
    <table style="margin-top:10px;">
        <tr>
            <td>
                <?php echo CHtml::hiddenField('type', ''); ?>
                <?php //echo CHtml::hiddenField('src', ''); ?>
                <div class='control-label'>Tanggal Resep</div>
                <div class="controls">  
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_awal',
                        'mode' => 'datetime',
//                                          'maxDate'=>'d',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true,
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                    ?>
                </div> 
            </td>
            <td style="padding:0px 130px 0 0px;"> <?php echo CHtml::label('Sampai dengan', ' s/d', array('class' => 'control-label')) ?>
                <div class="controls">  
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_akhir',
                        'mode' => 'datetime',
//                                         'maxdate'=>'d',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true,
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                    ?>
                </div> </td>
        </tr>
    </table>
    <fieldset>
        <legend class="rim">Berdasarkan Jenis Penjamin </legend>
        <table width="216" border="0">
            <tr>
                <td width="51">   
                    <div id='searching'>
                        <table>
                            <tr>
                                <td>
                                    <div class="control-group">
                                        <?php echo $form->labelEx($model, 'pegawai_id', array('class'=>'control-label')); ?>
                                        <div class="controls">
                                        <?php echo $form->hiddenField($model, 'pegawai_id'); ?>
                                        <?php
                                            $this->widget('MyJuiAutoComplete', array(
                                                'model'=>$model,
                                                'attribute' => 'pegawai_nama',
                                                'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/daftarDokter'),
                                                'options' => array(
                                                    'showAnim' => 'fold',
                                                    'minLength' => 2,
                                                    'focus' => 'js:function( event, ui ) {
                                                                                        $(this).val(ui.item.label);
                                                                                        return false;
                                                                                    }',
                                                    'select' => 'js:function( event, ui ) {
                                                                                      $("#'.CHtml::activeId($model, 'pegawai_id').'").val(ui.item.pegawai_id);
                                                                                      return false;
                                                                                    }',
                                                ),
                                                'htmlOptions' => array(
                                                    'class' => 'span3',
                                                ),
                                                'tombolDialog' => array('idDialog' => 'dialogDokter'),
                                            ));
                                        ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php
//                                    echo CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) . 
//                                    echo $form->dropDownListRow($model, 'jenispenjualan', CHtml::listData(JenispenjualanM::model()->findAll('jenispenjualan_aktif = true'), 'jenispenjualan_id', 'jenispenjualan_nama'),array('empty'=>'-- Pilih --'));
                                    echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif = true'), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'ajax' => array('type' => 'POST',
                                            'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasienForCheckBox', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                                            'update' => '#penjamin', //selector to update
                                        ),
                                    ));
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="control-group">
                                        <?php echo $form->labelEx($model, 'penjamin_id', array('class'=>'control-label')); ?>
                                        <div class="controls">
                                            <div id="penjamin">
                                                <?php echo $form->checkBoxList($model, 'penjamin_id', CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif = true'), 'penjamin_id', 'penjamin_nama'), array('value' => 'pengunjung', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td width="51">   
                    <div id='searching'>
                        <table>
                            <tr>
                                <td>
                                    <?php
//                                    echo CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
                                    echo $form->dropDownListRow($model, 'instalasiasal_nama', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true'), 'instalasi_nama', 'instalasi_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'ajax' => array('type' => 'POST',
                                            'url' => Yii::app()->createUrl('ActionDynamic/GetRuanganAsalNamaForCheckBox', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                                            'update' => '#ruangan', //selector to update
                                        ),
                                    ));
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="control-group">
                                        <?php echo $form->labelEx($model, 'ruanganasal_nama', array('class'=>'control-label')); ?>
                                        <div class="controls">
                                            <div id="ruangan">
                                                <?php echo $form->checkBoxList($model, 'ruanganasal_nama', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true'), 'ruangan_nama', 'ruangan_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </fieldset>
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
    <?php //$this->widget('UserTips', array('type' => 'create')); ?>    
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
', CClientScript::POS_READY); ?>

<?php
//========= Dialog buat cari data obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Pencarian Dokter Resep',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modDokter = new DokterV('search');
$modDokter->unsetAttributes();
$modDokter->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['DokterV'])) {
    $modDokter->attributes = $_GET['DokterV'];
    
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatAlkes-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modDokter->search(),
    'filter' => $modDokter,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                            "id" => "selectDokter",
                                            "href"=>"",
                                            "onClick" => "
                                                          $(\"#' . CHtml::activeId($model, 'pegawai_id') . '\").val(\"$data->pegawai_id\");
                                                          $(\"#' . CHtml::activeId($model, 'pegawai_nama') . '\").val(\"$data->nama_pegawai\");
                                                          $(\"#dialogDokter\").dialog(\"close\");    
                                                          return false;
                                                "))',
        ),
//        'ruangan.ruangan_nama',
//        'instalasi.instalasi_nama',
//        'ruangan_nama',
        ////'pegawai_id',
//        array(
//                        'name'=>'pegawai_id',
//                        'value'=>'$data->pegawai_id',
//                        'filter'=>false,
//                ),
        'gelardepan',
        'nama_pegawai',
        'gelarbelakang_nama',
        'jeniskelamin',
        'nama_keluarga',
        'tempatlahir_pegawai',
        'tgl_lahirpegawai',
        'alamat_pegawai',
        'pegawai_aktif',
        'agama',
        'golongandarah',
        /*

        
        'alamatemail',
        'notelp_pegawai',
        'nomobile_pegawai',
        'photopegawai',
        'pendidikan_id',
        'pendidikan_nama',
        'pendkualifikasi_id',
        'pendkualifikasi_nama',
        'nomorindukpegawai',
        'pangkat_id',
        'kelompokpegawai_id',
        'jabatan_id',
        */
        
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end obatAlkes dialog =============================
?>