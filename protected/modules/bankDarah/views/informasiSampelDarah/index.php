<?php
/**
 * @author Aida Rahmawati <aidarahmawati@.com>
 */
Yii::app()->clientScript->registerScript('search', "
    $('#informasisampel-r-search').submit(function(){
        $.fn.yiiGridView.update('informasisampel-r-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");

$this->widget('bootstrap.widgets.BootAlert');
?>
<?php 
    $module  = $this->module->name; 
    $controller = $this->id;
    $format = new MyFormatter();
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Informasi <strong>Sampel Darah</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Sampel Darah</strong></div>
                    </div>
                    <div class="panel-body overflow-x" >                            
                        <?php
                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'informasisampel-r-grid',
                            'replaceUrl' => true,
                            'dataProvider' => $model->searchSampelDarah(),
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
                                    'header' => 'Tanggal Terima',
                                    'type' => 'raw',
                                    'value' => function($data){
                                        return MyFormatter::formatDateTimeForUser($data['tglterimakantong']);
                                    }
                                ),
                                array(
                                    'header'=>'No. Barcode Sampel Konfirmasi Gol. Darah',
                                    'value'=>function($data){
                                        echo $data['nomorbarcode_sample'];
                                    },
                                ), 
                                 array(
                                    'header'=>'No. Barcode Sampel Skrining IMLTD',
                                    'value'=>function($data){
                                        echo $data['nomorbarcode_imltd'];
                                    },
                                    'visible' => false
                                ), 
                                array (
                                    'header' => 'Golongan Darah',
                                    'value' => function($data){
                                        echo $data['gol_darah']; 
                                    }
                                ),
                                array(
                                    'header' => 'Rhesus',
                                    'value' => function ($data) {
                                        echo $data['rhesus']; 
                                    }
                                ),         
                                array(
                                    'header' => 'Jenis Kantong',
                                    'value' => '$data["nama_jenis"]',
                                ),                                
                                array(
                                    'header' => 'Skrining IMLTD',
                                   'htmlOptions'=>array('style'=>'text-align:center;'),
                                    'value' => function ($data){                         
                                        $cariDataSkriningREAKTIF = new CDbCriteria();
                                        $cariDataSkriningREAKTIF->compare('nomorbarcode_sample',$data['nomorbarcode_sample'], true);
                                        $cariDataSkriningREAKTIF->order='pengujian_ke desc';
                                        $cek = SkriningimltdT::model()->find($cariDataSkriningREAKTIF);
                                        ;
                                        if ($data['sampel_imltd'] == true){
                                            if(!empty($cek)) {                                                
                                                if($cek->pengujian_ke == 1) {
                                                    if ($cek->hasil_skrining=='REAKTIF' ){
                                                        echo CHtml::link("<i class='".MyIcon::getIcons('periksa')."'></i>",Yii::app()->createUrl('bankDarah/SkriningInfeksiDarah/index&nomorbarcode_sample='.$data['nomorbarcode_sample'].'&link=1'),array("rel"=>"tooltip","title"=>"Klik untuk Mengisi Skrining IMLTD",'style'=>'margin-top: 5px; width: 110px;'))."<br>";                                                        
                                                        echo CHtml::link("<i class='fa fa-times'></i> ".ucwords(strtolower($cek->hasil_skrining))."",Yii::app()->createUrl('bankDarah/SkriningInfeksiDarah/index&nomorbarcode_sample='.$data['nomorbarcode_sample'].'&skriningimltd_id='.$cek['skriningimltd_id'].'&pengujianke='.$cek->pengujian_ke.'&link=1'), array('style'=>'width: 110px;','class' => 'btn btn-sm btn-danger',"rel"=>"tooltip","title"=>"Klik untuk Mengisi Skrining IMLTD"))."<br>";
                                                    }else{
                                                        echo CHtml::link("<i class='fa fa-check'></i> ".ucwords(strtolower($cek->hasil_skrining))."",Yii::app()->createUrl('bankDarah/SkriningInfeksiDarah/index&nomorbarcode_sample='.$data['nomorbarcode_sample'].'&skriningimltd_id='.$cek['skriningimltd_id'].'&pengujianke='.$cek->pengujian_ke.'&link=1'), array('style'=>'width: 110px;','class' => 'btn btn-sm btn-success',"rel"=>"tooltip","title"=>"Klik untuk Mengisi Skrining IMLTD"))."<br>";
                                                    }
                                                } else if($cek->pengujian_ke == 2){
                                                    $cariDataSkriningREAKTIF2 = new CDbCriteria();
                                                    $cariDataSkriningREAKTIF2->select='nomorbarcode_sample, pengujian_ke, hasil_skrining';
                                                    $cariDataSkriningREAKTIF2->compare('nomorbarcode_sample',$data['nomorbarcode_sample'], true);                            
                                                    $cariDataSkriningREAKTIF2->group = $cariDataSkriningREAKTIF2->select;
                                                    $cariDataSkriningREAKTIF2->order = " pengujian_ke DESC ";
                                                    $cekDetail = SkriningimltdT::model()->findAll($cariDataSkriningREAKTIF2);
                                                    $ii = 1;
                                                    foreach($cekDetail as $value1) {
                                                        $skrining_id = SkriningimltdT::model()->findByAttributes(array('nomorbarcode_sample' => $value1->nomorbarcode_sample, 'pengujian_ke' => $value1->pengujian_ke));
                                                        if ($value1->hasil_skrining=='REAKTIF' ){
                                                            $btn = 'btn btn-sm btn-danger';
                                                            $icon = "<i class='fa fa-times'></i> ";
                                                        }else{
                                                            $btn = 'btn btn-sm btn-success';
                                                            $icon = "<i class='fa fa-check'></i> ";
                                                        }
                                                        echo CHtml::link($icon.ucwords(strtolower($value1->hasil_skrining)),Yii::app()->createUrl('bankDarah/SkriningInfeksiDarah/index&nomorbarcode_sample='.$data['nomorbarcode_sample'].'&skriningimltd_id='.$skrining_id->skriningimltd_id.'&pengujianke='.$value1->pengujian_ke.'&link=1'), array('class'=>$btn,"rel"=>"tooltip","title"=>"Klik untuk Mengisi Skrining IMLTD",'style'=>'margin-top: 5px; width: 110px;'))."<br>";
                                                        if ($value1->pengujian_ke == 1){                                                            
                                                        }
                                                        $ii++;
                                                    }
                                                }
                                            }else{
                                               echo CHtml::link("<i class='".MyIcon::getIcons('periksa')."'></i>",Yii::app()->createUrl('bankDarah/SkriningInfeksiDarah/index&nomorbarcode_sample='.$data['nomorbarcode_sample']),array("rel"=>"tooltip","title"=>"Klik untuk Mengisi Skrining IMLTD",'style'=>'margin-top: 5px; width: 110px;'));
                                            }
                                        }else{
                                            echo CHtml::link("<i class='".MyIcon::getIcons('periksa')."'></i>","javascript:;",array("rel"=>"tooltip","title"=>"Klik untuk Mengisi Skrining IMLTD", 'disabled'=>true, 'onclick'=>'toastr.error("Sampel skrining IMLTD belum diterima","Perhatian")','style'=>'margin-top: 5px; width: 110px;'));
                                        }
                                    }
                                ), 
                                array(
                                    'header' => 'Pengujian Konfirmasi Gol. Darah',
                                   'htmlOptions'=>array('style'=>'text-align:center;'),
                                    'value' => function ($data){
                                        $onclick = "callDialogDetail(this,'".$data['nomorbarcode_sample']."')";
                                        
                                        $hasil = PengujiandarahT::model()->find(" nomorbarcode_sample = '".$data['nomorbarcode_sample']."' ORDER BY pengujian_ke ASC ");
                                        
                                        $hasil = PengujiandarahT::model()->findAll(" nomorbarcode_sample = '".$data['nomorbarcode_sample']."' ORDER BY pengujian_ke DESC ");
                                        $link = CHtml::link("<span style='font-size:25px;color:red;'><i class='".MyIcon::getIcons('konfujidarah')."'></i></span>",Yii::app()->createUrl('bankDarah/PengujianDarah/index&nomorbarcode_sample='.$data['nomorbarcode_sample'].'&link=informasi'),array("rel"=>"tooltip","title"=>"Klik untuk Mengisi Pengujian Golongan Darah"));
                                        
                                        if ($data['sampel_konfirmasi']){
                                        
                                            if (!empty($hasil)) {
                                               if(count($hasil)<2){
                                                   foreach($hasil as $h){
                                                       if($h->hasil_uji == Params::HASIL_GOLDARAH_COCOK){
                                                           echo CHtml::link("<i class='fa fa-check'></i> COCOK" ,Yii::app()->createUrl('bankDarah/PengujianDarah/index&nomorbarcode_sample='.$data['nomorbarcode_sample'].'&pengujiandarah_id='.$h['pengujiandarah_id'].'&link=1'),array('style' => 'margin-top: 5px; width: 110px;', 'class' => "btn  btn-sm btn-success", "rel"=>"tooltip","title"=>"Klik untuk Mengisi Pengujian Golongan Darah"))."<br>";
                                                       }else{
                                                           echo CHtml::link("<span style='font-size:25px;color:red;'><i class='".MyIcon::getIcons('konfujidarah')."'></i></span>",Yii::app()->createUrl('bankDarah/PengujianDarah/index&nomorbarcode_sample='.$data['nomorbarcode_sample']),array("rel"=>"tooltip","title"=>"Klik untuk Mengisi Pengujian Golongan Darah")).'<br>';
                                                           echo CHtml::link("<i class='fa fa-times'></i> TIDAK COCOK" ,Yii::app()->createUrl('bankDarah/PengujianDarah/index&nomorbarcode_sample='.$data['nomorbarcode_sample'].'&pengujiandarah_id='.$h['pengujiandarah_id'].'&link=1'), array('style' => 'margin-top: 5px; width: 110px;', 'class' => "btn btn-sm btn-danger", "rel"=>"tooltip","title"=>"Klik untuk Mengisi Pengujian Golongan Darah"))."<br>";
                                                       }
                                                   }
                                               }else{
                                                   foreach($hasil as $h){
                                                       if($h->hasil_uji == Params::HASIL_GOLDARAH_COCOK){
                                                           echo CHtml::link("<i class='fa fa-check'></i> COCOK" ,Yii::app()->createUrl('bankDarah/PengujianDarah/index&nomorbarcode_sample='.$data['nomorbarcode_sample'].'&pengujiandarah_id='.$h['pengujiandarah_id'].'&link=1'),array('style' => 'margin-top: 5px; width: 110px;', 'class' => "btn  btn-sm btn-success", "rel"=>"tooltip","title"=>"Klik untuk Mengisi Pengujian Golongan Darah"))."<br>";
                                                       }else{
                                                           echo CHtml::link("<i class='fa fa-times'></i> TIDAK COCOK" ,Yii::app()->createUrl('bankDarah/PengujianDarah/index&nomorbarcode_sample='.$data['nomorbarcode_sample'].'&pengujiandarah_id='.$h['pengujiandarah_id'].'&link=1'), array('style' => 'margin-top: 5px; width: 110px;', 'class' => "btn btn-sm btn-danger", "rel"=>"tooltip","title"=>"Klik untuk Mengisi Pengujian Golongan Darah"))."<br>";
                                                       }
                                                   }
                                               }
                                           } else {
                                               echo CHtml::link("<span style='font-size:25px;color:red;'><i class='".MyIcon::getIcons('konfujidarah')."'></i></span>",Yii::app()->createUrl('bankDarah/PengujianDarah/index&nomorbarcode_sample='.$data['nomorbarcode_sample']),array("rel"=>"tooltip","title"=>"Klik untuk Mengisi Pengujian Golongan Darah"));
                                           }
                                        }else{
                                            echo CHtml::link("<span style='font-size:25px;color:red;'><i class='".MyIcon::getIcons('konfujidarah')."'></i></span>",'javascript:;',array("rel"=>"tooltip","title"=>"Klik untuk Mengisi Pengujian Golongan Darah", 'class' => 'disabled', 'onclick'=>'toastr.error("Sampel konfirmasi golongan darah belum diterima","Perhatian")'));
                                        }
                                    }
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
                            <?php $this->renderPartial($this->path_view.'/_search',array(
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
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'dialogDetail',
		// additional javascript options for the dialog plugin
		'options'=>array(
		'title'=>'Detail Pengujian Konfirmasi Golongan Darah',
		'autoOpen'=>false,
		'minWidth'=>1000,
		'minHeight'=>100,
		'resizable'=>false,
		 ),
	));
?>
<iframe src="" id="frameDetail" width="100%" height="400" style="border: none;">
    
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');

?>
<?php
// ===========================Dialog Details Skrining=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogDetailSkrining',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Detail Skrining',
    'autoOpen'=>false,
    'width'=>1000,
    'height'=>650,
    'resizable'=>true,
    'scroll'=>false,
    ),
));
?>
<iframe src="" name="iframe1" width="100%" height="100%">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
?>
<script>
    function callDialogDetail(obj,id){                
        $("#dialogDetail").dialog('open');        
        //$("#frameDetail").attr('src','<?php echo Yii::app()->createUrl('/bankDarah/pengujianDarah/lihatDetail') ?>&nomorbarcode_sample='+nomorbarcode_sample);
        $("#frameDetail").attr('src','<?php echo Yii::app()->createUrl('/bankDarah/InformasiSampelDarah/detailPengujian') ?>&id='+id);
    }
</script>
