<?php
$this->breadcrumbs = array(
    'Transaksi Pemakaian Bahan',
); ?>
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

     .noshadowtabel{
         box-shadow: none !important;
     }
</style>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class='fas fa-mortar-pestle'></i> Transaksi <b>Pemakaian Bahan</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB 
        ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data pemakaian Bahan berhasil disimpan!");
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pemakaianbahp-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#no_pendaftaran',
        )); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class='far fa-file-alt'></i> Data <b>Kunjungan</b>
                    <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-primary btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
                </div>
            </div>
            <div class="panel-body">
                <fieldset class="" id="form-datakunjungan">
                    <div class="row">
                        <?php $this->renderPartial($this->path_view . '_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
                    </div>
                </fieldset>
            </div>
        </div>

        <?php
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'riwayat-obatalkespasien-t',
            'content' => array(
                'content-riwayat-obatalkespasien-t' => array(
                    'header' => '<b>Tabel Riwayat Pemakaian Bahan Pasien</b>',
                    'isi' => $this->renderPartial($this->path_view . '_riwayatBmhp', array(
                        'form' => $form,
                        'modKunjungan' => $modKunjungan,
                    ), true),
                    'active' => false,
                ),
            ),
        ));
        ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><i class="entypo-credit-card"></i> Pemakaian Bahan Pasien</div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_formBmhp', array()); ?>
                
            </div>
        </div>

        <div class="form-actions">
            <?php
            $disablebtn = (!empty($_GET['sukses'])? true: false);

            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type'=>'button', 'onclick'=>'setVerifikasi()', 'onkeypress'=>'setVerifikasi()', 'disabled'=>$disablebtn)
            );
            echo '&nbsp;&nbsp;';
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'if(!confirm("Apakah Anda ingin mengulang ini ?")) return false;'
                )
            );
            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print();",'disabled'=>(($disablebtn == true)?false:true)));

            $content = $this->renderPartial($this->path_view . 'tips/tipsPemakaianBahan', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('modKunjungan' => $modKunjungan, 'modObatAlkesPasien' => $modObatAlkesPasien)); ?>

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
        'position'=>array('my'=>'bottom','at'=>'bottom')
    ),
));
$modBhp= new ObatalkesM('searchDialogBHPRuangan');
$modBhp->unsetAttributes();
if(isset($_GET['ObatalkesM'])){
    $modBhp->attributes = $_GET['ObatalkesM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'obatalkes-m-grid',
	'dataProvider'=>$modBhp->searchDialogBHPRuangan(),
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
                            $(\'#satuanpakaibahan\').val(\'$data->satuankecil_nama\');
                            tambahPemakaianBahan(true);
                            
                            return false;"
                    ))',
        ),
        array(
            'header'=>'Jenis Obat Alkes',
            'type'=>'raw',
            'value'=>'$data->jenisobatalkes_nama',
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
