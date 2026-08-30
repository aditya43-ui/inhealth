<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));

    $format = new MyFormatter();
    ?>

    <?php //echo CHtml::hiddenField('type', ''); 
    ?>
    <?php //echo CHtml::hiddenField('src', ''); 
    ?>
    <div class="row">
        <div class="col-sm-12">
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
        </div>
        <div class="col-sm-6">
            <?php
            echo '<div class="control-group">
            ' . CHtml::label('Dokter Pengirim', 'dokterpengirim_id', array('class' => 'control-label')) . ' 
            <div class="controls">
                ' . $form->dropDownList($model, 'dokterpengirim_id', DokterV::model()->getDropDokterResep(), array(
                'class' => 'form-control', 'multiple' => 'multiple'
            )) . '
            </div>
        </div>';

            // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            //     'id' => 'grafik',
            //     'slide' => true,
            //     'content' => array(
            //         'content5' => array(
            //             'multi' => 'multi',
            //             'header' => 'Dokter Pengirim',
            //             'isi' =>
            //             '<div class="control-group">
            //                                                 ' . CHtml::label('Dokter Pengirim', 'dokterpengirim_id', array('class' => 'control-label')) . ' 
            //                                                 <div class="controls">
            //                                                     ' . $form->dropDownList($model, 'dokterpengirim_id', DokterV::model()->getDropDokterResep(), array(
            //                 'class' => 'form-control', 'multiple' => 'multiple'
            //             )) . '
            //                                                 </div>
            //                                             </div>',
            //             'active' => TRUE,
            //         ),
            //     ),
            // ));
            ?>
        </div>

        <div class="col-sm-6">
            <?php
            echo '<div class="control-group">
            ' . CHtml::label('Klinik Rujukan Keluar', 'dokterpengirim_id', array('class' => 'control-label')) . ' 
            <div class="controls">
                ' . $form->dropDownList($model, 'labklinikrujukan_id', CHtml::listData(LabklinikrujukanM::model()->findAll("labklinikrujukan_aktif = TRUE ORDER BY labklinikrujukan_nama ASC"), 'labklinikrujukan_id', 'labklinikrujukan_nama'), array(
                'class' => 'form-control', 'multiple' => 'multiple'
            )) . '
            </div>
        </div>';

            // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            //     'id' => 'grafik',
            //     'slide' => true,
            //     'content' => array(
            //         'content6' => array(
            //             'multi' => 'multi',
            //             'header' => 'Data Klinik Rujukan',
            //             'isi' =>
            //             '<div class="control-group">
            // 					' . CHtml::label('Klinik Rujukan Keluar', 'dokterpengirim_id', array('class' => 'control-label')) . ' 
            // 					<div class="controls">
            // 						' . $form->dropDownList($model, 'labklinikrujukan_id', CHtml::listData(LabklinikrujukanM::model()->findAll("labklinikrujukan_aktif = TRUE ORDER BY labklinikrujukan_nama ASC"), 'labklinikrujukan_id', 'labklinikrujukan_nama'), array(
            //                 'class' => 'form-control', 'multiple' => 'multiple'
            //             )) . '
            // 					</div>
            // 				</div>',
            //             'active' => TRUE,
            //         ),
            //     ),
            // ));
            ?>
            <?php /*$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
				'id'=>'grafik',
				'slide' => true,
				'content'=>array(
					'content5'=>array(
						'header'=>'Data grafik',
						'isi'=>  
							'<table>
								<tr>
									<td>'.CHtml::radioButton('tampilGrafik', true, array('name'=>'dataGrafik', 'value' => 'wilayah')).' <label>Wilayah</label></td>                                               
									<td>'.CHtml::radioButton('tampilGrafik', false, array('name'=>'dataGrafik', 'value' => 'carabayar')).' <label>Jenis Penjamin</label></td>                                                                                           
								</tr>                                            
								<tr>
									<td>'.CHtml::radioButton('tampilGrafik', false, array('name'=>'dataGrafik', 'value' => 'instalasi')).' <label>Instalasi Asal</label></td>
									<td>'.CHtml::radioButton('tampilGrafik', false, array('name'=>'dataGrafik', 'value' => 'ruangan')).' <label>Ruangan Asal</label></td>
								</tr>
							</table>',          
						'active'=>TRUE,
					),
				),
			));*/ ?>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
        ); ?>
        <?php
        echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl($this->id . '/index'),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        );
        ?>
    </div>
</div>

<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>
<script>
    function checkAll() {
        if ($('#checkAllRuangan').is(':checked')) {
            $('#searchLaporan input[name*="ruanganasal_id"]').each(function() {
                $(this).attr('checked', true);
            });
        } else {
            $('#searchLaporan input[name*="ruanganasal_id"]').each(function() {
                $(this).removeAttr('checked');
            });
        }
    }

    $(document).ready(function() {
        jQuery($("#<?php echo CHtml::activeId($model, 'dokterpengirim_id') ?>")).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery($("#<?php echo CHtml::activeId($model, 'labklinikrujukan_id') ?>")).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();
    });
</script>
<?php //$this->renderPartial('_jsFunctions', array('model' => $model)); 
?>