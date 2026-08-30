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
                    'riwayatpenyakitterdahulu',
                    'riwayatpenyakitkeluarga',
                    'lamasakit',
                    'pengobatanygsudahdilakukan',
                    'riwayatalergiobat',
                    'riwayatkelahiran',
                    'riwayatmakanan',
                    'riwayatimunisasi',
                    'paramedis_nama',
                    'keterangananamesa',
                ),
        )); ?>       
</div>
</div>