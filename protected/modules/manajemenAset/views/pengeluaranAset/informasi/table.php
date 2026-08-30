<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - untuk menampilkan data ke dalam bentuk tabel
* RSST-1620
*/
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><i class="entypo-credit-card"></i> Tabel <strong>Pengeluaran Aset</strong></div>
    </div>
    <div class="panel-body" style="overflow-x: ">
        
            <?php
            $this->widget('ext.bootstrap.widgets.BootGridView', array(
                'id' => 'informasi-mutasi-grid',
                'dataProvider' => $model->searchInformasi(),
                'template' => "{summary}\n{items}\n{pager}",
                'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                'columns' => array(
                    array(
                        'header' => 'No',
                        'value' => '$row+1',
                    ),
                    array(
                        'header' => 'No & Tanggal Pengeluaran',
                        'type' => 'raw', 
                        'value' => '$data->nopengeluaranaset."/<br/>".MyFormatter::formatDateTimeForUser($data->tglpengeluaranaset)'
                    ),
                    array(
                        'header' => 'Jenis/Peruntukan',
                        'type' => 'raw', 
                    'value' => '$data->jenisperuntukan'
                    ),
                    array(
                        'header' => 'No & Tanggal Surat Perintah',
                        'type' => 'raw', 
                        'value' => '$data->no_suratperintah."/<br/>".MyFormatter::formatDateTimeForUser($data->tglsuratperintah)'
                    ),
                    array(
                        'header' => 'Tanggal Penyerahan',
                        'type' => 'raw', 
                        'value' => 'MyFormatter::formatDateTimeForUser($data->tglpenyerahan)'
                    ),
                    array(
                        'header' => 'Pegawai Mengeluarkan',
                        'type' => 'raw', 
                        'value' => '$data->pengeluaran_nama'
                    ),
                    array(
                        'header' => 'Alasan',
                        'type' => 'raw', 
                        'value' => '$data->alasan_pengeluaran'
                    ),
                    
                    array(
                            'header'=>'Rincian',
                            'type'=>'raw',
                            'htmlOptions'=>array('style'=>'text-align:center;'),
                            'value'=>function($data){
                                return CHtml::Link("<span style='font-size:17px'><i class='".MyIcon::getIcons('lihat2')."'></i></span>",Yii::app()->controller->createUrl("lihatDetail",array("pengeluaranaset_id"=>$data->pengeluaranaset_id,"detail"=>'detail')),
                                    array("class"=>"", 
                                              "target"=>"frameDetail",
                                              "onclick"=>"$('#dialogDetail').dialog('open');",
                                              "rel"=>"tooltip",
                                              "title"=>"Klik untuk melihat detail pengeluaran aset",
                                    ));
                            },
                    ),
                                    
                   
                ),
                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
            ));
            ?>
        
    </div>
</div>	


