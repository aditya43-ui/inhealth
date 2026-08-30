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

    <div class="row">
        <div class="col-sm-12">
            <?php echo CHtml::hiddenField('type', ''); ?>
            <div class="control-group">
                <?php echo $form->hiddenField($model, 'jns_periode', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'bln_awal', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'bln_akhir', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'thn_awal', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'thn_akhir', array('class' => 'span2')); ?>
                <?php echo CHtml::label("Periode Laporan", '', array('class' => 'control-label')) ?>
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
            <div id='searching'>
                <?php
                echo CHtml::hiddenField('filter', 'wilayah') .
                    '<div class="control-group">
                            ' . CHtml::label('Provinsi', 'carabayar_id', array('class' => 'control-label')) . ' 
                            <div class="controls">
                                ' . $form->dropDownList($model, 'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array(
                        'class' => 'form-control', 'multiple' => 'multiple'
                    )) . '
                            </div>
                        </div>
                        <div class="control-group">
                            ' . CHtml::label('Kabupaten', 'penjamin_id', array('class' => 'control-label')) . ' 
                            <div class="controls">												 
                                ' . $form->dropDownList(
                        $model,
                        'kabupaten_id',
                        array(),
                        array('class' => 'form-control', 'multiple' => 'multiple')
                    ) . '
                            </div>
                        </div>';

                // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                //     'id' => 'wilayah',
                //     'content' => array(
                //         'content1' => array(
                //             'multi' => 'multi',
                //             'header' => 'Berdasarkan Wilayah',
                //             'isi' => CHtml::hiddenField('filter', 'wilayah') .
                //                 '<div class="control-group">
                //                             ' . CHtml::label('Provinsi', 'carabayar_id', array('class' => 'control-label')) . ' 
                //                             <div class="controls">
                //                                 ' . $form->dropDownList($model, 'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array(
                //                     'class' => 'form-control', 'multiple' => 'multiple'
                //                 )) . '
                //                             </div>
                //                         </div>
                //                         <div class="control-group">
                //                             ' . CHtml::label('Kabupaten', 'penjamin_id', array('class' => 'control-label')) . ' 
                //                             <div class="controls">												 
                //                                 ' . $form->dropDownList(
                //                     $model,
                //                     'kabupaten_id',
                //                     array(),
                //                     array('class' => 'form-control', 'multiple' => 'multiple')
                //                 ) . '
                //                             </div>
                //                         </div>',
                //             'active' => true,
                //         ),
                //     ),
                // ));

                echo CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
                    '<div class="control-group">
                            ' . CHtml::label('Instalasi', 'instalasipemesan_id', array('class' => 'control-label')) . ' 
                            <div class="controls">
                                ' . $form->dropDownList($model, 'instalasipemesan_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array(
                        'class' => 'form-control', 'multiple' => 'multiple'
                    )) . '
                            </div>
                        </div>
                        <div class="control-group">
                            ' . CHtml::label('Ruangan', 'ruanganpemesan_id', array('class' => 'control-label')) . ' 
                            <div class="controls">												 
                                ' . $form->dropDownList($model, 'ruanganpemesan_id', array(), array('class' => 'form-control', 'multiple' => 'multiple')) . '
                            </div>
                        </div>';

                // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                //     'id' => 'instalasi',
                //     'slide' => true,
                //     'content' => array(
                //         'content4' => array(
                //             'multi' => 'multi',
                //             'header' => 'Berdasarkan Instalasi dan Ruangan',
                //             'isi' => CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
                //                 '<div class="control-group">
                //                             ' . CHtml::label('Instalasi', 'instalasipemesan_id', array('class' => 'control-label')) . ' 
                //                             <div class="controls">
                //                                 ' . $form->dropDownList($model, 'instalasipemesan_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array(
                //                     'class' => 'form-control', 'multiple' => 'multiple'
                //                 )) . '
                //                             </div>
                //                         </div>
                //                         <div class="control-group">
                //                             ' . CHtml::label('Ruangan', 'ruanganpemesan_id', array('class' => 'control-label')) . ' 
                //                             <div class="controls">												 
                //                                 ' . $form->dropDownList($model, 'ruanganpemesan_id', array(), array('class' => 'form-control', 'multiple' => 'multiple')) . '
                //                             </div>
                //                         </div>',
                //             'active' => true,
                //         ),
                //     ),
                // ));
                ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div id='searching'>
                <?php
                echo CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
                    '<div class="control-group">
                            ' . CHtml::label('Jenis Penjamin', 'carabayar_id', array('class' => 'control-label')) . ' 
                            <div class="controls">
                                ' . $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array('class' => 'form-control', 'multiple' => 'multiple')) . '
                            </div>
                        </div>
                        <div class="control-group">
                            ' . CHtml::label('Penjamin', 'penjamin_id', array('class' => 'control-label')) . ' 
                            <div class="controls">												 
                                ' . $form->dropDownList($model, 'penjamin_id', array(), array('class' => 'form-control', 'multiple' => 'multiple')) . '
                            </div>
                        </div>';

                // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                //     'id' => 'carabayar',
                //     'slide' => true,
                //     'content' => array(
                //         'content2' => array(
                //             'multi' => 'multi',
                //             'header' => 'Berdasarkan Jenis Penjamin',
                //             'isi' => CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
                //                 '<div class="control-group">
                //                             ' . CHtml::label('Jenis Penjamin', 'carabayar_id', array('class' => 'control-label')) . ' 
                //                             <div class="controls">
                //                                 ' . $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array('class' => 'form-control', 'multiple' => 'multiple')) . '
                //                             </div>
                //                         </div>
                //                         <div class="control-group">
                //                             ' . CHtml::label('Penjamin', 'penjamin_id', array('class' => 'control-label')) . ' 
                //                             <div class="controls">												 
                //                                 ' . $form->dropDownList($model, 'penjamin_id', array(), array('class' => 'form-control', 'multiple' => 'multiple')) . '
                //                             </div>
                //                         </div>',
                //             'active' => true,
                //         ),
                //     ),
                // ));
                ?>

                <div class="control-group">
                    <label class="control-label">Filter</label>
                    <div class="controls">
                        <?php
                        echo '<table>
<tr>
    <td style="width: 100px;">' . CHtml::radioButton('tampilGrafik', true, array('id' => 'rwilayah', 'name' => 'dataGrafik', 'value' => 'wilayah')) . ' <label for="rwilayah">Wilayah</label></td>                                               
    <td>' . CHtml::radioButton('tampilGrafik', false, array('id' => 'rcarabayar', 'name' => 'dataGrafik', 'value' => 'carabayar')) . ' <label for="rcarabayar">Jenis Penjamin</label></td>                                                                                           
</tr>                                            
<tr>
    <td>' . CHtml::radioButton('tampilGrafik', false, array('id' => 'rinstalasi', 'name' => 'dataGrafik', 'value' => 'instalasi')) . ' <label for="rinstalasi">Instalasi Asal</label></td>
    <td>' . CHtml::radioButton('tampilGrafik', false, array('id' => 'rruangan', 'name' => 'dataGrafik', 'value' => 'ruangan')) . ' <label for="rruangan">Ruangan Asal</label></td>
</tr>
</table>';
                        ?>
                    </div>
                </div>


                <?php
                // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                //     'id' => 'grafik',
                //     'slide' => true,
                //     'content' => array(
                //         'content5' => array(
                //             'header' => 'Data grafik',
                //             'isi' =>
                //             '<table>
                //                 <tr>
                //                     <td style="width: 100px;">' . CHtml::radioButton('tampilGrafik', true, array('id' => 'rwilayah', 'name' => 'dataGrafik', 'value' => 'wilayah')) . ' <label for="rwilayah">Wilayah</label></td>                                               
                //                     <td>' . CHtml::radioButton('tampilGrafik', false, array('id' => 'rcarabayar', 'name' => 'dataGrafik', 'value' => 'carabayar')) . ' <label for="rcarabayar">Jenis Penjamin</label></td>                                                                                           
                //                 </tr>                                            
                //                 <tr>
                //                     <td>' . CHtml::radioButton('tampilGrafik', false, array('id' => 'rinstalasi', 'name' => 'dataGrafik', 'value' => 'instalasi')) . ' <label for="rinstalasi">Instalasi Asal</label></td>
                //                     <td>' . CHtml::radioButton('tampilGrafik', false, array('id' => 'rruangan', 'name' => 'dataGrafik', 'value' => 'ruangan')) . ' <label for="rruangan">Ruangan Asal</label></td>
                //                 </tr>
                //             </table>',
                //             'active' => TRUE,
                //         ),
                //     ),
                // ));
                ?>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl($this->id . '/index'),
            array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')
        ); ?>
    </div>
</div>

<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>