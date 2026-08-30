<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <?php $jenis = ($jenissurat == Params::SURAT_PERSETUJUAN_PERSETUJUAN) ? 'Persetujuan' : 'Penolakan'?>
            <?php $url_jenis = ($jenissurat == Params::SURAT_PERSETUJUAN_PERSETUJUAN) ? 'index' : 'penolakan'?>
            Riwayat Surat <?php echo $jenis ?>
        </div>
    </div>
    <div class="panel-body">
        <?php 
        
        
        
        $model = new SuratpersetujuantmT();
        $model->unsetAttributes();
        $model->jenissurat = $jenissurat;
        $model->pendaftaran_id = $pendaftaran_id;
        // $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
         
        $prov = $model->search();
        $prov->criteria->join = "join informconsent_t i on i.suratpersetujuantm_id = t.suratpersetujuantm_id";
        
        $prov->pagination->pageSize = 5;
        $prov->sort->defaultOrder = 'tglpersetujuan desc';
        
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id'=>'daftarPasien-grid',
            'dataProvider'=>$prov,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-bordered table-striped table-condensed',
            'columns'=>array(
                array(
                    'header'=>'Tgl. '.$jenis,
                    'name'=>'tglpersetujuan',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tglpersetujuan);',
                    'htmlOptions'=>array(
                        'style'=>'width: 150px;',
                    )
                ),
                array(
                    'header'=>'Ruangan',
                    'type'=>'raw',
                    'value'=>function($data) {
                        if (!empty($data->ruangan_id)) {
                            $ruangan = RuanganM::model()->findByPk($data->ruangan_id);
                            if (empty($ruangan)) {
                                return "-";
                            }
                            return $ruangan->ruangan_nama;
                        }
                        return "-";
                    },
                    'htmlOptions'=>array(
                        'style'=>'width: 150px;',
                    )
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
                    'header'=>'No. '.$jenis,
                    'name'=>'nopersetujuan',
                    'value'=>'$data->nopersetujuan',
                ),
                array(
                    'header'=>'Detail',
                    'type'=>'raw',
                    'value'=>function($data) use ($pendaftaran_id, $url_jenis, &$inform) {
                        
                        $inform = InformconsentT::model()->findByAttributes(array(
                            'suratpersetujuantm_id'=>$data->suratpersetujuantm_id,
                        ));
                        
                        $base_url = Yii::app()->controller->url_persetujuan;
                        $var_persetujuan = 'suratpersetujuantm_id';
                        if (!empty($inform)) {
                            $base_url = Yii::app()->controller->url_inform_consent;
                            $var_persetujuan = 'persetujuan_id';
                        }
                        
                        return CHtml::link('<i class="icon-form-detail"></i>', $this->createUrl($base_url."/".$url_jenis, array('pendaftaran_id'=>$pendaftaran_id, $var_persetujuan=>$data->suratpersetujuantm_id, 
                            'frame'=>(isset($_GET['frame']) && $_GET['frame'] == 1) ? 1 : 0)));
                    },
                    'htmlOptions'=>array(
                        'style'=>'text-align: center; width: 50px;',
                    )
                ),
             ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));
        ?>
    </div>
</div>