<style type="text/css">
     .td_date input {
        float: left !important;
    }
     .trcoltd {
         background-color: #ebebeb !important;
     }  
     
     .trcoltdwhite {
         background-color: #fdfeff !important;
     }  

     .integer-decimal{
         text-align: right;
     }

     .tdcolorwhite {
         background-color: #fdfeff !important;
     } 
     
     .redError{
        background-color: red !important;
        color: #ebebeb !important;
     }
</style>
<?php
$this->breadcrumbs = array(
    'Pembayaran Umum',
); ?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pelayananpasienluarrs-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'),
)); 
echo CHtml::hiddenField("no_row",'');
echo CHtml::hiddenField("kelompoktindakan_id",'');

?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-user"></i> Transaksi <b>Pembayaran Umum</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial($this->path_view . '_formInfoKunjungan', array('form' => $form, 'modPasien' => $modPasien, 'modKunjungan'=>$modKunjungan)); ?>
        <br>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-users"></i> Data Tindakan Pasien
                </div>
            </div>
            <div class="panel-body table-responsive">
                <table class="items table table-bordered table-striped table-condensed">
                    <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>Tanggal Tindakan</th>
                            <th>Uraian Tindakan</th>
                            <th>Komponen Tarif</th>
                            <th>Tarif Komponen</th>
                            <th>Jumlah</th>
                            <th>Keringanan</th>
                            <th>Total Tarif Komponen</th>
                        </tr>
                    </thead>
                    <tbody id="tbl_tindakan" class="form-utama">
                       
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7" style="font-weight: bold; text-align: right">
                               Total Keseluruhan Tindakan     
                            </td>
                            <td>
                                <?php echo CHtml::textField('totaltarifkeseluruhan',0,array('class'=>'span2 integer-decimal','readonly'=>true)) ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="form-actions">
            <?php
                $disabled = ((isset($_GET['sukses'])) ? true : false);
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array(
                        'title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onKeypress' => 'simpanTindakan();', 'onclick' => 'simpanTindakan();',
                        'disabled' => $disabled
                    )
                );
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'return refreshForm(this);')
                );

                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array(
                    'class' => 'btn btn-info', 'onclick' => "print();return false", 'disabled' => (($disabled == true)? false:true)
                ));

                $content = $this->renderPartial('keuangan.views/tips/transaksi', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                if(isset($_GET['sukses']) == false){
                    echo CHtml::link(Yii::t('mds', '{icon} Pembayaran Tagihan', array('{icon}' => '<i class="entypo-paypal"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                }else{
                    echo CHtml::link(Yii::t('mds', '{icon} Pembayaran Tagihan', array('{icon}' => '<i class="entypo-paypal"></i>')), Yii::app()->createUrl("billingKasir/PembayaranTagihanPasien/index", array("instalasi_id"=>$_GET['instalasi_id'],"pendaftaran_id"=>$_GET['pendaftaran_id'], "frame" => true)), array("target"=>"iframePembayaran",'class' => 'btn btn-info', 'onclick' => "$(\"#dialogBayarKarcis\").dialog(\"open\");", 'disabled' => false));
                }
                
            ?>
        </div>
    </div>
</div>


<?php $this->endWidget(); ?>


<?php $this->renderPartial($this->path_view.'_jsFunctions', array('modPasien'=>$modPasien)); ?>
<?php $this->renderPartial($this->path_view.'_dialog', array()); ?>

<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogDokter1',
        'options' => array(
            'title' => 'Pencarian Dokter Pemeriksaan',
            'autoOpen' => false,
            'modal' => true,
            'width' => 800,
            'height' => 440,
            'resizable' => false,
        ),
    ));
    
    $modDok1 = new DokterV('searchDialogNotRuangan');
    $modDok1->unsetAttributes();    

    if(isset($_GET['DokterV'])) {
        $modDok1->attributes = $_GET['DokterV'];
    }
    
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'dokter1-m',
            'dataProvider'=>$modDok1->searchDialogNotRuangan(),
            'filter'=>$modDok1,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectDokter1",
                                        "onClick" => "
                                            setDokter1Auto($data->pegawai_id,\"$data->namaLengkap\");
                                        "))',
                    ),
                    array(
                        'header' => 'Nama',
                        'name' => 'nama_pegawai',
                        'value' => '$data->namaLengkap',
                        'filter' => Chtml::activeTextField($modDok1, 'nama_pegawai', array('class' => 'hurufs-only'))
                    )
                    
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogDokter2',
        'options' => array(
            'title' => 'Pencarian Dokter Pemeriksaan',
            'autoOpen' => false,
            'modal' => true,
            'width' => 800,
            'height' => 440,
            'resizable' => false,
        ),
    ));
    
    $modDok2 = new DokterV('searchDialogNotRuangan');
    $modDok2->unsetAttributes();    

    if(isset($_GET['DokterV'])) {
        $modDok2->attributes = $_GET['DokterV'];
    }
    
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'dokter2-m',
            'dataProvider'=>$modDok2->searchDialogNotRuangan(),
            'filter'=>$modDok2,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectDokter2",
                                        "onClick" => "
                                            setDokter2Auto($data->pegawai_id,\"$data->namaLengkap\");
                                        "))',
                    ),
                    array(
                        'header' => 'Nama',
                        'name' => 'nama_pegawai',
                        'value' => '$data->namaLengkap',
                        'filter' => Chtml::activeTextField($modDok2, 'nama_pegawai', array('class' => 'hurufs-only'))
                    )
                    
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogBayarKarcis',
    'options' => array(
        'title' => 'Pembayaran Tagihan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1000,
        'zIndex' => 1001,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframePembayaran" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>
