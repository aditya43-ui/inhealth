<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-user"></i> Data <b>Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('No. Rekam Medik', 'pasien_id', array('class' => 'control-label required')); ?>
                    <div class="controls">
                    <?php echo CHtml::textField('pasien[no_rekam_medik]',$modPendaftaran->pasien->no_rekam_medik, array('readonly' => true)); ?>
          
                        <?php
        //                 $this->widget('MyJuiAutoComplete', array(
        //                     'name' => 'pasien[no_rekam_medik]',
        //                     'value'=> $modPendaftaran->pasien->no_rekam_medik,
        //                     'source' => 'js: function(request, response) {
		// 	console.log(request);
		// 	$.ajax({
        //                 url: "' . $this->createUrl('autocompleteNoRM') . '",
        //                 dataType: "json",
        //                 data: {
        //                     no_rm: request.term,
        //                 },
        //                 success: function (data) {
        //                     response(data);
        //                 }
        //             });
		// }',
        //                     'options' => array(
        //                         'minLength' => 3,
        //                         'focus' => 'js:function( event, ui ) {
		// 		$(this).val("");
		// 		return false;
		// 	}',
        //                         'select' => 'js:function( event, ui ) {
		// 		$(this).val(ui.item.no_rekam_medik	);
		// 		$("#pasien_no_rekam_medik").val(ui.item.no_rekam_medik);
		// 		inputPasien(ui.item);
		// 		return false;
		// 	}',
        //                     ),
        //                     'tombolDialog' => array('idDialog' => 'dialogPasien'),
        //                     'htmlOptions' => array(
        //                         'class' => 'span3 required', 'placeholder' => 'No. Rekam Medik', 'rel' => 'tooltip', 'title' => '"Ketik Nama Pasien" / klik icon untuk mencari data pasien',
        //                         'onkeyup' => "return $(this).focusNextInputField(event)",
        //                         'onblur' => 'setNoRM($(this));',
        //                     ),
        //                 ));
                        echo CHtml::htmlButton('Salin No. RM', array('class' => 'btn btn-primary', 'onclick' => 'salinNoRM();'));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Nama Pasien', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::hiddenField('pasien[pasien_id]', $modPendaftaran->pasien->pasien_id); ?>
                        <?php echo CHtml::textField('pasien[nama_pasien]',$modPendaftaran->pasien->nama_pasien, array('readonly' => true)); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Tgl. Lahir', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('pasien[tanggal_lahir]', $modPendaftaran->pasien->tanggal_lahir, array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Jenis Kelamin', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('pasien[jeniskelamin]', $modPendaftaran->pasien->jeniskelamin, array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Alamat Pasien', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('pasien[alamat_pasien]', $modPendaftaran->pasien->alamat_pasien, array('readonly' => true)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));
$pasien = new RKPasienM('search');
if (isset($_GET['RKPasienM'])) {
    $pasien->attributes = $_GET['RKPasienM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasien-m-grid',
    'dataProvider' => $pasien->searchDialog(),
    'filter' => $pasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                $dt['namadepan'] = $data->namadepan;
                $dt['nama_pasien'] = $data->nama_pasien;
                $dt['pasien_id'] = $data->pasien_id;
                $dt['no_rekam_medik'] = $data->no_rekam_medik;
                $dt['alamat_pasien'] = $data->alamat_pasien;
                $dt['jeniskelamin'] = $data->jeniskelamin;
                $dt['tanggal_lahir'] = !empty($data->tanggal_lahir) ? MyFormatter::formatDateTimeForUser($data->tanggal_lahir) : null;
                $res = json_encode($dt);

                return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>', "javascript:void(0);", array(
                    "class" => "btn-small",
                    "id" => "selectPegawai",
                    "onclick" => "inputPasien(" . $res . ")"
                ));
            },
        ),
        'no_rekam_medik',
        'nama_pasien',
        'jeniskelamin',
        array(
            'header' => 'Tanggal Lahir',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)'
        )
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>