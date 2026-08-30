<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Jadwal Buka Poli</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Jadwal Buka Poli' => array('admin'),
            'Pengaturan',
        );

        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            $('#PPJadwalBukaPoliM_ruangan_id').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('ppjadwal-buka-poli-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
        if (isset($_GET['sukses'])) :
            Yii::app()->user->setFlash('success', '<b>Berhasil!</b> Data berhasil disimpan.');
        endif;
        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="search-form cari-lanjut">
            <?php $this->renderPartial('_search', array(
                'model' => $model,
            )); ?>
        </div>
        <!--search-form-->

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Jadwal Buka Poli</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--<legend class="rim">Tabel Jadwal Buka Poli</legend>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'ppjadwal-buka-poli-m-grid',
                    'dataProvider' => $model->searchMasterPP(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'columns' => array(
                        ////'jadwalbukapoli_id',
                        array(
                            'name' => 'jadwalbukapoli_id',
                            'value' => '$data->jadwalbukapoli_id',
                            'filter' => false,
                        ),
                        array(
                            'name' => 'ruangan_id',
                            'value' => '$data->ruangan->ruangan_nama',
                            'filter' =>  CHtml::dropDownList('PPJadwalBukaPoliM[ruangan_id]', $model->ruangan_id, CHtml::listData($model->getRuanganItems(), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --')),
                        ),
                        array(
                            'name' => 'hari',
                            'value' => '$data->hari',
                            'filter' => CHtml::activeDropDownList($model, 'hari', CustomFunction::getNamaHari(), array('class' => 'span2  ', 'onkeyup' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --'))
                        ),                        array(
                            'header' => 'Jadwal Poliklinik',
                            'name' => 'jmabuka',
                            'value' => '$data->jmabuka',
                        ),
                        array(
                            'header' => 'Jam Buka Poliklinik',
                            'name' => 'jammulai',
                            'value' => '$data->jammulai',
                            'filter' => false,
                        ),
                        array(
                            'header' => 'Jam Tutup Poliklinik',
                            'name' => 'jamtutup',
                            'value' => '$data->jamtutup',
                            'filter' => false,
                        ),
                        array(
                            'header' => 'Jam Mulai Pendaftaran Poliklinik',
                            'name' => 'jammulaipendaftaran',
                            'value' => '$data->jammulaipendaftaran',
                            'filter' => false,
                        ),
                        array(
                            'header' => 'Jam Akhir Pendaftaran Poliklinik',
                            'name' => 'jamakhirpendaftaran',
                            'value' => '$data->jamakhirpendaftaran',
                            'filter' => false,
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat Jadwal Buka Poli')
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
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah Jadwal Buka Poli')
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{delete}',
                            'buttons' => array(
                                //                                        'remove' => array (
                                //                                                'label'=>"<i class='icon-form-silang'></i>",
                                //                                                'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                                //                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->jadwalbukapoli_id"))',
                                //                                                'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
                                //                                                'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
                                //                                        ),
                                'delete' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Hapus Jadwal Buka Poli')
                                ),
                            )
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
                jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                $("table").find("input[type=text]").each(function(){
                    cekForm(this);
                })
                $("table").find("select").each(function(){
                    cekForm(this);
                })
            }',
                )); ?>
                <?php
                /*
    <table>
        <tr>
            <td width="12%"><?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
                <div class="cari-lanjut search-form">
                <?php $this->renderPartial('_search',array(
                    'model'=>$model,
                )); ?>
                </div><!--search-form--></td>
            <td width="16%"><?php echo CHtml::link(Yii::t('mds', '{icon} Tambah Jadwal Buka Poli', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('/pendaftaranPenjadwalan/jadwalBukaPoliM/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?></td>
            <td width="8%"><?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
            'type'=>'info', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'buttons'=>array(
                array('label'=>'Print', 'icon'=>'entypo-print', 'url'=>'#', 'htmlOptions'=>array('onclick'=>'print(\'PRINT\')')),
                array('label'=>'', 'items'=>array(
                    array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'PDF\')')),
                    array('label'=>'Excel','icon'=>'icon-pdf', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'EXCEL\')')),
                    array('label'=>'Grafik','icon'=>'entypo-print', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'GRAFIK\')')),
                )),       
            ),
    //        'htmlOptions'=>array('class'=>'btn')
            ));?>
            </td>
            <td><?php $content = $this->renderPartial('../tips/master',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
                $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller); ?>   </td>
        </tr>
    </table>
    */ ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Jadwal Buka Poli', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('/pendaftaranPenjadwalan/jadwalBukaPoliM/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah jadwal buka poli', 'class' => 'btn btn-danger')
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('../tips/master2', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');

            $js = <<< JSCRIPT
           function cekForm(obj)
{
    $("#ppjadwal-buka-poli-m-search :input[name='"+ obj.name +"']").val(obj.value);
}     
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#ppjadwal-buka-poli-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>