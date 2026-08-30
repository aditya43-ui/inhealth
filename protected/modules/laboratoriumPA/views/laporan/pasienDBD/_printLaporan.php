<?php 
    $itemCssClass = 'table table-striped table-condensed';
    $rim = 'width:600px;overflow-x:none;';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $data = $model->searchPrintPasienDBD();
    $template = "{summary}\n{items}\n{pager}";
	$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize ';
    $sort = true;
    $pagination = 10;
    if (isset($caraPrint)){
      $sort = false;
      $pagination = false;
      $data = $model->searchPrintPasienDBD();
      $rim = '';
      $template = "{items}";
      if ($caraPrint == "EXCEL"){
          $table = 'ext.bootstrap.widgets.BootExcelGridView';
      }
      
      if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGridViewPDF';
        }
        
        echo "
             <style>
            .border th, .border td{
                border:1px solid #000;
            }
            .table thead:first-child{
                border-top:1px solid #000;        
            }

            thead th{
                background:none;
                color:#333;
            }

            .border {
                box-shadow:none;
                border-spacing:0px;
                padding:0px;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
        $itemCssClass = 'table border';
    }
?>
<?php if(isset($_GET['filter_tab'])){ ?>
<?php if(isset($_GET['filter_tab']) == "rekap"){ ?>
<div id="div_rekap">
    <?php
            $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',
                array(
                    'id'=>'tableRekapPasienDBD',
                    'dataProvider'=>$model->searchPasienDBD(),
                    'template'=>$template,
                    'enableSorting'=>true,
                    'itemsCssClass'=>$itemCssClass,
                    'mergeHeaders'=>array(
                        array(
                            'name'=>'<center>HASIL (<i class="icon-ok icon-black"></i>) </center>',
                            'start'=>5, //indeks kolom 3
                            'end'=>6, //indeks kolom 4
                        ),
                    ),
                    'columns'=>array(
                        array(
                            'header' => '<center>NO</center>',
                            'type'=>'raw',
                            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                            'htmlOptions'=>array(
                                'style'=>'text-align:center'
                            ),
                       ),
                       array(
                           'header'=>'<center>NAMA</center>',
                           'type'=>'raw',
                           'value'=>'$data[nama_pasien]',
                       ),
                       array(
                           'header'=>'<center>ALAMAT</center>',
                           'type'=>'raw',
                           'value'=>'($data[rt] || $data[rw]) ? $data[alamat_pasien]." RT ".$data[rt]." / ".$data[rw] : $data[alamat_pasien]." "',
                       ),
                       array(
                           'header'=>'<center>UMUR / <br/> SEX</center>',
                           'type'=>'raw',
                           'value'=>'$data[umur]." /<br/>".$data[jeniskelamin]',
                       ),
                       array(
                           'header'=>'<center>TGL MASUK</center>',
                           'type'=>'raw',
                           'value'=>'$data[tgl_pendaftaran]',
                       ),
                       array(
                           'header'=>'<center>IGG</center>',
                           'type'=>'raw',
                           'value'=>'$this->grid->owner->renderPartial("pasienDBD/_igg",array(pasienmasukpenunjang_id=>$data[pasienmasukpenunjang_id],pendaftaran_id=>$data[pendaftaran_id]),true)',
                       ),
                       array(
                           'header'=>'<center>IGM</center>',
                           'type'=>'raw',
                           'value'=>'$this->grid->owner->renderPartial("pasienDBD/_igm",array(pasienmasukpenunjang_id=>$data[pasienmasukpenunjang_id],pendaftaran_id=>$data[pendaftaran_id]),true)',
                       ),
                       array(
                           'header'=>'<center>KETERANGAN</center>',
                           'type'=>'raw',
                           'value'=>'""',
                       ),
                    ),
                    'afterAjaxUpdate'=>'function(id, data){
                        jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
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

<?php }else if($_GET['filter_tab'] == "detail"){ ?>
<div id="div_detail">
        <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
            'id'=>'rincianPasienDBD',
            'dataProvider'=>$model->searchPasienDBD(),
            'template'=>$template,
            'enableSorting'=>true,
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'mergeHeaders'=>array(
                array(
                    'name'=>'<center>HASIL (<i class="icon-ok icon-black"></i>) </center>',
                    'start'=>9, //indeks kolom 3
                    'end'=>10, //indeks kolom 4
                ),
            ),
            'columns'=>array(
                array(
                    'header' => '<center>NO</center>',
                    'type'=>'raw',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                    'htmlOptions'=>array(
                        'style'=>'text-align:center'
                    ),
               ),
               array(
                   'header'=>'<center>NO RM</center>',
                   'type'=>'raw',
                   'value'=>'$data[no_rekam_medik]',
               ),
               array(
                   'header'=>'<center>NO LAB</center>',
                   'type'=>'raw',
                   'value'=>'$data[no_masukpenunjang]',
               ),
               array(
                   'header'=>'<center>NAMA</center>',
                   'type'=>'raw',
                   'value'=>'$data[nama_pasien]',
               ),
               array(
                   'header'=>'<center>ALAMAT</center>',
                   'type'=>'raw',
                   'value'=>'($data[rt] || $data[rw]) ? $data[alamat_pasien]." RT ".$data[rt]." / ".$data[rw] : $data[alamat_pasien]." "',
               ),
               array(
                   'header'=>'<center>KOTA</center>',
                   'type'=>'raw',
                   'value'=>'$data[kabupaten_nama]',
               ),
               array(
                   'header'=>'<center>PROPINSI</center>',
                   'type'=>'raw',
                   'value'=>'$data[propinsi_nama]',
               ),
               array(
                   'header'=>'<center>UMUR / <br/> SEX</center>',
                   'type'=>'raw',
                   'value'=>'$data[umur]." /<br/>".$data[jeniskelamin]',
               ),
               array(
                   'header'=>'<center>TGL MASUK</center>',
                   'type'=>'raw',
                   'value'=>'$data[tgl_pendaftaran]',
               ),
              array(
                   'header'=>'<center>IGG</center>',
                   'type'=>'raw',
                   'value'=>'$this->grid->owner->renderPartial("pasienDBD/_igg",array(nopenunjang=>$data[no_masukpenunjang],pendaftaran_id=>$data[pendaftaran_id]),true)',
              ),
              array(
                   'header'=>'<center>IGM</center>',
                   'type'=>'raw',
                   'value'=>'$this->grid->owner->renderPartial("pasienDBD/_igm",array(nopenunjang=>$data[no_masukpenunjang],pendaftaran_id=>$data[pendaftaran_id]),true)',
              ),
              array(
                   'header'=>'<center>KETERANGAN</center>',
                   'type'=>'raw',
                   'value'=>'""',
               ),
            ),
        )); ?> 
</div>
<?php } ?>

<?php }else{ ?>
	<div id="div_rekap">
    <?php
             $this->widget($table,
                array(
                    'id'=>'tableRekapPasienDBD',
                    'dataProvider'=>$model->searchPrint(),
                    'template'=>$template,
                    'enableSorting'=>true,
                    'itemsCssClass'=>$itemCssClass,
                    'mergeHeaders'=>array(
                        array(
                            'name'=>'<center>HASIL (<i class="icon-ok icon-black"></i>) </center>',
                            'start'=>5, //indeks kolom 3
                            'end'=>6, //indeks kolom 4
                        ),
                    ),
                    'columns'=>array(
                        array(
                            'header' => '<center>No.</center>',
                            'type'=>'raw',
                            'value' => '$row+1',
                            'htmlOptions'=>array(
                                'style'=>'text-align:center'
                            ),
                       ),
                       array(
                            'header'=>'<center>Tanggal Masuk Penunjang</center>',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatDateTimeForUser(date("d/m/Y H:i:s", strtotime($data->tglmasukpenunjang)))',
                        ),
                        array(
                            'header'=>'<center>Nama Pasien</center>',
                            'type'=>'raw',
                            'value'=>'$data->namadepan." ".$data->nama_pasien',
                        ),
                        array(
                            'header'=>'<center>Alamat</center>',
                            'type'=>'raw',
                            'value'=>'($data->rt || $data->rw) ? $data->alamat_pasien." RT ".$data->rt." / ".$data->rw : $data->alamat_pasien." "',
                        ),
                        array(
                            'header'=>'<center>Umur / <br/> Jenis Kelamin</center>',
                            'type'=>'raw',
                            'value'=>'$data->umur." /<br/>".$data->jeniskelamin',
                        ),                   
                        array(
                            'header'=>'<center>IgG</center>',
                            'type'=>'raw',
                            'value'=>'$this->grid->owner->renderPartial("pasienDBD/_igg",array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id,"pendaftaran_id"=>$data->pendaftaran_id),true)',
                        ),
                        array(
                            'header'=>'<center>IgM</center>',
                            'type'=>'raw',
                            'value'=>'$this->grid->owner->renderPartial("pasienDBD/_igm",array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id,"pendaftaran_id"=>$data->pendaftaran_id),true)',
                        ),
                        array(
                            'header'=>'<center>Keterangan</center>',
                            'type'=>'raw',
                            'value'=>'""',
                        ),
                    ),
                    'afterAjaxUpdate'=>'function(id, data){
                        jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
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
<?php } ?>