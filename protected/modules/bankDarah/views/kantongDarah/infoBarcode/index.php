<?php
/**
 * Halaman ini digunakan untuk menampilkan informasi stok kantong darah
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Elham Budianto <elhambudianto@.com>
 */
Yii::app()->clientScript->registerScript('search', "
    $('#stokkantongdarah-r-search').submit(function(){
        $.fn.yiiGridView.update('stokkantongdarah-r-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");

$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Informasi <strong>Barcode Kantong Darah</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Barcode Kantong Darah</strong></div>
                    </div>
                    <div class="panel-body overflow-x" >                            
                        <?php
                        $this->widget('ext.bootstrap.widgets.BootGroupGridView', array(
                            'id' => 'stokkantongdarah-r-grid',
                            'dataProvider' => $model->searchInformasiBarcode(),
                            'replaceUrl'=>true,
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                            'mergeColumns'=>array('no','tglcetak','jeniskantongdarah_nama','nomorbarcode_utama','bulan'),
                            'mergeCellCss'=>'',
                            'columns' => array(
                                array(
                                    'header'=>'No.',
                                    'name'=>'no',
                                    'value' => '$data["no"]',                                    
                                    'htmlOptions'=>array('style'=>'text-align:left;'),
                                ),
                                array(
                                    'header'=>'Tanggal Cetak',
                                    'name'=>'tglcetak',
                                    'value'=> '$data["tglcetak"]'
                                ),
                                array(
                                    'header' => 'Bulan',
                                    'type'=> 'raw',
                                    'name'=>'bulan',
                                    'value' => function($data){
                                        return $data["bulan"]." ".$data['tahun']."<span class='hide'>".$data["tglcetak"]."</span>";
                                    }
                                ),
                                array(
                                    'header'=>'Jenis Kantong Darah',
                                    'name'=>'jeniskantongdarah_nama',
                                    'type'=>'raw',
                                    'value'=>function($data){
                                        //    return $data["jeniskantongdarah_nama"].'<span class="hide">'.$data["tglcetak"].'</span>';
                                        return CHtml::Link($data["jeniskantongdarah_nama"].'<span class="hide">'.$data["tglcetak"].'</span>'.'&nbsp;<i class="'.MyIcon::getIcons('cetak').'"></i>',
                                                $this->createUrl('listBarcodeByTanggal',array('bulan'=>$data["bulan"]." ".$data['tahun'],'waktu'=>$data["tglcetak"],'jeniskantong'=>$data["jeniskantongdarah_id"])),
                                            array(                                            
                                               "target"=>"frameList",
                                                "onclick"=>"$('#dialogListPrint').dialog('open');",
//                                                "bulan"=> $data["bulan"]." ".$data['tahun'],
//                                                "waktu"=> $data["tglcetak"],
//                                                "jeniskantong"=>$data["jeniskantongdarah_id"],
                                                "rel"=>"tooltip",
                                                "title"=>"Klik untuk menampilkan list nomor barcode yang akan prinout",
                                        ));
                                    },                                 
                                ),
                                 array(
                                    'header'=>'No. Barcode Utama',
                                    'type' => 'raw',
                                    'name'=>'nomorbarcode_utama',
                                    'value'=>function($data){
                                        return $data['nomorbarcode_utama'];
//                                        return CHtml::Link($data["nomorbarcode_utama"].'&nbsp;<i class="'.MyIcon::getIcons('cetak').'"></i>',
//                                                'javascript:;',
//                                            array(                                            
//                                                "onclick"=>"cetakKantongUtama('nomor_barcode_utama','".$data["nomorbarcode_utama"]."');",
//                                                "rel"=>"tooltip",
//                                                "title"=>"Klik untuk mencetak no barcode utama",
//                                            ));                                            
                                    },                                    
                                ),
                                 array(
                                    'header'=>'No. Komponen Darah',      
                                    'type' => 'raw',
                                    'value'=>function($data){
                                            return CHtml::Link($data["no_kantongdarah"].'&nbsp;<i class="'.MyIcon::getIcons('cetak').'"></i>',
                                                'javascript:;',
                                            array(                                            
                                                "onclick"=>"cetakKomponen('no_komponen_darah','".$data["no_kantongdarah"]."');",
                                                "rel"=>"tooltip",
                                                "title"=>"Klik untuk mencetak no komponen darah",
                                            ));
                                    },                                    
                                ),
                                array(
                                    'header'=>'Petugas Cetak',
                                    'value'=>function($data){
                                            echo $data["petugas_cetak"];
                                    },
                                ),                                                                                    
                            ),
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                        ));
                        ?>                            
                    </div>
                </div>								
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="">
                            <?php $this->renderPartial('infoBarcode/_search',array(
                                    'model'=>$model,
                            )); ?>
                        </fieldset>
                    </div>
                </div>								
            </div>
        </div>
    </div>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'dialogListPrint',                        
                        'options'=>array(
                        'title'=>'Barcode Kantong Darah',
                        'autoOpen'=>false,
                        'width'=>500,
                        'height'=>300,
                        'resizable'=>true,
                        'scroll'=>false    
                         ),
                    ));
?>
<iframe src="" name="frameList" width="100%" height="100%">
</iframe>';

<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<script>
    function cetakKantongUtama(jenis, nomorbarcode_utama)
    {
        window.open('<?php echo $this->createUrl('PrintBarcode'); ?>&jenis='+jenis+'&nomorbarcode_utama='+nomorbarcode_utama, 'printwin', 'left=100,top=100,width=480,height=640');
    }
    
    function cetakKomponen(jenis, no_kantongdarah)
    {
        window.open('<?php echo $this->createUrl('PrintBarcodeKomponen'); ?>&jenis='+jenis+'&no_kantongdarah='+no_kantongdarah, 'printwin', 'left=100,top=100,width=480,height=640');
    }
    
    function cetakBarcodeByTanggal(obj){
        var jeniskantongdarah_id = $(obj).attr('jeniskantongdarah');
        var tgl_cetak = $(obj).attr('waktu');
        var bulan = $(obj).attr('bulan');
        
        window.open('<?php echo $this->createUrl('PrintBarcode'); ?>&jenis=tanggalcetak&jeniskantongdarah_id='+jeniskantongdarah_id+'&tgl_cetak='+tgl_cetak+'&bulan='+bulan, 'printwin', 'left=100,top=100,width=480,height=640');
    }      
</script>
