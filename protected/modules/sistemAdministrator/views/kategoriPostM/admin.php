<?php
/**
 * digunakan untuk modul portal rs post berita
 * RSST-2443
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 *
 */
?>
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#penilaian-indikator-m-search').submit(function(){
            $.fn.yiiGridView.update('penilaianiki-indikator-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
$this->widget('bootstrap.widgets.BootAlert');
//$this->renderPartial('_tabMenu',array());
?>


<div class="panel panel-gradient">
    <div class="panel-heading">    
        <div class="panel-title">Pengaturan <b>Kategori Berita</b></div>
    </div>
    <div class="panel-body"> 
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="search-form cari-lanjut3" style="display:none">
            <?php
            $this->renderPartial('_search', array(
                'model' => $model,
            ));
            ?>
        </div><!-- search-form -->
        <hr/>
        <div class="panel panel-success">
            <div class="panel-heading">    
                <div class="panel-title">Tabel <b>Kategori Berita</b></div>
            </div>
            <div class="panel-body"> 
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'penilaianiki-indikator-m-grid',
                    'dataProvider' => $model->searchNew(),
                    'filter' => $model,
                    'columns' => array(
                        array(
                            'header' => 'No',
                            'value' => '$row+1',
                        ),
                        array(
                            'header' => 'Kategori Berita',
                            'name' => 'kategoripost_nama',
                            'value' => function($data) {

                                if (!empty($data->kategoripost_id)) {
                                    return $data->kategoripost_nama;
                                }
                            },
                        ),
                        array(
                            'header' => 'Nama Lainnya',
                            'name' => 'kategoripost_namalain',
                            'type' => 'raw',
                            'value' => function($data) {

                                if (!empty($data->kategoripost_id)) {
                                    return $data->kategoripost_namalain;
                                }
                            },
                        ),
                        
                        array(
                            'name' => 'Gambar Kategori Berita',
                            'type' => 'raw',
                            'value' => 'CHtml::image(Params::urlKategoriBeritaGambar().$data->kategoripost_gambar,"", array("width"=>"120px","height"=>"110px"))',
                            'htmlOptions' => array('style' => 'text-align:center;'),
                            'headerHtmlOptions' => array('style' => 'color:#373e4a;vertical-align:top;text-align:center;'),
                            'filter' => false,
                        ),
                       
                        array(
                            'header' => 'Status',
                            'value' => '($data->kategoripost_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align:center;'),
                        ),
                        array(
                            'header' => Yii::t('zii', 'View'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{view}',
                        ),
                        array(
                            'header' => Yii::t('zii', 'Update'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{update}',
                        ),
                        array(
                            'header' => Yii::t('zii', 'Delete'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{remove} {delete}',
                            'deleteConfirmation' => 'Apakah Anda yakin ingin menghapus data ini ?',
                            'buttons' => array(
                                'remove' => array(
                                    'label' => "<i class='icon-remove'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/removeTemporary",array("id"=>$data->kategoripost_id))',
                                    'click' => 'function(){removeTemporary(this);return false;}',
                                ),
                                'delete' => array(),
                            )
                        ),
                    ), 'afterAjaxUpdate' => 'function(id, data){
                        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                        $("table").find("input[type=text]").each(function(){
                            cekForm(this);
                        })
                        $("table").find("select").each(function(){
                            cekForm(this);
                        })
                    }',
                ));
                ?>
            </div>
        </div>     

        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Tambah Kategori Berita', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . "&nbsp&nbsp";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
        $content = $this->renderPartial('../tips/master', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
        ?></div>
</div>  
<?php
$js = <<< JSCRIPT
        function cekForm(obj)
{
    $("#penilaian-indikator-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#penilaian-indikator-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
<script type="text/javascript">
    function removeTemporary(obj) {

        var url = $(obj).attr('href');
        myConfirm("Apakah Anda yakin ingin menonaktifkan data ini untuk sementara?", "Perhatian!", function (r) {
            if (r) {
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {},
                    dataType: "json",
                    success: function (data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('penilaianiki-indikator-m-grid');
                        } else {
                            myAlert('Data Gagal di Nonaktifkan.')
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        });
    }
</script>    








