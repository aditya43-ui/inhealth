<?php
/**
 * @author Aida Rahmawati <aidarahmawati@.com>
 */
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#penerimaanspesimen-r-search').submit(function(){
            $.fn.yiiGridView.update('penerimaanspesimen-r-grid', {
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
                <div class="panel-title">Informasi <strong> Penerimaan Spesimen </strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong> Penerimaan Spesimen </strong></div>
                    </div>
                    <div class="panel-body overflow-x" >
                        <?php
                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'penerimaanspesimen-r-grid',
                            'dataProvider' => $model->searchInformasi(),
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
                                    'header' => 'Tanggal Penerimaan',
                                    'value' => function($data){
                                        echo MyFormatter::formatDateTimeForUser($data->tglterimaspesimen);
                                    }
                                ),
                                array(
                                    'header' => 'No. Penerimaan',
                                    'value' => function($data){
                                        echo $data->no_terimaspesimen; 
                                    }
                                ),
                                array(
                                    'header' => 'Ruangan Penerimaan',
                                    'value' => '$data->ruangan_nama',
                                ),
                                array(
                                    'header' => 'Petugas Penerima',
                                    'value' => '$data->nama_pegawai',
                                ),
                                array(
                                    'header' => 'Detail Penerimaan Spesimen',
                                    'htmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'value' => function ($data){
                                        echo "<div align=center>".CHtml::link("<i class ='glyphicon glyphicon-list' style='font-size:17px;'> </i>",Yii::app()->createUrl('mikrobiologiKlinik/informasiPenerimaanSpesimen/detail&id='.$data->penerimaanspesimen_id),
                                            array("rel"=>"tooltip","title"=>"Klik untuk Melihat Detail Penerimaan Spesimen", "target"=>"frame1", "onclick"=>"window.parent.$(\"#dialog1\").dialog(\"open\");"))."</div>";
                                    }
                                ), 
                                array(
                                    'header'=>'Batal Penerimaan',
                                    'type'=>'raw',
                                    'value'=>function($data) {   
                                        return CHtml::link('<i style="font-size:17px; color: #CA3433" class="glyphicon glyphicon-remove"></i>', '#', array(
                                            'font-size'=>'17px',
                                            'rel'=>'tooltip',
                                            'data-placement'=>'left',
                                            'title'=>'Klik untuk membatalkan penerimaan',
                                            'onclick'=>'batalTerima(this, '.$data->penerimaanspesimen_id.'); return false;'
                                        ));
                                    },
                                    'htmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                ),
                            ),
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                        ));
                        
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $js = <<< JSCRIPT
                                function cekForm(obj){
                                        $("#informasiae-r-search :input[name='"+ obj.name +"']").val(obj.value);
                                }
                                function print(caraPrint){
                                        window.open("${urlPrint}/"+$('#informasiae-r-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
                                }
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
                    </div>
                </div>
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="">
                            <?php $this->renderPartial('search',array(
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
// ===========================Dialog Penelitian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialog1',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Detail Penerimaan Spesimen',
    'autoOpen'=>false,
    'width'=>1100,
    'height'=>600,
    'resizable'=>true,
    'scroll'=>false,
    ),
));
?>
<iframe src="" name="frame1" width="100%" height="100%">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
?>

<script>
    function batalTerima(obj, id) {
        myConfirm('Apakah anda yakin untuk membatalkan penerimaan spesimen ini?', 'Perhatian!', function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('batalTerima'); ?>', {id: id}, function(data) {
                    if (data.ok == 1) {
                        myAlert(data.msg);
                        $.fn.yiiGridView.update('penerimaanspesimen-r-grid');
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }
</script>