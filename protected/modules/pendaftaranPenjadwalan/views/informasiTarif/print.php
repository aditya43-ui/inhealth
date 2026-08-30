
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
                    border-spacing: 0;
                    padding: 0;
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>

<table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php

                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan'=>""));
                ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                    <?php
   $format = new MyFormatter();
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'daftarTindakan-grid',
    'dataProvider'=>$modTarifRad->searchTarifPrint(),
    'template'=>"{items}",
    'itemsCssClass'=>'table table-condensed',
    'enableSorting'=>false,
    'columns'=>array(
      /*  array(
            'header'=>'No.',
            'value'=>'$row+1',
        ),
        'jenistarif_nama',
        'jenispemeriksaanrad_nama',
        'pemeriksaanrad_nama',
        array(
            'name'=>'kelaspelayanan_nama',
            'htmlOptions'=>array('style'=>'text-align: center'),
        ),
        
        array(
            'header'=>'Tarif Pemeriksaan (Rp)',
            'name'=>'harga_tariftindakan',
            'value'=>'number_format($data->harga_tariftindakan,0,",",",")',
            'htmlOptions'=>array('style'=>'text-align: right;'),
        ),*/
		array(
            'header'=>'No.',
            'value'=>'$row+1',
        ),
                'jenistarif_nama',
                'instalasi_nama',
                'ruangan_nama',
		'kelompoktindakan_nama',
                'komponenunit_nama',
		'kategoritindakan_nama',
                'kelaspelayanan_nama',
		'daftartindakan_nama',		
                 array(
			'name'=>'tarifTotal',
			'value'=>'$this->grid->getOwner()->renderPartial(\'pendaftaranPenjadwalan.views.informasiTarif._tarifTotal\',array(\'kelaspelayanan_id\'=>$data->kelaspelayanan_id,\'daftartindakan_id\'=>$data->daftartindakan_id, \'jenistarif_id\'=>$data->jenistarif_id),true)',
                        'htmlOptions'=>array('style'=>'text-align: right'),
                ),
                array(
                    'name'=>'persencyto_tind',
                    'htmlOptions'=>array('style'=>'text-align: right'),
                ), 
                array(
                    'name'=>'persendiskon_tind',
                    'htmlOptions'=>array('style'=>'text-align: right'),
                ),
				array(
							'header'=>'Penjamin',
							'value' => '$data->penjamin_nama'
						),
		//'persencyto_tind',		
//            array(
//                'header'=>'Cyto (%)',
//                'name'=>'persencyto_tind',
//                'value'=>'$data->persencyto_tind',
//            ),
    ),    
)); ?>
		</div>		
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">
   
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
   
</div>   
