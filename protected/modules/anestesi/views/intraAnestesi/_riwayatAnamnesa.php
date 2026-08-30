<div class="row-fluid">
    <div class="span11">        
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                'data'=>$modAnamnesa,
                'attributes'=>array(
                    array(
                        'name'=>'tglanamnesis',
                        'value'=>MyFormatter::formatDateTimeForUser($modAnamnesa->tglanamnesis),
                    ),
                    'keluhanutama',
                    'keluhantambahan',
                    'riwayatperjalananpasien',
                    'riwayatpenyakitterdahulu',
                    'riwayatpenyakitkeluarga',
					'riwayatalergiobat',
					'riwayatmakanan',
					'riwayatalergilainnya',                    
                    'pengobatanygsudahdilakukan',                    
                    'riwayatkelahiran',                    
                    'riwayatimunisasi',
					array(
						'label'=>'Status Merokok',
						'value'=>($modAnamnesa->statusmerokok) ? "Ya" : "Tidak",
					),
					array(
						'label'=>'Jml. Rokok/Hari',
						'value'=>$modAnamnesa->jmlrokok_btg_hr,
					),
					array(
						'label'=>'Minuman Keras',
						'value'=>($modAnamnesa->minumankeras) ? "Ya" : "Tidak",
					),
                    'keterangananamesa',
                ),
        )); ?>  
	</div>
</div>