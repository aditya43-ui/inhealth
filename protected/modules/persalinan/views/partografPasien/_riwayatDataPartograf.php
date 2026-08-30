<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Riwayat Pemeriksaan Partograf</div>
    </div>
    <div class="panel-body" style="overflow-x: auto; max-width: 100%;">
        <div class="block-tabel">
            <div style="overflow-x: auto;">
                <?php
                $modList = new PartografpasienT();
                $modList->unsetAttributes();
                $modList->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $prov = $modList->search();

                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'observasi-grid',
                    'dataProvider' => $prov,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header'=>'No',
                            'type'=>'raw',
                            'value'=>'$row+1',
                        ),
                          array(
                            'header'=>'Tanggal Pendaftaran / No. Pendaftaran',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->pendaftaran->tgl_pendaftaran)." / ".$data->pendaftaran->no_pendaftaran',
                        ),
                        array(
                            'header'=>'Data Awal',
                            'type'=>'raw',
                            'value'=>function($data) {
                                return CHtml::link(
                                    '<icon class="fa fa-file" style="font-size:14pt"></icon>', Yii::app()->createUrl("/persalinan/DataAwal/DetailDataAwal", array("pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)), 
                                    array(
                                        "target"=>"iframeDetaiDataAwal",
                                        "onclick"=>"$('#dialogDetailDataAwal').dialog('open');",
                                        "rel"=>"tooltip",
                                        "title"=>"Klik untuk Melihat Detail Data Awal",
            
                                    ));
                            },
                            'htmlOptions'=>array(
                                'style'=>'text-align: center;',
                            )
                        ),
                        array(
                            'header'=>'Kemajuan Persalinan',
                            'type'=>'raw',
                            'value'=>function($data) use (&$partograf) {
                                $partograf = PartografpasienT::model()->findByAttributes(array('pendaftaran_id'=>$data->pendaftaran_id));
                                if (empty($partograf)) {
                                    return "-";
                                }
                                
                                return CHtml::link(
                                '<icon class="fa fa-file" style="font-size:14pt"></icon>', Yii::app()->createUrl("/persalinan/kemajuanPersalinan/detail", array("id"=>$data->partografpasien_id,"frame"=>true)), 
                                array(
                                    "target"=>"iframeDetailKemajuanPersalinan",
                                    "onclick"=>"$('#dialogDetailKemajuanPersalinan').dialog('open');",
                                    "rel"=>"tooltip",
                                    "title"=>"Klik untuk Melihat Detail Kemajuan Persalinan",

                                ));
                            },
                            'htmlOptions'=>array(
                                'style'=>'text-align: center;',
                            )
                        ),
                        array(
                            'header'=>'Kesejahteraan Janin',
                            'type'=>'raw',
                            'value'=>function($data) use (&$partograf) {
                                if (empty($partograf)) {
                                    return "-";
                                }
                                
                                return CHtml::link(
                                '<icon class="fa fa-file" style="font-size:14pt"></icon>', Yii::app()->createUrl("/persalinan/kesejahteraanJanin/detail", array("id"=>$data->partografpasien_id,"frame"=>true)), 
                                array(
                                    "target"=>"iframeDetailKesejahteraanJanin",
                                    "onclick"=>"$('#dialogDetailKesejahteraanJanin').dialog('open');",
                                    "rel"=>"tooltip",
                                    "title"=>"Klik untuk Melihat Detail Kesejahteraan Janin",

                                ));
                            },
                            'htmlOptions'=>array(
                                'style'=>'text-align: center;',
                            )
                        ),
                        array(
                            'header'=>'Kesejahteraan Ibu',
                            'type'=>'raw',
                            'value'=>function($data) use (&$partograf) {
                                if (empty($partograf)) {
                                    return "-";
                                }
                                
                                return CHtml::link(
                                '<icon class="fa fa-file" style="font-size:14pt"></icon>', Yii::app()->createUrl("/persalinan/kesejahteraanIbu/detail", array("id"=>$data->partografpasien_id,"frame"=>true)), 
                                array(
                                    "target"=>"iframeDetailKesejahteraanIbu",
                                    "onclick"=>"$('#dialogDetailKesejahteraanIbu').dialog('open');",
                                    "rel"=>"tooltip",
                                    "title"=>"Klik untuk Melihat Detail Kesejahteraan Ibu",

                                ));
                            },
                            'htmlOptions'=>array(
                                'style'=>'text-align: center;',
                            )
                        ),
                        array(
                            'header'=>'Cetak',
                            'type'=>'raw',
                            'value'=>function($data) use (&$partograf) {
                                if (empty($partograf)) {
                                    return "-";
                                }
                                
                                return CHtml::link(
                                '<icon class="fa fa-print" style="font-size:14pt"></icon>', "#", 
                                array(
                                    "onclick"=>"printPartograf(".$partograf->partografpasien_id."); return false;",
                                    "rel"=>"tooltip",
                                    "data-placement"=>"left",
                                    "title"=>"Klik untuk Mencetak Partograf Pasien",

                                ));
                            },
                            'htmlOptions'=>array(
                                'style'=>'text-align: center;',
                            )
                        ),


                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
                    . '$(".custom-only").keyup(function(){setCustomOnly(this);});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>


<?php
    
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogDetailDataAwal',
        'options' => array(
            'title' => 'Data Awal Pemeriksaan Partograf',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 1000,
            'height' => 500,
            'resizable' => true
        ),
    ));
    ?>
    <iframe name='iframeDetaiDataAwal' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>
<?php
    
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogDetailKemajuanPersalinan',
        'options' => array(
            'title' => 'Kemajuan Persalinan pada Pemeriksaan Partograf',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 1000,
            'height' => 500,
            'resizable' => true
        ),
    ));
    ?>
    <iframe name='iframeDetailKemajuanPersalinan' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>
<?php
    
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogDetailKesejahteraanJanin',
        'options' => array(
            'title' => 'Kesejahteraan Janin pada Pemeriksaan Partograf',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 1000,
            'height' => 500,
            'resizable' => true
        ),
    ));
    ?>
    <iframe name='iframeDetailKesejahteraanJanin' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>
<?php
    
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogDetailKesejahteraanIbu',
        'options' => array(
            'title' => 'Kesejahteraan Ibu pada Pemeriksaan Partograf',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 1000,
            'height' => 500,
            'resizable' => true
        ),
    ));
    ?>
    <iframe name='iframeDetailKesejahteraanIbu' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

    
<script>
    
    function printPartograf(id) {
        window.open("<?php echo $this->createUrl('printPartograf'); ?>&id=" + id,"",'location=_new, width=900px, scrollbars=yes');
    }
    
</script>