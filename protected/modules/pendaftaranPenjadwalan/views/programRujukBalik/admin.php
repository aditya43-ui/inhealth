<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Pengaturan <strong>Program Rujuk Balik</strong></div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Program Rujuk Balik' => array('admin'),
            'Pengaturan',
        );


        Yii::app()->clientScript->registerScript('search', "
                        $('.search-button').click(function(){
                                $('.search-form').toggle();
                                return false;
                        });
                        $('#searchLaporan').submit(function(){
                                $.fn.yiiGridView.update('sajenis-kelas-m-grid', {
                                        data: $(this).serialize()
                                });
                                return false;
                        });
                        ");

        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Pencarian</div>
            </div>
            <div class="panel-body">
                <?php
                echo $this->renderPartial('_search', array(
                    'model' => $model,
                ), true);
                ?>
            </div>
        </div><!-- search-form --><br />
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">Tabel <strong>Data Program Rujuk Balik</strong></div>
            </div>
            <div class="panel-body" style="overflow-x: scroll">
                <div class="block-tabel">
                    <?= $this->renderPartial('_table', ['model' => $model], true) ?>
                </div>
            </div>
        </div>
        <?php
        echo CHtml::link(
            Yii::t('mds', '{icon} Tambah Program Rujuk Balik', array('{icon}' => '<i class="entypo-folder"></i>')),
            $this->createUrl('tambah', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-danger')
        ) . '&nbsp;';
        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";

        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
        $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

        $js = <<< JSCRIPT
                        function cekForm(obj){
                                $("#sagolongan-m-search :input[name='"+ obj.name +"']").val(obj.value);
                        }
                        function print(caraPrint){
                                window.open("${urlPrint}/"+$('#searchLaporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
                        }
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
    </div>
</div>