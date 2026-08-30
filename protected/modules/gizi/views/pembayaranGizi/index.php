<div class="white-container">
    <legend class="rim2">Informasi <b>Pembayaran Gizi</b></legend>
    <div class="block-tabel">
        <h6>Tabel <b>Pembayaran Gizi</b></h6>
        <?php
        $arrMenu = array();
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','').' Informasi Pembayaran Gizi', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;             
        $this->menu=$arrMenu;
        Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
                $('.search-form').toggle();
                return false;
        });
        $('.search-form form').submit(function(){
                $.fn.yiiGridView.update('rjrinciantagihanpasien-v-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ");
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php 
            $module  = $this->module->name; 
            $controller = $this->id;?>
        <?php
        $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
            'id'=>'rjrinciantagihanpasien-v-grid',
            'dataProvider'=>$model->searchKonsulGizi(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',            
            'columns'=>array(
                         array(
                            'header' => 'Tgl. Pendaftaran/<br>No. Pendaftaran',
                            'type' => 'raw',
                            'value' => '$data->tgl_pendaftaran." / <br>".$data->no_pendaftaran'
                        ),        
                        'tglmasukpenunjang',
                        'no_rekam_medik',
                         array(
                            'header'=>'Nama Pasien',
                            'type'=>'raw',
                            'value'=>'$data->namadepan." ".$data->nama_pasien',
                        ),
                        'alamat_pasien',
                        array(
                            'header'=>'Jenis Penjamin <br> / Penjamin',
                            'type'=>'raw',
                            'value'=>'$data->caraBayarPenjamin',    
                            'htmlOptions'=>array('style'=>'text-align: center; width:40px')
                       ),
                        array(
                            'header'=>'Dokter',
                            'type'=>'raw',
                            'value'=>function($data) use (&$admisi) {
                               // if (!empty($admisi)) return $data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama;
                                return $data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama;
                            },
                            'htmlOptions'=>array(
                               'style'=>'text-align:center;',
                               'class'=>'rajal'
                           )
                        ),  
                        'jeniskasuspenyakit_nama',
                        array(
                            'header'=>'Status Bayar',
                            'type'=>'raw',
                            'value'=>'($data->pembayaranpelayanan_id == TRUE)?"LUNAS":"BELUM LUNAS"',
                       ),            
                        array(
                            'header'=>'Rincian Tagihan',
                            'type'=>'raw',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                            'value'=>'CHtml::Link("<i class=\"icon-form-detailtagihan\"></i>",Yii::app()->createUrl("gizi/PembayaranGizi/rincian",array("id"=>$data->pendaftaran_id,"frame"=>true)),
                                        array("class"=>"", 
                                              "target"=>"iframeRincianTagihan",
                                              "onclick"=>"$(\"#dialogRincian\").dialog(\"open\");",
                                              "rel"=>"tooltip",
                                              "title"=>"Klik untuk melihat Rincian Tagihan",
                                        ))',          'htmlOptions'=>array('style'=>'text-align: center; width:40px')
                        ),
                //RND-5195 - Pembayaran dilakukan dimodul kasir
    //                    array(
    //                        'header'=>'Pembayaran Kasir',
    //                        'type'=>'raw',
    //                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
    //                    ),
                ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));
        ?>
    </div>
    <fieldset class="box search-form">
        <?php $this->renderPartial($this->path_view.'_search',array(
                'model'=>$model,
        )); ?>
    </fieldset>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogRincian',
        'options' => array(
            'title' => 'Rincian Tagihan Pasien',
            'autoOpen' => false,
            'modal' => true,
            'width' => 900,
            'height' => 550,
            'resizable' => false,
        ),
    ));
    ?>
    <iframe name='iframeRincianTagihan' style="width: 100%; height: 98%;"></iframe>
    <?php $this->endWidget(); ?>

    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogPembayaranKasir',
        'options' => array(
            'title' => 'Rincian Tagihan Pasien',
            'autoOpen' => false,
            'modal' => true,
            'width' => 900,
            'height' => 550,
            'resizable' => false,
        ),
    ));
    ?>
    <iframe name='iframePembayaran' style="width:100%; height: 98%;"></iframe>
    <?php $this->endWidget(); ?>
</div>