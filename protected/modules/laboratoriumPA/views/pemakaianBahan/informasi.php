<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php 
Yii::app()->clientScript->registerScript('cariPasien', "
    $('#pemakaianbahan-form').submit(function(){
        $.fn.yiiGridView.update('pemakaianbahan-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");?>
<?php

$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'pemakaianbahan-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    'method'=>'get',
    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
));

$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Informasi <strong>Pemakaian Bahan</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success panel-shadow">
                        <div class="panel-heading">
                                <div class="panel-title">Tabel <strong>Pemakaian Bahan</strong></div>
                        </div>
                        <div class="panel-body table-responsive">
                            <div class="">
                                <?php
                                    $this->widget('ext.bootstrap.widgets.BootGridView', array(
                                        'id'=>'pemakaianbahan-grid',
                                        'dataProvider'=>$model->searchPemakaianBahan(),
                        //        'filter'=>$model,
                                        'template'=>"{summary}\n{items}\n{pager}",
                                        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                                        'columns'=>array(
                                            array(
                                                'header'=>'Tgl. Pelayanan',
                                                'name'=>'tgl_pelayanan',
                                                'value'=>'MyFormatter::formatDateTimeForUser($data->tglpelayanan)',
                                            ),
                                            array(
                                                'header'=>'Tgl. Pendaftaran/<br/>No. Pendaftaran',
                                                'name'=>'pendaftaran.tgl_pendaftaran',
                                                'type'=>'raw',
                                                'value'=>function($data) use (&$pendaftaran) {
                                                    $pendaftaran = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                                                    return MyFormatter::formatDateTimeForUser($pendaftaran->tgl_pendaftaran)."/<br/>".$pendaftaran->no_pendaftaran;
                                                },
                                            ),
                                            array(
                                                'header'=>'No. Rekam Medik',
                                                'type'=>'raw',
                                                'value'=>function($data) use (&$pasien) {
                                                    $pasien = PasienM::model()->findByPk($data->pasien_id);
                                                    return $pasien->no_rekam_medik;
                                                }
                                            ),
                                            array(
                                                'header'=>'Nama Pasien',
                                                'type'=>'raw',
                                                'value'=>function($data) use (&$pasien) {
                                                    return $pasien->namadepan.$pasien->nama_pasien;
                                                }
                                            ),
                                            array(
                                                'header'=>'Umur',
                                                'type'=>'raw',
                                                'value'=>function($data) use (&$pendaftaran) {
                                                    return $pendaftaran->umur;
                                                }
                                            ),
                                            array(
                                                'header'=>'Alamat Pasien',
                                                'type'=>'raw',
                                                'value'=>function($data) use (&$pasien) {
                                                    return $pasien->alamat_pasien;
                                                }
                                            ),
                                            array(
                                                'header'=>'Jenis Kasus Penyakit',
                                                'type'=>'raw',
                                                'value'=>function($data) use (&$pendaftaran) {
                                                    return $pendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama;
                                                }
                                            ),
                                            array(
                                                'header'=>'Jenis Penjamin /<br/>Penjamin',
                                                'type'=>'raw',
                                                'value'=>function($data)  {
                                                    return $data->carabayar->carabayar_nama."/<br/>".$data->penjamin->penjamin_nama;
                                                }
                                            ),
                                            array(
                                                'header'=>'Tindakan Pelayanan',
                                                'type'=>'raw',
                                                'value'=>function($data) {
                                                    if (empty($data->tindakanpelayanan_id)) return "-";
                                                        return $data->tindakanpelayanan->daftartindakan->daftartindakan_nama;
                                                },
                                            ),
                                            array(
                                                'header'=>'Obat Alkes',
                                                'name'=>'obatalkes_id',
                                                'type'=>'raw',
                                                'value'=>'$data->obatalkes->obatalkes_nama',
                                            ),
                                            array(
                                                'header'=>'Jenis Obat',
                                                'type'=>'raw',
                                                'value'=>function($data) use (&$obatalkes) {
                                                    $obatalkes = ObatalkesM::model()->findByPk($data->obatalkes_id);
                                                    return empty($obatalkes->jenisobatalkes_id)?"-":$obatalkes->jenisobatalkes->jenisobatalkes_nama;
                                                }
                                            ),
                                            array(
                                                'header'=>'Kategori Obat',
                                                'type'=>'raw',
                                                'value'=>function($data) use (&$obatalkes) {
                                                    return empty($obatalkes->obatalkes_kategori)?"-":$obatalkes->obatalkes_kategori;
                                                }
                                            ),
                                            array(
                                                'header'=>'Golongan Obat',
                                                'type'=>'raw',
                                                'value'=>function($data) use (&$obatalkes) {
                                                    $obatalkes = ObatalkesM::model()->findByPk($data->obatalkes_id);
                                                    return empty($obatalkes->obatalkes_golongan)?"-":$obatalkes->obatalkes_golongan;
                                                }
                                            ),
                                            array(
                                                'header'=>'Qty',
                                                'name'=>'qty_oa',
                                                'type'=>'raw',
                                                'value'=>'$data->qty_oa." ".$data->satuankecil->satuankecil_nama',
                                                'htmlOptions'=>array(
                                                    'style'=>'text-align: right',
                                                )
                                            ),
                                            array(
                                                'header'=>'Beban Biaya',
                                                'value'=>'"Rp".MyFormatter::formatNumberForPrint($data->hargasatuan_oa)',
                                                'htmlOptions'=>array(
                                                    'style'=>'text-align: right',
                                                )
                                            ),
                                            array(
                                                'header'=>'Harga<br/>Jual',
                                                'value'=>'"Rp".MyFormatter::formatNumberForPrint($data->hargajual_oa)',
                                                'htmlOptions'=>array(
                                                    'style'=>'text-align: right',
                                                )
                                            ),
                                            array(
                                                'header' => 'Status',
                                                'name' => 'statusoa'
                                            ),
                                            /*
                                            array(
                                                    'name'=>'tglpemakaianobat',
                                                    'value'=>'MyFormatter::formatDateTimeForUser($data->tglpemakaianobat)',
                                            ),
                                            array(
                                                    'name'=>'nopemakaian_obat',
                                            ),
                                            array(
                                                    'header'=>'Pegawai',
                                                    'name'=>'pegawai.pegawai_nama',
                                                    'type'=>'raw',
                                                    'value'=>'$data->pegawai->namaLengkap',
                                            ),
                                            array(
                                                    'name'=>'untukkeperluan_obat',
                                            ),
                                            array(
                                                    'header'=>'Detail',
                                                    'type'=>'raw',
                                                    'value'=>function($data) {
                                                            return CHtml::link(
                                                                            '<i class="icon-form-detail"></i>', 
                                                                            $this->createUrl('detail', array('id'=>$data->pemakaianobat_id)),
                                                                            array(
                                                                                    'target'=>'iframeDetail',
                                                                                    'onclick'=>'$("#dialogDetail").dialog("open");',
                                                                            ));
                                                    },
                                                    'htmlOptions'=>array('style'=>'text-align: center'),
                                            ),
                                             * 
                                             */
                                        ),
                                        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                                    ));
                                ?>
                            </div>
                        </div>
                </div>
                <div class="panel panel-shadow panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Pencarian Pemakaian Obat</div>
                    </div>
                    <div class="panel-body">
                        <div class="row-fluid">
                            <div class="col-sm-6">
                                <div class="control-group">		
                                    <?php echo CHtml::label("Tanggal Pelayanan",'tgl_rekam', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tglAwal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tglAkhir)) ?>">
                                            <i class="entypo-calendar"></i>
                                            <span ><?php echo date('F d, Y', strtotime($model->tglAwal)) ?> - <?php echo date('F d, Y', strtotime($model->tglAkhir)) ?></span>
                                            <?php echo $form->hiddenField($model,'tglAwal', array('class' => 'start')) ?>
                                            <?php echo $form->hiddenField($model,'tglAkhir', array('class' => 'end')) ?>
                                        </div>
                                    </div>
                                </div>								
                                <div class="control-group">
                                    <?php echo CHtml::label('No. Pendaftaran','no_pendaftaran', array('class'=>'control-label')) ?>
                                    <div class="controls">
                                        <div class="controls">
                                            <?php 
                                                $ini = ModulK::model()->findByPk(Yii::app()->session['modul_id']);
                                                $pr = Params::getPrefixNoPendaftaran();

                                                if(Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RI)
                                                {
                                                    $prefix = array(
                                                        0 => Params::PREFIX_RAWAT_DARURAT,
                                                        1 => Params::PREFIX_RAWAT_INAP,
                                                        2 => Params::PREFIX_RAWAT_JALAN
                                                    );                                            
                                                }elseif(Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_LAB_PA){
                                                    $prefix = array(
                                                        0 => Params::PREFIX_RAWAT_DARURAT,
                                                        1 => Params::PREFIX_RAWAT_INAP,
                                                        2 => Params::PREFIX_RAWAT_JALAN,
                                                        3 => Params::PREFIX_LABORATORIUM,
                                                    );       
                                                }elseif(Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RAD){
                                                    $prefix = array(
                                                        0 => Params::PREFIX_RAWAT_DARURAT,
                                                        1 => Params::PREFIX_RAWAT_INAP,
                                                        2 => Params::PREFIX_RAWAT_JALAN,
                                                        3 => Params::PREFIX_RADIOLOGI,
                                                    );       
                                                }elseif(Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_VERLOS_KAMER){
                                                    $prefix = array(
                                                        0 => Params::PREFIX_RAWAT_DARURAT,                                               
                                                    );
                                                }else{
                                                    if (isset($pr[$ini->modul_key])){
                                                        if (!empty($pr[$ini->modul_key])){
                                                            $prefix = array(
                                                                    0 => $pr[$ini->modul_key]
                                                            );
                                                        }else{
                                                            $prefix='';
                                                        }
                                                    }else{
                                                        $prefix='';
                                                    }
                                                }
                                                echo $form->dropDownList($model,'prefix_pendaftaran', PendaftaranT::model()->getColumn($prefix),array('class'=>'numbers-only', 'style'=>'width:75px;')); 
                                            ?>
                                            <?php echo $form->textField($model, 'no_pendaftaran', array('class' => 'span2 numbers-only', 'maxlength' => 10,'placeholder'=>'Ketik No. Pendaftaran')); ?>

                                            <?php //echo $form->textField($model, 'no_pendaftaran', array('class'=>'span3')); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label('No. Rekam Medik','no_rekam_medik', array('class'=>'control-label')) ?>
                                    <div class="controls">
                                        <div class="controls">
                                            <?php echo $form->textField($model, 'no_rekam_medik', array('class'=>'span3 numbers-only', 'placeholder' => 'Ketik No Rekam Medik','maxlength'=>8)); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label('Nama Pasien','nama_pasien', array('class'=>'control-label')) ?>
                                    <div class="controls">
                                        <div class="controls">
                                            <?php echo $form->textField($model, 'nama_pasien', array('class'=>'span3 hurufs-only', 'placeholder' => 'Ketik Nama Pasien')); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <?php 
                                $carabayar = CarabayarM::model()->findAll(array(
                                    'condition'=>'carabayar_aktif = true',
                                    'order'=>'carabayar_nama ASC',
                                ));
                                foreach ($carabayar as $idx=>$item) {
                                        $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                                            'carabayar_id'=>$item->carabayar_id,
                                            'penjamin_aktif'=>true,
                                   ));
                                   if (empty($penjamins)) unset($carabayar[$idx]);
                                }
                                $penjamin = PenjaminpasienM::model()->findAll(array(
                                    'condition'=>'penjamin_aktif = true',
                                    'order'=>'penjamin_nama',
                                ));
                                $jenisobat = JenisobatalkesM::model()->findAll(array(
                                    'condition'=>'jenisobatalkes_aktif = true',
                                    'order'=>'jenisobatalkes_nama',
                                ));

                                ?>
                                <div class="control-group">
                                    <?php echo CHtml::activeLabel($model,'carabayar_id', array('class'=>'control-label')) ?>
                                    <div class="controls">
                                        <div class="controls">
                                            <?php 
                                            echo $form->dropDownList($model,'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                                                'empty'=>'-- Pilih --',
                                                'class'=>'span3', 
                                                'ajax' => array('type'=>'POST',
                                                    'url'=> $this->createUrl('/actionDynamic/getPenjaminPasien',array('encode'=>false,'namaModel'=>get_class($model))), 
                                                    'success'=>'function(data){$("#'.CHtml::activeId($model, "penjamin_id").'").html(data); }',
                                                ),
                                            ));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::activeLabel($model,'penjamin_id', array('class'=>'control-label')) ?>
                                    <div class="controls">
                                        <div class="controls">
                                            <?php 
                                            echo $form->dropDownList($model,'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3'));
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <?php echo CHtml::activeLabel($model,'jenisobatalkes_id', array('class'=>'control-label')) ?>
                                    <div class="controls">
                                        <div class="controls">
                                            <?php 
                                            echo $form->dropDownList($model,'jenisobatalkes_id', CHtml::listData($jenisobat, 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3'));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::activeLabel($model,'obatalkes_kategori', array('class'=>'control-label')) ?>
                                    <div class="controls">
                                        <div class="controls">
                                            <?php echo $form->dropDownList($model,'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array('empty'=>'-- Pilih --', 'class'=>'span3')); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::activeLabel($model,'obatalkes_golongan', array('class'=>'control-label')) ?>
                                    <div class="controls">
                                        <div class="controls">
                                            <?php echo $form->dropDownList($model,'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array('empty'=>'-- Pilih --', 'class'=>'span3')); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label('Nama Obat','obatalkes_nama', array('class'=>'control-label')) ?>
                                    <div class="controls">
                                        <div class="controls">
                                            <?php echo $form->textField($model, 'obatalkes_nama', array('class'=>'span3 custom-only')); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>				             
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset','onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = window.location.href;} ); return false;')); ?>
                    <?php
                    $content = $this->renderPartial('laboratoriumPA.views.pemakaianBahan.tips/tipsInformasiPemakaianBahan',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                    ?>
                </div>	
            </div>
        </div>
    </div>
</div>                
   
<?php $this->endWidget(); ?>

