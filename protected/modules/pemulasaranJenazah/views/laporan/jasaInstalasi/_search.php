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
        #penjamin label.checkbox {
            width: 100px;
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
            echo CHtml::hiddenField('filter', 'tindakansudahbayar_id', array('disabled' => 'disabled')) .
                '<div class="control-group">
                ' . CHtml::label('Status Bayar', 'tindakansudahbayar_id', array('class' => 'control-label')) . ' 
                <div class="controls">
                    ' . $form->dropDownList($model, 'tindakansudahbayar_id', CustomFunction::getStatusBayar(), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )) . '
                </div>
            </div>';

            echo CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
                '<div class="control-group">
                    ' . CHtml::label('Jenis Penjamin', 'carabayar_id', array('class' => 'control-label')) . ' 
                    <div class="controls">
' . $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )) . '
                    </div>
                </div>
                <div class="control-group">
                    ' . CHtml::label('Penjamin', 'penjamin_id', array('class' => 'control-label')) . ' 
                    <div class="controls">	 
' . $form->dropDownList(
                    $model,
                    'penjamin_id',
                    array(),
                    array('class' => 'form-control', 'multiple' => 'multiple')
                ) . ' 		
                    </div>
                </div>';
            ?>
        </div>

        <div class="col-sm-6">
            <?php
            echo CHtml::hiddenField('filter', 'nama_pegawai', array('disabled' => 'disabled')) .
                '<div class="control-group">
            ' . CHtml::label('Dokter', 'nama_pegawai', array('class' => 'control-label')) . ' 
            <div class="controls">
                ' . $form->dropDownList($model, 'nama_pegawai',  CHtml::listData(DokterV::model()->findAll("pegawai_aktif = TRUE AND ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "'  "), 'nama_pegawai', 'namaLengkap'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )) . '
            </div>
        </div>';

            echo '<div class="control-group"><label class="control-label">Opsi Grafik</label><div class="controls"><table>                                                                             
            <tr>
                <td>' . CHtml::radioButton('tampilGrafik', true, array('name' => 'dataGrafik', 'value' => 'statusbayar', 'id' => 'rstatusbayar',)) . ' <label for="rstatusbayar">Status Bayar</label></td>
            </tr>
            <tr>
                <td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'carabayar', 'id' => 'rcarabayar',)) . ' <label for="rcarabayar">Jenis Penjamin</label></td>
            </tr>
            <tr>
                <td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'dokter', 'id' => 'rdokter',)) . ' <label for="rdokter">Dokter</label></td>                                                 
            </tr>
        </table>'
            ?>
        </div>
    </div>
</div>
</div>
<!--<div class="row">
        <div class="col-sm-6">
            <fieldset>
                <?php
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'statusbayar',
                    'slide' => true,
                    'content' => array(
                        'content1' => array(
                            'multi' => 'multi',
                            'header' => 'Berdasarkan Status Bayar',
                            'isi' => CHtml::hiddenField('filter', 'tindakansudahbayar_id', array('disabled' => 'disabled')) .
                                '<div class="control-group">
									' . CHtml::label('Status Bayar', 'tindakansudahbayar_id', array('class' => 'control-label')) . ' 
									<div class="controls">
										' . $form->dropDownList($model, 'tindakansudahbayar_id', CustomFunction::getStatusBayar(), array(
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
                    'id' => 'doter',
                    'slide' => true,
                    'content' => array(
                        'content3' => array(
                            'multi' => 'multi',
                            'header' => 'Berdasarkan Dokter',
                            'isi' => CHtml::hiddenField('filter', 'nama_pegawai', array('disabled' => 'disabled')) .
                                '<div class="control-group">
									' . CHtml::label('Dokter', 'nama_pegawai', array('class' => 'control-label')) . ' 
									<div class="controls">
										' . $form->dropDownList($model, 'nama_pegawai',  CHtml::listData(DokterV::model()->findAll("pegawai_aktif = TRUE AND ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "'  "), 'nama_pegawai', 'namaLengkap'), array(
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
                    'id' => 'carabayar',
                    'slide' => true,
                    'content' => array(
                        'content2' => array(
                            'multi' => 'multi',
                            'header' => 'Berdasarkan Jenis Penjamin',
                            'isi' => CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
                                '<div class="control-group">
										' . CHtml::label('Jenis Penjamin', 'carabayar_id', array('class' => 'control-label')) . ' 
										<div class="controls">
' . $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                                    'class' => 'form-control', 'multiple' => 'multiple'
                                )) . '
										</div>
									</div>
									<div class="control-group">
										' . CHtml::label('Penjamin', 'penjamin_id', array('class' => 'control-label')) . ' 
										<div class="controls">	 
' . $form->dropDownList(
                                    $model,
                                    'penjamin_id',
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
        <div class="col-sm-6">
            <?php
            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'kunjungan5',
                'slide' => true,
                'content' => array(
                    'content5' => array(
                        'header' => 'Data grafik',
                        'isi' =>
                        '<table>                                                                               
									<tr>
										<td style="width: 100px;">' . CHtml::radioButton('tampilGrafik', true, array('name' => 'dataGrafik', 'value' => 'statusbayar', 'id' => 'rstatusbayar',)) . ' <label for="rstatusbayar">Status Bayar</label></td>
										<td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'carabayar', 'id' => 'rcarabayar',)) . ' <label for="rcarabayar">Jenis Penjamin</label></td>
									</tr>                                       
									<tr>
										<td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'dokter', 'id' => 'rdokter',)) . ' <label for="rdokter">Dokter</label></td>                                                 
									</tr>
								</table>',
                        'active' => TRUE,
                    ),
                ),
            ));
            ?>
        </div>
    </div>-->

<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
    );
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . '') . '";}); return false;'
        )
    );
    ?>
</div>
</div>
<?php //$this->widget('UserTips', array('type' => 'create')); 
?>

<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
',  CClientScript::POS_READY);
?>
<script>
    function checkAll() {
        if ($("#checkAllCaraBayar").is(":checked")) {
            $('#penjamin input[name*="penjamin_id"]').each(function() {
                $(this).attr('checked', true);
            })
            //        myAlert('Checked');
        } else {
            $('#penjamin input[name*="penjamin_id"]').each(function() {
                $(this).removeAttr('checked');
            })
        }
    }
</script>
<?php
//$urlGetPenjamin = Yii::app()->createUrl('ActionDynamic/GetPenjaminPasienForCheckBox', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().''));
//Yii::app()->clientScript->registerScript('ajax','
//    $("#'.CHtml::activeId($model, 'carabayar_id').'").change(function(){
//        id = $(this).val();
//        $.post("'.$urlGetPenjamin.'", {id:id},function(data){
//            
//        });
//    });
//',CClientScript::POS_READY); 
?>

<?php //Yii::app()->clientScript->registerScript('onclickButton','
//  var tampilGrafik = "<div class=\"tampilGrafik\" style=\"display:inline-block\"> <i class=\"icon-arrow-right icon-white\"></i> Grafik</div>";
//  $(".accordion-heading a.accordion-toggle").click(function(){
//            $(this).parents(".accordion").find("div.tampilGrafik").remove();
//            $(this).parents(".accordion-group").has(".accordion-body.in").length ? "" : $(this).append(tampilGrafik);
//            
//            
//  });
//',  CClientScript::POS_READY);
?>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>