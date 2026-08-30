<?php

Yii::app()->clientScript->registerScript('search', "
    $('#kantongdarah-r-search').submit(function(){
        $.fn.yiiGridView.update('kantongdarah-r-grid', {
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
                <div class="panel-title">Informasi <strong>Kantong Darah</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Kantong Darah</strong></div>
                    </div>
                    <div class="panel-body overflow-x" >                            
                        <?php
                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'kantongdarah-r-grid',
                            'replaceUrl'=>true,
                            'dataProvider' => $model->searchInformasiKantongDarah(),
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
                                    'header'=>'Nomor Kantong Darah',
                                    'value'=>function($data){
                                        echo $data->no_kantongdarah;
                                    },
                                ),
                                array(
                                    'header'=>'Golongan Darah',
                                    'value'=>function($data){
                                        echo $data->gol_darah;
                                    },
                                ),
                                array(
                                    'header'=>'Rhesus',
                                    'value'=>function($data){
                                        echo $data->rhesus;
                                    },
                                ),
                                array(
                                    'header'=>'Jenis Kantong',
                                    'value'=>function($data){
                                        echo $data->nama_jenis;
                                    },
                                ),                                           
                                array(
                                    'header'=>'Pembuatan Komponen Darah',
                                    'htmlOptions'=>array('style'=>'text-align:center;'),
                                    'value'=>function($data){
                                        $cekKomponendarah = PeriksakomponendarahT::model()->findByAttributes(array('kantongdarah_id'=>$data->kantongdarah_id));
                                        if (!empty($cekKomponendarah->periksakomponendarah_id)) {
                                            $st = '';
                                            if ($cekKomponendarah->komponen_wb != "NONE") {
                                                $st = $cekKomponendarah->komponen_wb; 
                                            } else if ($cekKomponendarah->komponen_prc != "NONE") {
                                                $st = $cekKomponendarah->komponen_prc;
                                            } else if ($cekKomponendarah->komponen_tc != "NONE") {
                                                $st = $cekKomponendarah->komponen_tc;
                                            } else if ($cekKomponendarah->komponen_pcr != "NONE") {
                                                $st = $cekKomponendarah->komponen_pcr;                                                
                                            } else if ($cekKomponendarah->komponen_cry != "NONE") {
                                                $st = $cekKomponendarah->komponen_cry;                                                
                                            }else if (!empty($cekKomponendarah->komponen_ffp != "NONE")) {
                                                $st = $cekKomponendarah->komponen_ffp;   
                                            }
                                            
                                            echo CHtml::link("<span style='font-size:15px;'><i class='fa fa-medkit' style='color:".(($st == 'BERHASIL')?'green':'#cc2424')."'></i></span>",Yii::app()->createUrl('bankDarah/PembuatanKomponenDarahT/index', array('id'=>$data->no_kantongdarah, 'periksakomponendarah_id' => $data->periksakomponendarah_id ,'frame'=>1)),array("rel"=>"tooltip","title"=>"Klik untuk Melihat Mengubah Pembuatan Komponen Darah", "class"=>'btn btn-success'));
                                            echo "<br><b>".$st.'</b>';
                                        } else {
                                            echo CHtml::link("<span style='font-size:15px;'><i class='fa fa-medkit'></i></span>",Yii::app()->createUrl('bankDarah/PembuatanKomponenDarahT/index', array('id'=>$data->no_kantongdarah, 'frame'=>1)),array("rel"=>"tooltip","title"=>"Klik untuk Input Pembuatan Komponen Darah","class"=>"btn btn-success"));
                                        }
                                    },
                                ),     
                                array(
                                    'header'=>'Pelulusan Komponen Darah',
                                    'type' => 'raw',
                                    'htmlOptions'=>array('style'=>'text-align:center;'),
                                    'value'=>function($data){
                                        $cekKomponendarah = PeriksakomponendarahT::model()->findByAttributes(array('kantongdarah_id'=>$data->kantongdarah_id));
                                        if (!empty($cekKomponendarah->periksakomponendarah_id)) {
                                            $cekLulusKomponen = LuluskomponendarahT::model()->findByAttributes(array('kantongdarah_id'=>$cekKomponendarah->kantongdarah_id));
                                            if (!empty($cekLulusKomponen->luluskomponendarah_id)) {
                                                 if ($cekLulusKomponen->statuspelulusan == "TIDAK LULUS") {
                                                    echo CHtml::link("<span style='font-size:15px;'><i class='fa fa-check' style='color: #cc2424'></i></span>",Yii::app()->createUrl('bankDarah/LuluskomponendarahT/create&nomorbarcode='.$data->no_kantongdarah.'&luluskomponendarah_id='.$data->luluskomponendarah_id.'&frame=1'),array("rel"=>"tooltip","title"=>"Klik untuk Edit Pelulusan Komponen Darah", "class"=>"btn btn-success"));
                                                    echo "<br><b>".$cekLulusKomponen->statuspelulusan.'</b>';
                                                } else {
                                                    echo CHtml::link("<span style='font-size:15px;'><i class='fa fa-check' style='color: green'></i></span>",Yii::app()->createUrl('bankDarah/LuluskomponendarahT/create&nomorbarcode='.$data->no_kantongdarah.'&luluskomponendarah_id='.$data->luluskomponendarah_id.'&frame=1'),array("rel"=>"tooltip","title"=>"Klik untuk Edit Pelulusan Komponen Darah", "class"=>"btn btn-success"));
                                                    echo "<br><b>".$cekLulusKomponen->statuspelulusan.'</b>';
                                                }
                                            }else{
                                                echo CHtml::link("<span style='font-size:15px;'><i class='fa fa-check'></i></span>",Yii::app()->createUrl('bankDarah/LuluskomponendarahT/create&nomorbarcode='.$data->no_kantongdarah.'&frame=1'),array("rel"=>"tooltip","title"=>"Klik untuk Melakukan Transaksi Pelulusan Komponen Darah", "class"=>"btn btn-success"));                                            
                                            }
                                        } else {
                                            echo "<span style='font-size:15px;'><i class='fa fa-check'></i></span>";
                                        }
                                    },
                                ),
                                array(
                                    'header' => 'Buang',
                                    'type' => 'raw',
                                    'value' => function($data){
                                        $cekKomponendarah = PeriksakomponendarahT::model()->findByAttributes(array('kantongdarah_id'=>$data->kantongdarah_id));
                                        if (!empty($cekKomponendarah->periksakomponendarah_id)) {
                                            $cekLulusKomponen = LuluskomponendarahT::model()->findByAttributes(array('kantongdarah_id'=>$cekKomponendarah->kantongdarah_id));
                                            if (!empty($cekLulusKomponen->luluskomponendarah_id)) {
                                                 if ($cekLulusKomponen->statuspelulusan == "TIDAK LULUS") {
                                                    echo CHtml::link("<span style='font-size:15px;'><i class='glyphicon glyphicon-trash' style='color: blue'></i> </span>",'javascript:;',array('data-url'=>Yii::app()->createUrl('bankDarah/informasiKantongDarah/buang&id='.$data->kantongdarah_id),"rel"=>"tooltip","title"=>"Klik untuk Membatalkan Permintaan Darah", "onclick"=>"cekBuangKantong(this);", "class"=>"btn btn-danger"));   
                                                } else {
                                                    echo "<span style='font-size:15px;'><i class='glyphicon glyphicon-trash'></i></span>";
                                                }
                                            }else{
                                                echo "<span style='font-size:15px;'><i class='glyphicon glyphicon-trash'></i></span>";
                                            }
                                        } else {
                                            echo "<span style='font-size:15px;'><i class='glyphicon glyphicon-trash'></i></span>";
                                        }
                                    },
                                    'htmlOptions'=>array('style'=>'text-align:center;'),
                                )
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
                            <?php $this->renderPartial('_search',array(
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
// ===========================Dialog =========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogPembuatan',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Pembuatan Komponen Darah',
    'autoOpen'=>false,
    'width'=>1000,
    'height'=>500,
    'resizable'=>true,
    'scroll'=>false,
    'close'=>"js:function(){ $.fn.yiiGridView.update('kantongdarah-r-grid', {
            data: $('#kantongdarah-r-search').serialize()
    }); }",
     ),
));
?>
<iframe src="" name="framePembuatan" width="100%" height="100%">
</iframe>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php
// ===========================Dialog =========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogBuang',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Buang Kantong Darah',
    'autoOpen'=>false,
    'width'=>500,
    'height'=>300,
    'resizable'=>true,
    'scroll'=>false,
    'close'=>"js:function(){ $.fn.yiiGridView.update('kantongdarah-r-grid', {
            data: $('#kantongdarah-r-search').serialize()
    }); }",
     ),
));
?>
<iframe id="frameBuang" src="" name="frameBuang" width="100%" height="100%">
</iframe>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php
// ===========================Dialog Detail =========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogPembuatanDetail',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Pembuatan Komponen Darah',
    'autoOpen'=>false,
    'width'=>1000,
    'height'=>650,
    'resizable'=>true,
    'scroll'=>false,
    'close'=>"js:function(){ $.fn.yiiGridView.update('kantongdarah-r-grid', {
            data: $('#kantongdarah-r-search').serialize()
    }); }",
     ),
));
?>
<iframe src="" name="framePembuatanDetail" width="100%" height="100%">
</iframe>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>


<?php
// ===========================Dialog Skrining IMLTD=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogPengujian',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Pengujian Konfirmasi Golongan Darah',
    'autoOpen'=>false,
    'width'=>1000,
    'height'=>500,
    'resizable'=>true,
    'scroll'=>false    
     ),
));
?>
<iframe src="" name="framePengujian" width="100%" height="100%">
</iframe>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php
// ===========================Dialog Skrining IMLTD=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogSkrining',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Skrining IMLTD',
    'autoOpen'=>false,
    'width'=>1000,
    'height'=>500,
    'resizable'=>true,
    'scroll'=>false    
     ),
));
?>
<iframe src="" name="frameSkrining" width="100%" height="100%">
</iframe>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php
// ===========================Dialog Detail Kantong Darah =========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogKantongDarah',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Pelulusan Komponen Darah',
    'autoOpen'=>false,
    'width'=>1000,
    'height'=>500,
    'resizable'=>true,
    'scroll'=>false    
     ),
));
?>
<iframe src="" name="frameDetail" width="100%" height="100%">
</iframe>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php
// ===========================Dialog Details Perizinan=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogDetailsPerizinan',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Rincian Perizinan Sponsorship',
    'autoOpen'=>false,
    'width'=>1000,
    'height'=>500,
    'resizable'=>true,
    'scroll'=>false    
     ),
));
?>
<iframe src="" name="iframe" width="100%" height="100%">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details Perizinan================================
?>
<?php
// ===========================Dialog Details Perizinan=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogVerifikasiKabag',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Verifikasi Ka.Bid / Ka.Bag',
    'autoOpen'=>false,
    'width'=>1000,
    'height'=>500,
    'resizable'=>true,
    'scroll'=>false,
    'close'=>"js:function(){ $.fn.yiiGridView.update('kantongdarah-r-grid', {
            data: $('#kantongdarah-r-search').serialize()
    }); }",
    ),
));
?>
<iframe src="" name="iframe1" width="100%" height="100%">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details Perizinan================================
?>
<?php
// ===========================Dialog Details Perizinan=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogVerifikasiPeg',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Verifikasi Kepegawaian',
    'autoOpen'=>false,
    'width'=>1000,
    'height'=>500,
    'resizable'=>true,
    'scroll'=>false,
    'close'=>"js:function(){ $.fn.yiiGridView.update('kantongdarah-r-grid', {
            data: $('#kantongdarah-r-search').serialize()
    }); }",
    ),
));
?>
<iframe src="" name="iframe2" width="100%" height="100%">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details Perizinan================================
?>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url=Yii::app()->createAbsoluteUrl($module.'/'.$controller);
    $urlPrint1=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/Informasiprint',array('permohonankantongdarahluar_id'=>''));
    $urlPrint2=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/Informasiprintluar',array('permohonankantongdarahluar_id'=>''));
    // $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/Printinformasi');

?>
<script type="text/javascript">
function cekBuangKantong(obj){
    
    myConfirm("Apakah anda yakin akan membuang data kantong darah ini ?","Perhatian!", function(r){
        if (r){
           window.parent.$('#dialogBuang').dialog('open');                
           $('#frameBuang').attr('src', $(obj).attr('data-url'));	
        }
    });        
    
}
function print1(permohonankantongdarahluar_id){
        window.open('<?php echo $urlPrint1?>'+permohonankantongdarahluar_id,'printwin','left=400,top=400,width=800,height=600');
    }
function print2(permohonankantongdarahluar_id){
    window.open('<?php echo $urlPrint2?>'+permohonankantongdarahluar_id,'printwin','left=400,top=400,width=800,height=600');
}
function batalIzin(id) {
    myConfirm('Anda yakin untuk membatalkan perizinan ini ?', 'Perhatian!', function(r) {
        if (r) {
            $.post('<?php echo $this->createUrl('BatalIzin'); ?>', {id: id}, function(data) {
                if (data.sukses==1) {
                    myAlert(data.pesan);
                    $.fn.yiiGridView.update('kantongdarah-r-grid');
                } else {
                    myAlert(data.pesan);
                }
            }, 'json');
        }
    });
}
function deleteRecord(id){
        var id = id;
        var url = '<?php echo $url."/delete"; ?>';
        myConfirm('Yakin Akan Menghapus Data ini ?','Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('kantongdarah-r-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
           }
        });
    }
    
    function reloadTabel(){
        myAlert('Pembuangan kantong darah berhasil dilakukan');
        $.fn.yiiGridView.update('permintaandarah-r-grid');
    }
</script>