<?php
/**
 * view ini digunakan untuk menampilkan semua form pada menu transaksi persiapan pengadaan
 * 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);

$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'infoumumpengadaan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),

        //'focus' => '#'.CHtml::activeId($model, 'persiapanpengadaan_tanggal').'',
        ));
?>
<style>
    .form-horizontal .control-label{
        width: 200px !important;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel panel-heading">
        <div class="panel-title"> Pemilihan <b> Pejabat Pengadaan </b> </div>
    </div>
    <div class="panel-body">
        <div class="control-group">
            <?php echo CHtml::label("Nomor Persiapan Pengadaan", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'persiapanpengadaan_nomor', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->hiddenField($modInfo, 'infoumumpengadaan_id', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Paket Pekerjaan", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPersiapan, 'nama_pekerjaan', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Pelaksanaan Pemilihan Penyedia", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPersiapan, 'pemilihanpenyedia_tglawal', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Metode Pengadaan", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPersiapan, 'metodepengadaan_nama', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Total HPS", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPersiapan, 'total_hargaseluruhnya', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label("Nama Pegawai <span class='required'>*</span>", 'nomor_beritaacara', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($modInfo, 'pegpengadaan_id'); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modInfo,
                    'attribute' => 'pegpengadaan_nama',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('getPegawai') . '",
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
                            $(this).val( ui.item.nama_pegawai);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            $("#InfoumumpengadaanT_pegpengadaan_id").val(ui.item.pegawai_id);
                            $("#InfoumumpengadaanT_pegpengadaan_nama").val(ui.item.nama_pegawai);
                            $("#InfoumumpengadaanT_jabatan_pengadaan").val(ui.item.jabatan_pengadaan);
                            $("#InfoumumpengadaanT_tgl_sk").val(ui.item.tgl_sk);
                            $("#InfoumumpengadaanT_no_sk").val(ui.item.no_sk);
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'class' => 'span4 required',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => 'Ketikan Nama Pejabat Pengadaan',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPihak1', 'idTombol' => 'tombolPihak1'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Jabatan <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modInfo, 'jabatan_pengadaan', array('readonly' => false, 'class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div> 
        <div class="control-group">
            <?php echo CHtml::label("Nomor SK <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modInfo, 'no_sk', array('readonly' => false, 'class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div> 
        <div class="control-group ">
            <?php echo CHtml::label("Tanggal SK <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modInfo,
                    'attribute' => 'tgl_sk',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span4 required dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                ));
                ?>
            </div>
        </div>
        <?php
            $cri = new CDbCriteria();
            $cri->addCondition('pegawai_id = ' . Yii::app()->user->getState('pegawai_id'));
            $cri->addCondition('pejabatpengadaan_aktif is true');
            $cri->addCondition("jabatan_pengadaan = '" . Params::JABATAN_PENGADAAN_PPK . "'");
            $modPPK = PejabatpengadaanM::model()->find($cri);
            $cekSPK = SuratperjanjiankerjaT::model()->findByAttributes(array('persiapanpengadaan_id' => $_GET['persiapanpengadaan_id'], 'isbatal' => false, 'isaddendum' => true));

            if (!empty($cekSPK)) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                echo "&nbsp;";
            } else {
                if (isset($_GET['sukses']) || !empty($modPPK)) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                    echo "&nbsp;";
                } else {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary submit',
                    'type' => 'button', 'onclick' => 'cekForm();'));
                }
            }
            echo "&nbsp;";
            
            echo CHtml::htmlButton(Yii::t('mds','{icon} Tutup',array('{icon}'=>'<i class="fa fa-chevron-left"></i>')),array(
                'class'=>'btn btn-danger submit', 
                'type'=>'button',
                'onclick'=>'closeDialog();return false;',
                'onKeypress'=>'return formSubmit(this,event)'
            )); 
        ?>
    </div>
</div>
<script>
    function closeDialog(){
         window.parent.$("#dialog2").dialog('close');
    }
    
    function cekForm() {
        if (requiredCheck($("#infoumumpengadaan-t-form"))) {
            $('#infoumumpengadaan-t-form').submit();
        }

        return false;
    }
</script>

    <?php $this->endWidget(); ?>

    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogPihak1',
        'options' => array(
            'title' => 'Pencarian Pejabat Pengadaan',
            'autoOpen' => false,
            'modal' => true,
            'width' => 600,
            'height' => 500,
            'zIndex' => 1002,
            'resizable' => false,
        ),
    ));

    $modPihak1 = new PejabatpengadaanM('search');
    $modPihak1->unsetAttributes();
    $modPihak1->pejabatpengadaan_aktif = true;
    if (isset($_GET['PejabatpengadaanM'])) {
        $modPihak1->attributes = $_GET['PejabatpengadaanM'];
        $modPihak1->namaunitkerja = isset($_GET['PejabatpengadaanM']['namaunitkerja']) ? $_GET['PejabatpengadaanM']['namaunitkerja'] : null;
        $modPihak1->nomorindukpegawai = isset($_GET['PejabatpengadaanM']['nomorindukpegawai']) ? $_GET['PejabatpengadaanM']['nomorindukpegawai'] : null;
        $modPihak1->nama_pegawai = isset($_GET['PejabatpengadaanM']['nama_pegawai']) ? $_GET['PejabatpengadaanM']['nama_pegawai'] : null;
    }
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'pihakkesatu-grid',
        'dataProvider' => $modPihak1->searchDialog(),
        'filter' => $modPihak1,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                "href"=>"",
                "id" => "selectObat",
                "onClick" => "
                    $(\"#' . CHtml::activeId($modInfo, 'pegpengadaan_id') . '\").val(\"$data->pegawai_id\");
                    $(\"#' . CHtml::activeId($modInfo, 'pegpengadaan_nama') . '\").val(\"$data->nama_pegawai\");
                    $(\"#' . CHtml::activeId($modInfo, 'jabatan_pengadaan') . '\").val(\"$data->jabatan_pengadaan\");
                    $(\"#' . CHtml::activeId($modInfo, 'tgl_sk') . '\").val(\"$data->tgl_sk\");
                    $(\"#' . CHtml::activeId($modInfo, 'no_sk') . '\").val(\"$data->no_sk\");
                    $(\"#dialogPihak1\").dialog(\"close\"); 
                    return false;
                "))',
            ),
            array(
                'header' => 'NIP',
                'name' => 'nomorindukpegawai',
                'value' => '$data->nomorindukpegawai',
            ),
            array(
                'header' => 'Nama Pegawai',
                'name' => 'nama_pegawai',
                'value' => '$data->pegawai->namaLengkap',
            ),
            array(
                'header' => 'Unit Kerja',
                'name' => 'namaunitkerja',
                'value' => '$data->namaunitkerja',
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));
    $this->endWidget();
    ?>