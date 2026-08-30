
<?php
    $this->breadcrumbs = array(
        'Informasi Harga Obat Alkes Berdasarkan Penjamin',
    );
    $this->widget('bootstrap.widgets.BootAlert');
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title" style="width: 100%">
            <span style="float: left !important; width:80% !important;"><b>Informasi Harga Obat Alkes Berdasarkan Penjamin</b></span><span style="float: right !important;">
               <?php
                if ($this->getReferrer()) {
                    echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', $this->getReferrer(), array('class'=>'btn btn-red', 'style'=>'color: white;'));
                } ?>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <div class="block-tabel">
            <div style="overflow: auto;">
                <?php
                    $this->widget('ext.bootstrap.widgets.BootGroupGridView', array(
                        'id' => 'obatalkespenjamin-v-grid',
                        'dataProvider' => $model->searchInformasiHargaObatPenjamin(),
                        'filter' => $model,
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                        'mergeColumns' => array('obatalkes_id','jenisobatalkes_id','carabayar_id','penjamin_id'),
                        'columns' => array(
                            array(
                                'header' => 'No.',
                                'value' => '($this->grid->dataProvider->pagination) ?
                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                    : ($row+1)',
                                'type' => 'raw',
                                'htmlOptions' => array('style' => 'text-align:right;'),
                            ),
                            array(
                                'header' => 'Nama Obat Alkes',
                                'name' => 'obatalkes_id',
                                'filter' => CHtml::activeHiddenField($model,'obatalkes_id'),
                                'value' => '$data->obatalkes_nama',
                            ),
                            array(
                                'header' => 'Jenis Obat Alkes',
                                'name' => 'jenisobatalkes_id',
                                'filter' => CHtml::listData(JenisobatalkesM::model()->findAll('jenisobatalkes_aktif is TRUE order by jenisobatalkes_nama ASC'), 'jenisobatalkes_id', 'jenisobatalkes_nama'),
                                'value' => '$data->jenisobatalkes_nama',
                            ),
                            array(
                                'header' => 'Jenis Penjamin',
                                'name' => 'carabayar_id',
                                'filter' => CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif is TRUE order by carabayar_nama ASC'), 'carabayar_id', 'carabayar_nama'),
                                'value' => '$data->carabayar_nama',
                            ),
                            array(
                                'header' => 'Penjamin',
                                'name' => 'penjamin_id',
                                'filter' => CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif is TRUE order by penjamin_nama ASC'), 'penjamin_id', 'penjamin_nama'),
                                'value' => '$data->penjamin_nama',
                            ),
                            array(
                                'header' => 'Harga Netto (Rp)',
                                'type' => 'raw',
                                'filter' => false,
                                'value' => 'MyFormatter::formatNumberForPrint($data->harganetto,2)',
                                'htmlOptions'=>array('style'=>'text-align: right')
                            ),
                            array(
                                'header' => 'Keringanan Pembelian (%)',
                                'type' => 'raw',
                                'filter' => false,
                                'value' => 'MyFormatter::formatNumberForPrint($data->discount,2)',
                                'htmlOptions'=>array('style'=>'text-align: right')
                            ),
                            array(
                                'header' => 'PPN (%)',
                                'type' => 'raw',
                                'filter' => false,
                                'value' => 'MyFormatter::formatNumberForPrint($data->ppn_persen,2)',
                                'htmlOptions'=>array('style'=>'text-align: right')
                            ),
                            array(
                                'header' => 'HPP (Rp)',
                                'type' => 'raw',
                                'filter' => false,
                                'value' => 'MyFormatter::formatNumberForPrint($data->hpp,2)',
                                'htmlOptions'=>array('style'=>'text-align: right')
                            ),
                            array(
                                'header' => 'Margin (%)',
                                'type' => 'raw',
                                'filter' => false,
                                'value' => 'MyFormatter::formatNumberForPrint($data->persmargin,2)',
                                'htmlOptions'=>array('style'=>'text-align: right')
                            ),
                            array(
                                'header' => 'Harga Jual (Rp)',
                                'type' => 'raw',
                                'filter' => false,
                                'value' => function ($data){
                                    $marginrp = round((($data->hpp * $data->persmargin)/100),2);

                                    $hargaJual = round(($data->hpp + $marginrp),2);
                                    return MyFormatter::formatNumberForPrint($hargaJual,2);
                                },
                                'htmlOptions'=>array('style'=>'text-align: right')
                            ),
                            array(
                                'header' => 'Biaya Administrasi (Rp)',
                                'type' => 'raw',
                                'filter' => false,
                                'value' => 'MyFormatter::formatNumberForPrint($data->biayaadministrasi,2)',
                                'htmlOptions'=>array('style'=>'text-align: right')
                            ),
                            array(
                                'header' => 'Keringanan Penjualan (%)',
                                'type' => 'raw',
                                'filter' => false,
                                'value' => 'MyFormatter::formatNumberForPrint($data->persdiskon,2)',
                                'htmlOptions'=>array('style'=>'text-align: right')
                            ),
                            array(
                                'header' => 'Keringanan Penjualan (Rp)',
                                'type' => 'raw',
                                'filter' => false,
                                'value' => function ($data){
                                    $marginrp = round((($data->hpp * $data->persmargin)/100),2);
                                    $hargaJual = round(($data->hpp + $marginrp),2);
                                    $diskonPenjRp = round(((($hargaJual + $data->biayaadministrasi)  * $data->persdiskon)/100),2);

                                    return MyFormatter::formatNumberForPrint($diskonPenjRp,2);
                                },
                                'htmlOptions'=>array('style'=>'text-align: right')
                            ),
                            array(
                                'header' => 'Total Harga (Rp)',
                                'type' => 'raw',
                                'filter' => false,
                                'value' => function ($data){
                                    $marginrp = round((($data->hpp * $data->persmargin)/100),2);
                                    $hargaJual = round(($data->hpp + $marginrp),2);
                                    $diskonPenjRp = round(((($hargaJual + $data->biayaadministrasi)  * $data->persdiskon)/100),2);
                                    $total_harga = round(($hargaJual  + $data->biayaadministrasi - $diskonPenjRp),2);
                                    return MyFormatter::formatNumberForPrint($total_harga,2);
                                },
                                'htmlOptions'=>array('style'=>'text-align: right')
                            ),
                        ),
                        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                    ));
                ?>
            </div>
        </div>
        <br />
	    <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
            $this->widget('UserTips', array('content' => ''));
            $urlPrint = $this->createUrl('viewHargaObatAlkesPenjamin');
            $id = $obatalkes_id;

            $js = <<< JSCRIPT
            function print(caraPrint)
            {
                window.open("${urlPrint}/"+$('#obatalkespenjamin-v-grid').find('input,select').serialize()+"&caraPrint="+caraPrint+"&obatalkes_id="+${id},"",'location=_new, width=900px');
            }
            JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
    </div>
</div>

