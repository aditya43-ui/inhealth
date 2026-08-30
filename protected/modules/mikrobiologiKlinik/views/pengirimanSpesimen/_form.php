<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); ?>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pengeluaranaset-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
?>
<div class="panel panel-primary panel-success">
    <div class="panel-heading">
        <div class="panel-title">Data Pengiriman Spesimen</div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial($this->path_view . '_formDetail', array('modKirimSpesimen' => $modKirimSpesimen, 'modKirimSpesimenDetail' => $modKirimSpesimenDetail, 'form' => $form)); ?>		
        <hr>
        <?php $this->renderPartial($this->path_view . '_tableDetail', array('form' => $form, 'modKirimSpesimen' => $modKirimSpesimen, 'modKirimSpesimenDetail' => $modKirimSpesimenDetail)); ?>
        <hr>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Tanggal Pengiriman <span class="required">*</span>', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php $modKirimSpesimen->tglkirimspesimen = MyFormatter::formatDateTimeForUser($modKirimSpesimen->tglkirimspesimen); ?>
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modKirimSpesimen,
                        'attribute' => 'tglkirimspesimen',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('class' => 'dtPicker3 span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Petugas Transporter <span class="required">*</span>', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo $form->hiddenField($modKirimSpesimen, 'petugaskirim_id', array('readonly' => true, 'class' => 'required'));

                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $modKirimSpesimen,
                        'attribute' => 'petugaskirim_nama',
                        'source' => 'js: function(request, response) {
					$.ajax({
					url: "' . $this->createUrl('/ActionAutoComplete/dropPetugasRuangan') . '",
					dataType: "json",
					data: {
						term: request.term,
                                                ruangan_id: ' . Yii::app()->user->getState('ruangan_id') . '
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
					 $("#' . CHtml::ActiveId($modKirimSpesimen, 'petugaskirim_id') . '").val(ui.item.value); 
					 return false;
				 }',
                        ),
                        'htmlOptions' => array('class' => 'span3 required', 'placeholder' => 'Ketik Nama Petugas'),
                        'tombolDialog' => array('idDialog' => 'dialogPetugas'),
                    ));
                    ?>
                </div>
            </div> 
        </div>
        <div class="col-sm-6">
            <div class="control-group ">
                <?php echo CHtml::label('Ruangan Tujuan <span class="required">*</span>', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($modKirimSpesimen, 'ruangantujuan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array('ruangan_id' => Params::RUANGAN_ID_LAB_MIKROBIOLOGI, 'ruangan_aktif' => true)), 'ruangan_id', 'ruangan_nama'), array( 'class' => 'span2 required', 'style' => 'width:200px;', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Keterangan', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textArea($modKirimSpesimen, 'keterangan_pengiriman', array('rows' => 3, 'class' => 'span3', 'placeholder' => 'Keterangan Pengiriman')); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton($modKirimSpesimen->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => (isset($_GET['sukses'])) ? true : false));
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->module->id . '/Index'), array('class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('Index') . '";} ); return false;'));
    ?>
</div>
<?php $this->endWidget(); ?>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print', array('pengirimanspesimen_id' => ''));
?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('modKirimSpesimenDetail' => $modKirimSpesimenDetail)); ?>
<script type="text/javascript">
    function print(pengirimanspesimen_id) {
        window.open('<?php echo $urlPrint ?>' + pengirimanspesimen_id, 'printwin', 'left=400,top=400,width=800,height=600');
    }

    $("#pengeluaranaset-t-form").find('[class*="integerFloat"]').maskMoney(
            {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 2}
    );

    $(document).ready(function () {

        $('form').bind('click keyup select change', function (event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', function () {
            cekDisabled('form');
        });
        cekDisabled('form');
    });
</script>

<?php
//========= Dialog buat cari data Petugas =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPetugas',
    'options' => array(
        'title' => 'Pencarian Petugas',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modPegawai = new PegawairuanganV('search');
$modPegawai->unsetAttributes();
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
    $modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaipelaksana-m-grid',
    'dataProvider' => $modPegawai->search(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectPemberiTugas",
                "onClick" => "$(\"#' . CHtml::activeId($modKirimSpesimen, 'petugaskirim_id') . '\").val(\"$data->pegawai_id\");
                              $(\"#' . CHtml::activeId($modKirimSpesimen, 'petugaskirim_nama') . '\").val(\"$data->namaLengkap\");
                              $(\"#dialogPetugas\").dialog(\"close\");    
                              return false;
                    "))',
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modPegawai, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Petugas dialog =============================
?>