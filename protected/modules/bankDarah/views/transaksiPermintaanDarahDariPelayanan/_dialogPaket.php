<?php 
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogTipePaket',
    'options'=>array(
        'title'=>'Pencarian Paket Pemeriksaan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>480,
        'resizable'=>false,
    ),
));
    $modJenisKomponenDarah = new JeniskomponendarahM('search');
    if (isset($_GET['JeniskomponendarahM'])) {
        $modJenisKomponenDarah->attributes = $_GET['JeniskomponendarahM'];
    }
    ?>
    <?php
    $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;


    $this->widget($table, array(
        'id' => 'satipe-paket-m-grid',
        'dataProvider' => $modJenisKomponenDarah->search(),
        'enableSorting' => $sort,
        'filter'=>$modJenisKomponenDarah, 
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
								"id" => "selectKunjungan",
								"onClick" => "
									setPencatatanStok($data->jeniskomponendarah_id, \"$data->jeniskomponenedarah_nama\");
									$(\"#dialogTipePaket\").dialog(\"close\");
								"))',
			),
            'jeniskomponenedarah_nama',
            'jeniskantongdarah_singkatan',
            // array(
            //     'header' => 'Uraian Tindakan',
            //     'type' => 'raw',
            //     'value' => '$this->grid->getOwner()->renderPartial(\'bankDarah.views.transaksiPermintaanDarahDariPelayanan.partial._daftarTindakan\',array(\'tipepaket_id\'=>$data->tipepaket_id),true)',
            // ),
        
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));


$this->endWidget();
?> 