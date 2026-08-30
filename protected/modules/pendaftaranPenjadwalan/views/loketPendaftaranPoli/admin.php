
<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Pengaturan <strong>Loket Pendaftaran Poli</strong></div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Loket Pendaftaran Poli' => array('admin'),
            'Pengaturan',
        );


        Yii::app()->clientScript->registerScript('search', "
                        $('.search-button').click(function(){
                                $('.search-form').toggle();
                                return false;
                        });
                        $('.search-form form').submit(function(){
                                $.fn.yiiGridView.update('sajenis-kelas-m-grid', {
                                        data: $(this).serialize()
                                });
                                return false;
                        });
                        ");

        $this->widget('bootstrap.widgets.BootAlert');
        ?>
<?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <p></p>
        <div class="cari-lanjut search-form" style="display:none; padding: 10px;">
            <?php
            $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            ));
            ?>
        </div><!-- search-form --><hr>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">Tabel <strong>Loket Pendaftaran Poli</strong></div>
            </div>
            <div class="panel-body" style="overflow-x: scroll">
                <div class="block-tabel">
                    <?= $this->renderPartial($this->path_view.'_table',['model'=>$model], true) ?>
                </div>
            </div>
        </div>
        <?php
                echo CHtml::link(Yii::t('mds', '{icon} Tambah Loket Pendaftaran Poli', array('{icon}'=>'<i class="entypo-folder"></i>')),
            $this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-danger')).'&nbsp;';
        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
        
        
        $content = $this->renderPartial($this->path_tips . 'master', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
        $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

        $js = <<< JSCRIPT
                        function cekForm(obj){
                                $("#sagolongan-m-search :input[name='"+ obj.name +"']").val(obj.value);
                        }
                        function print(caraPrint){
                                window.open("${urlPrint}/"+$('#sagolongan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
                        }
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
    </div>
</div>

<script type="text/javascript">
    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm("Apakah Anda yakin ingin menonaktifkan data ini untuk sementara?", "Perhatian!", function (r) {
            if (r) {
                $.post(url, {id: id},
                        function (data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('sajenis-kelas-m-grid');
                            } else {
                                myAlert('Data Gagal di Nonaktifkan')
                            }
                        }, "json");
            }
        });
    }
    
    function aktif(id) {
        var url = '<?php echo $url . "/aktif"; ?>';
        myConfirm("Apakah Anda yakin ingin meng-aktifkan data ini untuk sementara?", "Perhatian!", function (r) {
            if (r) {
                $.post(url, {id: id},
                        function (data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('sajenis-kelas-m-grid');
                            } else {
                                myAlert('Data Gagal di diaktifkan')
                            }
                        }, "json");
            }
        });
    }

    function deleteRecord(id) {
        var id = id;
        var url = '<?php echo $url . "/delete"; ?>';
        myConfirm("Apakah Anda yakin ingin menghapus data ini ?", "Perhatian!", function (r) {
            if (r) {
                $.post(url, {id: id},
                        function (data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('sajenis-kelas-m-grid');
                            } else if (data.status == 'gagal_form') {
                                myAlert('Maaf data ini tidak bisa dihapus dikarenakan digunakan pada table lain.')
                            } else {
                                myAlert('Data Gagal di Hapus')
                            }
                        }, "json");
            }
        });
    }
   
</script>