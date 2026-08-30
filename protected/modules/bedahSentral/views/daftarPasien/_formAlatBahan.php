<?php
$instalasi = InstalasiM::model()->findByPk(Yii::app()->user->getState('instalasi_id'));
?>

<!-- <div class="panel panel-success panel-shadow">
    <div class="panel-heading">
        <div class="panel-title">Pemakaian Bahan Pasien</div>
    </div> -->
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="control-group ">
                    <div class="controls">
                        <?php echo CHtml::checkBox('isbukanbebanpasien',$instalasi->isbhpbukanbebanpasien); ?> <label>Pilih Jika Pemakaian Bahan Tidak Dibebankan Kepada Pasien</label>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Tipe Paket','',array('class'=>'control-label hide')) ?>
                    <div class="controls">
                        <?php            
                        // $list_tipepaket = TipepaketM::model()->findAllByAttributes(array('ruangan_id' => Yii::app()->user->getState('ruangan_id')));             
                        // $list_tipepaket = TipepaketM::model()->findAllByAttributes(array('isbmhp' => false));             
                        //     echo CHtml::dropDownList('tipepaket_id','',$list_tipepaket ,array('class'=>'span3','empty'=>'Pilih','options'=>$option_tipepaket)); //'onchange'=>'changeTipePaketBahanMedis()' 
                            echo CHtml::hiddenField('tipepaket_id','',array('class'=>'span3')); //'onchange'=>'changeTipePaketBahanMedis()' 
                        ?>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="col-sm-6">
                <div class="control-group ">
                    <?php echo CHtml::label('Nama Bahan Medis', '', array('class'=>'control-label')); ?>
                    <div class="controls clsnonpaket">
                        <?php echo CHtml::hiddenField('obatalkes_id'); ?>
                        <?php 
                            $this->widget('MyJuiAutoComplete', array(
                                'name'=>'obatalkes_nama',
                                'source'=>'js: function(request, response) {
                                            $.ajax({
                                                url: "'.$this->createUrl('PemakaianBmhp/AutocompleteObatAlkes').'",
                                                dataType: "json",
                                                data: {
                                                    term: request.term,
                                                },
                                                success: function (data) {
                                                        response(data);
                                                }
                                            })
                                            }',
                                'options'=>array(
                                    'showAnim'=>'fold',
                                    'minLength' => 2,
                                    'focus'=> 'js:function( event, ui ) {
                                            $(this).val("");
                                            return false;
                                        }',
                                    'select'=>'js:function( event, ui ) {
                                            $(this).val(ui.item.value);
                                            $("#obatalkes_id").val(ui.item.obatalkes_id);
                                            tambahPemakaianBahan();
                                            return false;
                                        }',
                                ),
                                'htmlOptions'=>array(
                                        'onkeyup'=>"return $(this).focusNextInputField(event)",
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogPemakaianBahan'),
                            )); 
                         ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group ">
                    <?php echo CHtml::label('jumlah', '', array('class'=>'control-label')); ?>
                    <div class="controls clsnonpaket">
                        <?php echo CHtml::textField('qtypakaibahan', '1', array('class'=>'span1 integer')) ?>
                        <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
                                array('onclick'=>'tambahPemakaianBahan();return false;',
                                    'class'=>'btn btn-primary',
                                    'onkeyup'=>"tambahPemakaianBahan();",
                                    'rel'=>"tooltip",
                                    'id'=>'btntmbbahanmedis',
                                    'title'=>"Klik untuk menambahkan Pemakaian Bahan Pasien")); ?>
                    </div>
                </div>
            </div>
        </div>
        <div style="overflow: auto;">
            <table class="table table-condensed table-bordered" style="width: 1170px !important; max-width: 1200px !important;">
                <thead>
                    <th width="50px">No.</th>
                    <th width="150px">Tgl. Pemakaian</th>
                    <!-- <th width="150px" class="hide">Tipe Paket</th> -->
                    <th width="150px">Tipe Paket</th>
                    <th width="100px">Jenis Bahan</th>
                    <th width="200px">Nama Bahan Medis</th>
                    <th width="120px" class="hide">Tgl. Kedaluwarsa</th>
                    <th width="100px">Harga</th>
                    <th style="width: 120px !important;">Jumlah</th>
                    <th width="100px">Subtotal</th>
                    <th width="80px">Batal</th>
                </thead>
                <tbody id="tblpemakaianbahan">
                    
                </tbody>
                <tfoot>
                    <tr>
                        <td style="font-weight: bold; text-align: right;" colspan="7">Total Harga</td>
                        <td>
                            <?php echo CHtml::textField('totalbahanmedis',0,array('class'=>'span2 integer-decimal-global','readonly'=>true)); ?>
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>        
        </div>
    </div>
<!-- </div> -->

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPemakaianBahan',
    'options'=>array(
        'title'=>'Daftar Bahan Medis '.Yii::app()->user->getState('ruangan_nama'),
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>600,
        'resizable'=>false,
    ),
));
$modBhp= new BSObatalkesM('searchDialogBHP');
$modBhp->unsetAttributes();
if(isset($_GET['BSObatalkesM'])){
    $modBhp->attributes = $_GET['BSObatalkesM'];
}
$modBhp->jenisobatalkes_id = Params::JENISOBATALKES_ID_BHP;

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'obatalkes-m-grid',
	'dataProvider'=>$modBhp->searchDialogBHP(),
	'filter'=>$modBhp,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0)",array("class"=>"btn-small", 
                            "id" => "selectObat",
                            "onClick" => "
                                $(\'#obatalkes_id\').val($data->obatalkes_id);
                                $(\'#obatalkes_nama\').val(\'$data->obatalkes_nama\');
                                tambahPemakaianBahan(true);
                               
                                return false;"
                                ))',
        ),
        array(
            'name'=>'jenisobatalkes_id',
            'type'=>'raw',
            'value'=>'(!empty($data->jenisobatalkes_id) ? $data->jenisobatalkes->jenisobatalkes_nama : "")',
            'filter'=> false,
        ),
        'obatalkes_nama',
        array(
            'header'=>'Jumlah Stok',
            'type'=>'raw',
            'value'=>'StokobatalkesT::getJumlahStok($data->obatalkes_id, Yii::app()->user->getState("ruangan_id"))',
        ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>
