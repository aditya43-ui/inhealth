<!--<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-doc-text"></i>
            <?php

            if ($informConsent) {
                echo "Riwayat Inform Consent";
            } else {
                echo "Riwayat Surat Persetujuan/Penolakan Tindakan";
            }

            ?>
        </div>
    </div>
    <div class="panel-body">-->
<?php

$model = new SuratpersetujuantmT();
// $model->jenissurat = $jenissurat;
$model->pendaftaran_id = $pendaftaran_id;
// $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

if ($informConsent) {
    $prov = $model->searchInformConsent();
} else {
    $prov = $model->searchPerseTujuanTindakan();
}
$prov->pagination->pageSize = 5;
$prov->sort->defaultOrder = 'tglpersetujuan desc';



$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftarPasien-grid',
    'dataProvider' => $prov,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Tgl. Surat',
            'name' => 'tglpersetujuan',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpersetujuan);'
        ),
        array(
            'header' => 'Ruangan',
            'type' => 'raw',
            'value' => function ($data) {
                if (!empty($data->ruangan_id)) {
                    $ruangan = RuanganM::model()->findByPk($data->ruangan_id);
                    if (empty($ruangan)) {
                        return "-";
                    }
                    return $ruangan->ruangan_nama;
                }
                return "-";
            }
        ),
        /*
                array(
                    'header'=>'Inform Consent',
                    'type'=>'raw',
                    'value'=>function($data) use (&$inform) {
                        $inform = InformconsentT::model()->findByAttributes(array(
                            'suratpersetujuantm_id'=>$data->suratpersetujuantm_id,
                        ));
                        
                        if (!empty($inform)) {
                            return '<i class="entypo-check"></i>';
                        } else {
                            return "-";
                        }
                    },
                    'htmlOptions'=>array(
                        'style'=>'text-align: center; width: 110px;',
                    )
                ),       
                         * 
                         */
        array(
            'header' => 'No. Surat',
            'name' => 'nopersetujuan',
            'value' => '$data->nopersetujuan'
        ),
        array(
            'header' => 'Jenis Surat',
            'name' => 'jenissurat',
            'value' => '$data->jenissurat'
        ),
        array(
            'header' => 'Detail',
            'type' => 'raw',
            'value' => function ($data) use ($pendaftaran_id, $informConsent) {
                if ($informConsent) {
                    return CHtml::link('<i class="icon-form-detail"></i>', $this->createUrl('detailInformConsent', array(
                        'id' => $pendaftaran_id, 'suratpersetujuantm_id' => $data->suratpersetujuantm_id,
                        'frame' => (isset($_GET['frame']) && $_GET['frame'] == 1) ? 1 : 0
                    )));
                }

                return CHtml::link('<i class="icon-form-detail"></i>', $this->createUrl('detailPersetujuanTindakan', array(
                    'id' => $pendaftaran_id, 'suratpersetujuantm_id' => $data->suratpersetujuantm_id,
                    'frame' => (isset($_GET['frame']) && $_GET['frame'] == 1) ? 1 : 0
                ))) .'<br/>'. CHtml::link('<i class="icon-form-print"></i> <br/> Print Informasi', 'javascript:void(0)', array(
                    'onclick'=>"printInformasiRiwayat(".$data->suratpersetujuantm_id.", ".$data->pendaftaran_id.", 'PRINT'); return false;",
                )) .'<br/>'.  CHtml::link('<i class="icon-form-print"></i> <br/> Print Surat Keterangan', 'javascript:void(0)', array(
                    'onclick'=>"printRiwayat(".$data->suratpersetujuantm_id.", ".$data->pendaftaran_id.", 'PRINT'); return false;",
                ));
            },
            'htmlOptions' => array(
                'style' => 'text-align: center;',
            )
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>
<!--</div>
</div>-->

<script type="text/javascript">
function printInformasiRiwayat(suratpersetujuantm_id, pendaftaran_id, caraPrint)
{
    window.open('<?php echo $this->createUrl('/rawatDarurat/persetujuanTindakanTRD/printInformasi'); ?>&suratpersetujuantm_id='+suratpersetujuantm_id+'&caraprint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

function printRiwayat(suratpersetujuantm_id, pendaftaran_id, caraPrint)
{
    window.open('<?php echo $this->createUrl('/rawatDarurat/persetujuanTindakanTRD/print'); ?>&suratpersetujuantm_id='+suratpersetujuantm_id+'&pendaftaran_id='+pendaftaran_id+'&caraprint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}
</script>