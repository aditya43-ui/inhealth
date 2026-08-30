<div class="panel-body overflow-x" > 
    <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
            'id'=>'remunerasikedisiplinan-t-grid',
            'dataProvider'=>$model->searchInformasi(),
            'template'=> "{summary}\n{items}\n{pager}",
            'enableSorting'=>true,
            'itemsCssClass'=>'table table-bordered table-striped table-condensed',
            'columns'=>array(
                array(
                    'header' => 'No',
                    'value'=>'($this->grid->dataProvider->pagination) ? 
                                ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1): ($row+1)',
                    'filter'=>false,
                ),
                array(
                    'header'=>'Tanggal dan Nomer Reseptur',
                    'value' => function ($data) use (&$ada_racikan, &$ada_nonracikan) {
                        $link = array();

                        $ada_racikan = false;
                        $ada_nonracikan = false;

                        $racikan = ResepturdetailT::model()->findByAttributes(array(
                            'reseptur_id' => $data->reseptur_id,
                            'racikan_id' => Params::RACIKAN_ID_RACIKAN,
                        ));
                        $nonRacikan = ResepturdetailT::model()->findByAttributes(array(
                            'reseptur_id' => $data->reseptur_id,
                            'racikan_id' => Params::RACIKAN_ID_NONRACIKAN,
                        ));

                        if (!empty($racikan)) {
                            $ada_racikan = true;
                            $link[] = CHtml::Link(
                                MyFormatter::formatDateTimeForUser($data->tglreseptur)."<br>".$data->noresep,
                                Yii::app()->createUrl("farmasiApotek/InformasiPasienResep/printResepDokter", array("id" => $data->reseptur_id, "racikan_id" => Params::RACIKAN_ID_RACIKAN, "frame" => 1)),
                                array(
                                    "class" => "",
                                    "target" => "iframeReseptur",
                                    "onclick" => "$(\"#dialogReseptur\").dialog(\"open\");",
                                    "rel" => "tooltip",
                                    "title" => "Klik untuk print reseptur dokter (Racikan)",
                                )
                            );
                        }

                        if (!empty($nonRacikan)) {
                            $ada_nonracikan = true;
                            $link[] = CHtml::Link(
                                MyFormatter::formatDateTimeForUser($data->tglreseptur)."<br>".$data->noresep,
                                Yii::app()->createUrl("farmasiApotek/InformasiPasienResep/printResepDokter", array("id" => $data->reseptur_id, "racikan_id" => Params::RACIKAN_ID_NONRACIKAN, "frame" => 1)),
                                array(
                                    "class" => "",
                                    "target" => "iframeReseptur",
                                    "onclick" => "$(\"#dialogReseptur\").dialog(\"open\");",
                                    "rel" => "tooltip",
                                    "title" => "Klik untuk print reseptur dokter (Non Racikan)",
                                )
                            );
                        }

                        return implode("<br>", $link);
                    },
                ),
                array(
                    'header'=>'Nomor Pendaftaran',
                    'value' => '$data->no_pendaftaran',
                ),
                array(
                    'header'=>'Nama dan No.RM Pasien',
                    'value' => function ($data) {
                        echo $data->nama_pasien;
                        echo "<br>";
                        echo $data->no_rekam_medik;
                    },
                ),
                array(
                    'header'=>'Nama Obat',
                    'value' => '$data->obatalkes_nama',
                ),
                array(
                    'header'=>'Satuan',
                    'value' => '$data->satuankecil_nama',
                ),
                array(
                    'header'=>'Jumlah Reseptur',
                    'value'=>function($data){
                        echo number_format($data->qty_reseptur,2,",",".");
                    },
                ),
                array(
                    'header'=>'Jumlah Penjualan Reseptur',
                    'value'=>function($data){
                        echo number_format($data->qty_penjualan,2,",",".");
                    },
                ),
                array(
                    'header' => 'Status',
                    'value' => '$data->status',
                ),
            ),
       'afterAjaxUpdate'=>'function(id, data){
        jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
        $("table").find("input[type=text]").each(function(){
            cekForm(this);
        })
    }',
    ));           
    echo '<br>';          
        ?>
</div>