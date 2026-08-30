<?php
Yii::app()->clientScript->registerScript('search', "
    $('#penerimaandarah-r-search').submit(function(){
        $.fn.yiiGridView.update('penerimaandarah-r-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");

$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><b>Informasi Distribusi Darah</b></div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Distribusi Darah</b></div>
            </div>
            <div class="panel-body table-responsive" id="tabel_informasi">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'penerimaandarah-r-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'replaceUrl'=>true,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header'=>'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                                ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                : ($row+1)',
                            'type'=>'raw',
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                        ),
                        array(
                            'header'=>'Tgl. Distribusi',
                            'value'=>function($data){
                                return MyFormatter::formatDateTimeForUser($data->tgl_distribusi);
                            },
                        ),
                        array(
                            'header'=>'Nomor Pengiriman',
                            'value'=>function($data){
                                return $data->nomor_pengiriman;
                            },
                        ),
                        array(
                            'header'=>'Petugas Distribusi Pelayanan Donor',
                            'value'=>function($data){
                                return $data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama ;
                              
                            },
                        ),
                        array(
                            'header'=>'Shift Distribusi',
                            'value'=>function($data){
                                return $data->shift_distribusi;
                              
                            },
                        ),
                        array(
                            'header'=>'Status Distribusi',
                            'value'=>function($data){
                                if(!empty($data->terimadistribusidarah_id)){
                                     return "Sudah Diterima";
                                }else{
                                     return "Belum Diterima";
                                }
                               
                              
                            },
                        ),              
                       
                        array(
                            'header'=>'Penerimaan Distribusi',
                            'type'=>'raw',
                            'htmlOptions'=>array('style'=>'text-align:center;'),
                            'value'=>function($data){
                                if($data->terimadistribusidarah_id){
                                    return CHtml::Link("<span style='font-size:17px;color:green'><i class='".MyIcon::getIcons('list')."'></i></span>",$this->createUrl("informasiPenerimaanDistribusiDarah/lihatDetail",array("terimadistribusidarah_id"=>$data->terimadistribusidarah_id, "frame"=>1, 'sukses'=>1)),
                                        array("class"=>"", 
                                            "target"=>"frameDetail",
                                            "onclick"=>"$('#dialogDetail').dialog('open');",
                                            "rel"=>"tooltip",
                                            "title"=>"Detail sudah dilakukan",
                                    ));
                                }else{
                                    return CHtml::Link("<span style='font-size:17px'><i class='".MyIcon::getIcons('list2')."'></i></span>",$this->createUrl("PenerimaanDistribusiDarah/index",array("distribusidarah_id"=>$data->distribusidarah_id, "frame"=>1)),
                                        array("class"=>"", 
                                            //"target"=>"frameDetail",
                                            //"onclick"=>"$('#dialogDetail').dialog('open');",
                                            "rel"=>"tooltip",
                                            "title"=>"Transaksi Penerimaan Distribusi Darah",
                                    ));
                                }
                            },
                        ),
                        
                        array(
                            'header'=>'Batal Terima',
                            'type'=>'raw',
                            'htmlOptions'=>array('style'=>'text-align:center;'),
                            'value'=>function($data){
                                if($data->terimadistribusidarah_id){
                                    return CHtml::Link("<span style='font-size:17px;color:green'><i class='".MyIcon::getIcons('batal')."'></i></span>", "#",
                                        array("class"=>"", 
                                            "onclick"=>"myAlert('Batal tidak dapat dilakukan, Detail penerimaan distribusi darah sudah dilakukan');return false;",
                                            "rel"=>"tooltip",
                                            "title"=>"Sudah dilakukan detail",
                                    ));
                                }else{
                                    return CHtml::Link("<span style='font-size:17px;color:red'><i class='".MyIcon::getIcons('batal')."'></i></span>", "#",
                                        array("class"=>"", 
                                            "onclick"=>"batalPenerimaan(".$data->distribusidarah_id.");return false;",
                                            "rel"=>"tooltip",
                                            "title"=>"Batal penerimaan",
                                    ));
                                }
                            },
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_search',array(
                    'model'=>$model,
                )); ?>
            </div>
        </div>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogDetail',
    'options'=>array(
    'title'=>'Detail Penerimaan Darah ',
    'autoOpen'=>false,
    'width'=>1000,
    'height'=>650,
    'resizable'=>true,
    'scroll'=>false,
    'close'=>"js:function(){ $.fn.yiiGridView.update('penerimaandarah-r-grid', {
            data: $('#penerimaandarah-r-search').serialize()
    }); }",
    ),
));
?>
<iframe src="" name="frameDetail" style="width: 100%; height: 98%; border: none;"></iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<script>
    function batalPenerimaan(distribusidarah_id) {
        myConfirm('Anda yakin untuk membatalkan penerimaan ini?', 'Perhatian!', function(r) {
            if (r) {
                $("#tabel_informasi").addClass("animation-loading");
                $.ajax({
                    type:'POST',
                    url:'<?php echo $this->createUrl('BatalDistribusi'); ?>',
                    data: {distribusidarah_id:distribusidarah_id},
                    dataType: "json",
                    success:function(data){
                        $("#tabel_informasi").removeClass("animation-loading");
                        if (data.sukses==1) {
                            $.fn.yiiGridView.update('penerimaandarah-r-grid');
                        } else {
                            myAlert("Batal gagal dilakukan");
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) { 
                        myAlert("Batal gagal dilakukan");
                        $("#tabel_informasi").removeClass("animation-loading");
                    }
                });
            }
        });
    }
</script>