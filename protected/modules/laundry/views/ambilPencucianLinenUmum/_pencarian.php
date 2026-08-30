<?php
/**
 * view ini digunakan untuk menampilkan form pencarian
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     1.0.0 
 */
?>
<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'pencarian-form',
        'type' => 'horizontal',
        'focus' => '#' . CHtml::activeId($modInfo, 'nopencucian'),
    ));
    ?>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->hiddenField($modInfo, 'pencucianlinenumum_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo CHtml::label('No. Pencucian', '', array('class' => 'control-label')) ?>
                    <div class="controls">

                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modInfo,
                            'attribute' => 'nopencucian',
                            'source' => 'js: function(request, response) {
			$.ajax({
                                                        url: "' . $this->createUrl('AutocompletePencucian') . '",
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
                                    $("#' . Chtml::activeId($modInfo, 'nopencucian') . '").val(ui.item.label); 
                                    $("#' . Chtml::activeId($modInfo, 'pencucianlinenumum_id') . '").val(ui.item.value); 
                                    setPencucian(ui.item.value);
                        return false;
                        }',
                            ),
                            'htmlOptions' => array(
//                            'placeholder' => 'Pegawai Menerima',
                                'class' => 'nopencucian',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modPencucian, 'nopencucian') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogNo'),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Tanggal Pencucian', '', array('class' => 'control-label')) ?>
                    <div class="controls"> 
                        <?php echo $form->textField($modInfo, 'tglpencucian', array('class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Nama Pengirim', '', array('class' => 'control-label')) ?>
                    <div class="controls"> 
                        <?php echo $form->textField($modInfo, 'namapengirim', array('class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <?php
                ?>
                <div class="control-group">
                    <?php echo CHtml::label('Mesin Pencucian', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modInfo, 'mesinpencucian_nama', array('class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true)); ?>                        
                    </div>
                </div>
                <?php echo $form->textAreaRow($modInfo, 'keterangan', array('rows' => 3, 'cols' => 50, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => '', 'readonly' => true)); ?>
            </div>

            <div class="form-actions">
                <?php // echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit'));  ?>
                <?php
//        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-default',
//            'onclick' => 'return refreshForm(this);'));
                ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
    <?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogNo',
        'options' => array(
            'title' => 'Pencarian Pegawai Mengetahui',
            'autoOpen' => false,
            'modal' => true,
            'width' => 900,
            'height' => 400,
            'resizable' => true,
        ),
    ));

    $modInfoPc = new InformasipencucianlinenumumV('search');
    $modInfoPc->unsetAttributes();
    if (isset($_GET['InformasipencucianlinenumumV'])) {
        $modPegawaiMengetahui->attributes = $_GET['InformasipencucianlinenumumV'];
    }
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'nopencucian-grid',
        'dataProvider' => $modInfoPc->search(),
//    'filter' => $modInfoPc,
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
			$(\"#' . CHtml::activeId($modInfo, 'nopencucian') . '\").val(\"$data->nopencucian\");
                                                setPencucian($data->pencucianlinenumum_id);
			$(\"#dialogNo\").dialog(\"close\"); 
			return false;
		"))',
            ),
            array(
                'header' => 'Tanggal Penerimaan',
                'value' => 'MyFormatter::formatDateTimeId($data->tglpenerimaan)',
            ),
            array(
                'header' => 'No. Penerimaan',
                'value' => '$data->nopenerimaan',
            ),
            array(
                'header' => 'Tanggal Pencucian',
                'value' => 'MyFormatter::formatDateTimeId($data->tglpencucian)',
            ),
            array(
                'header' => 'No. Penerimaan',
                'value' => '$data->nopencucian',
            ),
            array(
                'header' => 'Nama Pengirim',
                'value' => '$data->namapengirim',
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){
	jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));
    $this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
    ?>

    <script>

        function setPencucian(obj) {

            var id = obj;

            $.post('<?php echo $this->createUrl('getPencucian'); ?>', {id: id}, function (data) {

                $("#InformasipencucianlinenumumV_tglpencucian").val(data.tanggal);
                $("#InformasipencucianlinenumumV_namapengirim").val(data.namapengirim);
                $("#InformasipencucianlinenumumV_mesinpencucian_nama").val(data.namamesin);
                $("#InformasipencucianlinenumumV_keterangan").val(data.keterangan);

            }, 'json');

            $(".tbl-detailr").addClass("animation-loading");

            $.post('<?php echo $this->createUrl('getDetail'); ?>', {id: id}, function (data) {

                $(".tbl-detailr tbody").html(data.tr);

            }, 'json');

            $(".tbl-detailr").removeClass("animation-loading");

        }

    </script>