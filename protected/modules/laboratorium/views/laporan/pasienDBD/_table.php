<div id="div_rekap">
    <?php
    $this->widget(
        'ext.bootstrap.widgets.HeaderGroupGridViewNonRp',
        array(
            'id' => 'tableRekapPasienDBD',
            'dataProvider' => $model->searchTable(),
            'template' => "{summary}\n{items}\n{pager}",
            'enableSorting' => true,
            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
            'mergeHeaders' => array(
                array(
                    'name' => 'Hasil (<i class="icon-ok icon-black"></i>) ',
                    'start' => 5, //indeks kolom 3
                    'end' => 6, //indeks kolom 4
                ),
            ),
            'columns' => array(
                array(
                    'header' => 'No.',
                    'type' => 'raw',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                    'htmlOptions' => array(
                        'style' => 'text-align:center'
                    ),
                ),
                array(
                    'header' => 'Tanggal Masuk Penunjang',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser(date("d/m/Y H:i:s", strtotime($data->tglmasukpenunjang)))',
                ),
                array(
                    'header' => 'Nama Pasien',
                    'type' => 'raw',
                    'value' => '$data->namadepan." ".$data->nama_pasien',
                ),
                array(
                    'header' => 'Alamat',
                    'type' => 'raw',
                    'value' => '($data->rt || $data->rw) ? $data->alamat_pasien." RT ".$data->rt." / ".$data->rw : $data->alamat_pasien." "',
                ),
                array(
                    'header' => 'Umur/<br>Jenis Kelamin',
                    'type' => 'raw',
                    'value' => '$data->umur."/<br>".$data->jeniskelamin',
                ),
                array(
                    'header' => 'IgG',
                    'type' => 'raw',
                    'value' => '$this->grid->owner->renderPartial("pasienDBD/_igg",array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id,"pendaftaran_id"=>$data->pendaftaran_id),true)',
                ),
                array(
                    'header' => 'IgM',
                    'type' => 'raw',
                    'value' => '$this->grid->owner->renderPartial("pasienDBD/_igm",array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id,"pendaftaran_id"=>$data->pendaftaran_id),true)',
                ),
                array(
                    'header' => 'Keterangan',
                    'type' => 'raw',
                    'value' => '""',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
                    jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                    $(".currency").each(function(){
                        $(this).text(
                            formatInteger($(this).text())
                        );
                    });
                }',
        )
    );
    ?>
</div>

<!--<div id="div_detail">
    <legend class="rim">Pasien DBD - Detail</legend>
        <?php /* $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
            'id'=>'rincianPasienDBD',
            'dataProvider'=>$model->searchPasienDBD(),
            'template'=>"{summary}\n{items}\n{pager}",
            'enableSorting'=>true,
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'mergeHeaders'=>array(
                array(
                    'name'=>'HASIL (<i class="icon-ok icon-black"></i>) ',
                    'start'=>9, //indeks kolom 3
                    'end'=>10, //indeks kolom 4
                ),
            ),
            'columns'=>array(
                array(
                    'header' => 'NO',
                    'type'=>'raw',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                    'htmlOptions'=>array(
                        'style'=>'text-align:center'
                    ),
               ),
               array(
                   'header'=>'NO RM',
                   'type'=>'raw',
                   'value'=>'$data[no_rekam_medik]',
               ),
               array(
                   'header'=>'NO LAB',
                   'type'=>'raw',
                   'value'=>'$data[no_masukpenunjang]',
               ),
               array(
                   'header'=>'NAMA',
                   'type'=>'raw',
                   'value'=>'$data[nama_pasien]',
               ),
               array(
                   'header'=>'ALAMAT',
                   'type'=>'raw',
                   'value'=>'($data[rt] || $data[rw]) ? $data[alamat_pasien]." RT ".$data[rt]." / ".$data[rw] : $data[alamat_pasien]." "',
               ),
               array(
                   'header'=>'KOTA',
                   'type'=>'raw',
                   'value'=>'$data[kabupaten_nama]',
               ),
               array(
                   'header'=>'PROPINSI',
                   'type'=>'raw',
                   'value'=>'$data[propinsi_nama]',
               ),
               array(
                   'header'=>'UMUR/<br>SEX',
                   'type'=>'raw',
                   'value'=>'$data[umur]."/<br>".$data[jeniskelamin]',
               ),
               array(
                   'header'=>'TGL MASUK',
                   'type'=>'raw',
                   'value'=>'$data[tgl_pendaftaran]',
               ),
              array(
                   'header'=>'IGG',
                   'type'=>'raw',
                   'value'=>'$this->grid->owner->renderPartial("pasienDBD/_igg",array(nopenunjang=>$data[no_masukpenunjang],pendaftaran_id=>$data[pendaftaran_id]),true)',
              ),
              array(
                   'header'=>'IGM',
                   'type'=>'raw',
                   'value'=>'$this->grid->owner->renderPartial("pasienDBD/_igm",array(nopenunjang=>$data[no_masukpenunjang],pendaftaran_id=>$data[pendaftaran_id]),true)',
              ),
              array(
                   'header'=>'KETERANGAN',
                   'type'=>'raw',
                   'value'=>'""',
               ),
            ),
        )); */ ?> 
</div>-->