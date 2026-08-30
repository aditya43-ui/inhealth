<style type="text/css">
    .tindakanId,
    .ruanganId,
    .kompId {
        display: none;
    }

    .tdOdd {
        background-color: #f8f8f8;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Rekening Pelayanan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Rekening Pelayanan',
        );

        Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
                $('.search-form').toggle();

                return false;
        });
        $('.search-form form').submit(function(){
                $.fn.yiiGridView.update('sarekpelayanan-m-grid', {
                        data: $(this).serialize()
                });
                setBackgroundTr();
                return false;
        });
        ");

        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id;

        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <?php // echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn'));  
        ?>
        <!--<div class="cari-lanjut search-form" style="display:none;border:1px solid;padding:10px;">-->
        <?php
        //            $this->renderPartial($this->path_view . '_search', array(
        //                'model' => $model,
        //            ));
        ?>
        <!--</div> search-form-->
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Rekening Pelayanan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'sarekpelayanan-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}{pager}",
                    'itemsCssClass' => 'table table-bordered datatable',
                    'columns' => array(
                        array(
                            'header' => 'Ruangan',
                            'value' => '(!empty($data->ruangan_nama)?$data->ruangan_nama:" - ")',
                            'filter' => CHtml::activeDropDownList($model, 'ruangan', CHtml::listData(SARuanganM::getItemsList(), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --')),
                        ),
                        array(
                            'header' => 'Uraian Tindakan',
                            'name' => 'daftartindakan_nama',
                            'value' => '(!empty($data->daftartindakan_nama)?$data->daftartindakan_nama:" - ")',
                        ),
                        array(
                            'header' => 'Komponen Tarif',
                            'value' => '(!empty($data->komponentarif_nama)? $data->komponentarif_nama : " - ")',
                            //                            'filter' => CHtml::activeDropDownList($model, 'komponentarif_id', CHtml::listData(
                            //                           KomponentarifM::model()->findAll(array(
                            //                               'condition'=>'komponentarif_aktif = true',
                            //                               'order'=>'komponentarif_nama',
                            //                           )),'komponentarif_id','komponentarif_nama'), array(
                            //                               'empty'=>'-- Pilih --',
                            //                           )),
                        ),
                        array(
                            'header' => 'Kode Akun',
                            'name' => 'kdrekening5',
                            'value' => '(!empty($data->kdrekening5)?$data->kdrekening5:" - ")',
                        ),
                        array(
                            'header' => 'Nama Akun',
                            'name' => 'nmrekening5',
                            'value' => '(!empty($data->nmrekening5)?$data->nmrekening5:" - ")',
                        ),
                        array(
                            'header' => 'Saldo Normal',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return $data->saldonormal == 'D' ? 'Debit' : 'Kredit';
                            },
                            'filter' => CHtml::activeDropDownList(
                                $model,
                                'saldonormal',
                                array('D' => 'Debit', 'K' => 'Kredit'),
                                array('empty' => '-- Pilih --')
                            ),
                        ),
                        array(
                            'header' => 'Pelayanan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return $data->ispelayanan ? '<i class="glyphicon glyphicon-ok"></i><span class="tindakanId">' . $data->daftartindakan_id . '</span>' : '- <span class="tindakanId">' . $data->daftartindakan_id . '</span>';
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center'
                            )
                        ),
                        //                        array(
                        //                                'header'=>'Pembayaran',
                        //                                'type'=>'raw',
                        //                                'value'=>function($data) {
                        //                                        return $data->ispembayaran?'<i class="glyphicon glyphicon-ok"></i><span class="ruanganId">'.$data->ruangan_id.'</span>':'- <span class="ruanganId">'.$data->ruangan_id.'</span>';
                        //                                },
                        //                                'htmlOptions'=>array(
                        //                                        'style'=>'text-align: center'
                        //                                )
                        //                        ),
                        // array(
                        //         'header'=>'Retur',
                        //         'type'=>'raw',
                        //         'value'=>function($data) {
                        //                 return $data->isretur?'<i class="glyphicon glyphicon-ok"></i><span class="kompId">'.$data->komponentarif_id.'</span>':'- <span class="kompId">'.$data->komponentarif_id.'</span>';
                        //         },
                        //         'htmlOptions'=>array(
                        //                 'style'=>'text-align: center'
                        //         )
                        // ),
                        //                        array(
                        //                                'header'=>'Hutang',
                        //                                'type'=>'raw',
                        //                                'value'=>function($data) {
                        //                                        return $data->ishutang?'<i class="glyphicon glyphicon-ok"></i>':"-";
                        //                                },
                        //                                'htmlOptions'=>array(
                        //                                        'style'=>'text-align: center'
                        //                                )
                        //                        ),
                        array(
                            'header' => 'Mapping tindakan Ruangan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return (!empty($data->ruangan) ? '<i class="glyphicon glyphicon-ok"></i>' : "-");
                            },
                            'filter' => CHtml::activeDropDownList(
                                $model,
                                'mappingruangan',
                                array('sudah' => 'Sudah', 'belum' => 'Belum'),
                                array('empty' => '-- Pilih --')
                            ),
                            'htmlOptions' => array(
                                'style' => 'text-align: center'
                            )
                        ),
                        array(
                            'header' => 'Mappingan Rekening Pelayanan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return (!empty($data->pelayananrek_id) ? '<i class="glyphicon glyphicon-ok"></i>' : "-");
                            },
                            'filter' => CHtml::activeDropDownList(
                                $model,
                                'mappingpelayanan',
                                array('sudah' => 'Sudah', 'belum' => 'Belum'),
                                array('empty' => '-- Pilih --')
                            ),
                            'htmlOptions' => array(
                                'style' => 'text-align: center'
                            )
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'icon' => 'icon-form-lihat',
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view",array("idRuangan"=>"$data->ruangan","idTindakan"=>"$data->daftartindakan_id"))',
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat Tindakan Ruangan'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Ubah',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/Update",array("id"=>"$data->pelayananrek_id"))',
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE)) && (!empty($data->pelayananrek_id)?true:false)',
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'class' => 'ext.bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{delete}',
                            'buttons' => array(
                                'delete' => array(
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/Delete",array("id"=>"$data->pelayananrek_id"))',
                                    'icon' => "icon-form-sampah",
                                    'visible' => '(!empty($data->pelayananrek_id)?true:false)',
                                ),
                            ),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
                        . 'setBackgroundTr(); }',
                ));
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Akun Pelayanan', array('{icon}' => '<i class="' . MyIcon::getIcons('tambah-baris') . '"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah akun pelayanan', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial($this->path_view . 'tips.tipsAdmin', array(), true);
            $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            //mengambil Module yang sedang dipakai
            $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
            $js = <<< JSCRIPT
    function print(caraPrint)
    {
        window.open("${urlPrint}/"+$('#sarekpelayanan-m-grid').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                $('input[name="SAPelayananrekM[daftartindakan_nama]"]').focus();

            });

            setBackgroundTr();

            function setBackgroundTr() {
                $("#sarekpelayanan-m-grid tbody tr").each(function() {
                    var jurnalrekeningId = $(this).find(".tindakanId").text();
                    var id_ruangan = $(this).find(".ruanganId").text();
                    var komponen = $(this).find(".kompId").text();
                    $(this).removeClass('odd even');
                    if (jurnalrekeningId != '') {
                        back = parseFloat(jurnalrekeningId) % 2;
                        if (back == 1) {
                            backRuangan = parseFloat(id_ruangan) % 2;
                            if (backRuangan == 1) {
                                backKomponen = parseFloat(komponen) % 2;
                                if (backKomponen == 1) {
                                    $(this).find('td').addClass("tdOdd");
                                }

                            }
                        }
                    }
                });
            }
        </script>
    </div>
</div>