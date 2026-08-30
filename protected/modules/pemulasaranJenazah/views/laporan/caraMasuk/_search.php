<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/dropCheck.css');
?>
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
        label.checkbox,
        label.radio {
            width: 150px;
            display: inline-block;
        }
    </style>
    <div class="row">
        <div class="col-sm-6">
            <?php echo CHtml::hiddenField('type', ''); ?>
            <div class="control-group">
                <?php echo $form->hiddenField($model, 'jns_periode', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'bln_awal', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'bln_akhir', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'thn_awal', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'thn_akhir', array('class' => 'span2')); ?>
                <?php echo CHtml::label("Periode Laporan", 'tgl_rekam', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
            <?php
            echo CHtml::hiddenField('filter', 'asalrujukan_id', array('disabled' => 'disabled')) .
                '<div class="control-group">
    ' . CHtml::label('Rujukan', 'asalrujukan_id', array('class' => 'control-label')) . ' 
    <div class="controls">
        ' . $form->dropDownList($model, 'asalrujukan_id', CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = true'), 'asalrujukan_id', 'asalrujukan_nama'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )) . '
    </div>
</div>';
            ?>
        </div>
        <div class="col-sm-6">
            <?php
            echo CHtml::hiddenField('filter', 'instalasiasal_id', array('disabled' => 'disabled')) .
                '<div class="control-group">
    ' . CHtml::label('Instalasi', 'instalasiasal_id', array('class' => 'control-label')) . ' 
    <div class="controls">
        ' . $form->dropDownList($model, 'instalasiasal_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )) . '
    </div>
</div>
<div class="control-group">
    ' . CHtml::label('Ruangan', 'ruanganasal_id', array('class' => 'control-label')) . ' 
    <div class="controls">												 
        ' . $form->dropDownList(
                    $model,
                    'ruanganasal_id',
                    array(),
                    array('class' => 'form-control', 'multiple' => 'multiple')
                ) . '
    </div>
</div>';

            echo '<div class="control-group"><label class="control-label">Opsi Grafik</label><div class="controls"><table>
            <tr>
                <td style="width: 100px;">' . CHtml::radioButton('tampilGrafik', true, array('name' => 'dataGrafik', 'value' => 'instalasiasal', 'id' => 'rinstalasiasal',)) . ' <label for="rinstalasiasal">Instalasi Asal</label></td>
                <td style="width: 100px;">' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'ruanganasal', 'id' => 'rruanganasal',)) . ' <label for="rruanganasal">Ruangan Asal</label></td>
                <td>' . CHtml::radioButton('tampilGrafik', true, array('name' => 'dataGrafik', 'value' => 'rujukan', 'id' => 'rrujukan',)) . ' <label for="rrujukan">Rujukan</label></td>
            </tr>
            </table></div></div>';
            ?>
        </div>

        <!--<div class="row">
        <div class="col-sm-6">
            <fieldset>
                <?php
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'rujukan',
                    'slide' => true,
                    'content' => array(
                        'content1' => array(
                            'multi' => 'multi',
                            'header' => 'Berdasarkan Rujukan',
                            'isi' => CHtml::hiddenField('filter', 'asalrujukan_id', array('disabled' => 'disabled')) .
                                '<div class="control-group">
									' . CHtml::label('Rujukan', 'asalrujukan_id', array('class' => 'control-label')) . ' 
									<div class="controls">
										' . $form->dropDownList($model, 'asalrujukan_id', CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = true'), 'asalrujukan_id', 'asalrujukan_nama'), array(
                                    'class' => 'form-control', 'multiple' => 'multiple'
                                )) . '
									</div>
								</div>',
                            'active' => true,
                        ),
                    ),
                ));
                ?>
            </fieldset>
        </div>
        <div class="col-sm-6">
            <fieldset>
                <?php
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'instalruangan',
                    'slide' => true,
                    'content' => array(
                        'content2' => array(
                            'multi' => 'multi',
                            'header' => 'Berdasarkan Instalasi dan Ruangan',
                            'isi' => CHtml::hiddenField('filter', 'instalasiasal_id', array('disabled' => 'disabled')) .
                                '<div class="control-group">
									' . CHtml::label('Instalasi', 'instalasiasal_id', array('class' => 'control-label')) . ' 
									<div class="controls">
										' . $form->dropDownList($model, 'instalasiasal_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array(
                                    'class' => 'form-control', 'multiple' => 'multiple'
                                )) . '
									</div>
								</div>
								<div class="control-group">
									' . CHtml::label('Ruangan', 'ruanganasal_id', array('class' => 'control-label')) . ' 
									<div class="controls">												 
										' . $form->dropDownList(
                                    $model,
                                    'ruanganasal_id',
                                    array(),
                                    array('class' => 'form-control', 'multiple' => 'multiple')
                                ) . '
									</div>
								</div>',
                            'active' => true,
                        ),
                    ),
                ));
                ?>
            </fieldset>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <fieldset>
                <?php
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'grafik',
                    'slide' => true,
                    'content' => array(
                        'content3' => array(
                            'header' => 'Opsi Grafik',
                            'isi' =>
                            '<table>
									<tr>
									    <td style="width: 100px;">' . CHtml::radioButton('tampilGrafik', true, array('name' => 'dataGrafik', 'value' => 'instalasiasal', 'id' => 'rinstalasiasal',)) . ' <label for="rinstalasiasal">Instalasi Asal</label></td>
										<td style="width: 100px;">' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'ruanganasal', 'id' => 'rruanganasal',)) . ' <label for="rruanganasal">Ruangan Asal</label></td>
										<td>' . CHtml::radioButton('tampilGrafik', true, array('name' => 'dataGrafik', 'value' => 'rujukan', 'id' => 'rrujukan',)) . ' <label for="rrujukan">Rujukan</label></td>
									</tr>
								</table>',
                            'active' => TRUE,
                        ),
                    ),
                )); ?>
            </fieldset>
        </div>-->
    </div>

    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
        );
        ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . '') . '";}); return false;'
            )
        ); ?>
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); 
    ?>
</div>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>
<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#content4").find("input[type=\'checkbox\']").attr("checked", "checked");
',  CClientScript::POS_READY);
?>
<script>
    function checkAll() {
        if ($("#checkAllInstalasi").is(":checked")) {
            $('#instalasi input[name*="ruanganasal_id"]').each(function() {
                $(this).attr('checked', true);
            })
            //        myAlert('Checked');
        } else {
            $('#instalasi input[name*="ruanganasal_id"]').each(function() {
                $(this).removeAttr('checked');
            })
        }

        if ($("#checkAllRujukan").is(":checked")) {
            $('#rujukan input[name*="asalrujukan_id"]').each(function() {
                $(this).attr('checked', true);
            })
            //        myAlert('Checked');
        } else {
            $('#rujukan input[name*="asalrujukan_id"]').each(function() {
                $(this).removeAttr('checked');
            })
        }
    }
</script>