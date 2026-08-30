<?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'samenu-modul-k-grid',
    'dataProvider' => $modMenuModul->findMenuById(),
    // 'filter'=>$modMenuModul,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped datatable',
    'columns' => array(
        ////'menu_id',
        array(
            'name' => 'menu_id',
            'value' => '$data->menu_id',
            'filter' => false,
        ),
        //'kelmenu_id',
        array(
            'name' => 'modul_id',
            'value' => '$data->modulk->modul_nama',
        ),
        array(
            'name' => 'kelmenu_id',
            'value' => '$data->kelompokmenu->kelmenu_nama',
            'filter' => CHtml::dropDownList('SAMenuModulK[kelmenu_id]', $modMenuModul->kelmenu_id, CHtml::listData($modMenuModul->getKelompokMenuItems(), 'kelmenu_id', 'kelmenu_nama'), array('empty' => '-- Pilih --')),
        ),
        'menu_nama',
        [
            'header' => 'Tampil Pada Ruangan',
            'type' => 'raw',
            'value' => function ($data) {
                $menuRuangan = MenuruanganfarmasiK::model()->findAllByAttributes(['menu_id' => $data->menu_id]);
                $str = '<ul>';
                if(!empty($menuRuangan)) {
                    foreach ($menuRuangan as $key => $value) {
                        $ruangan = RuanganM::model()->findByPk($value->ruangan_id);
                        if(!empty($ruangan)) {
                            $str .= '<li>' . $ruangan->ruangan_nama . '</li>';
                        }
                    }
                }
                $str .= '</ul>';

                return $str;
            }
        ],
        array(
            'header' => 'Pilih Ruangan',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::link('<i class="icon-kelasruangan" style="font-size: 14pt"></i>', $this->createUrl('menuRuangan', ['menu_id' => $data->menu_id, 'menu_nama' => $data->menu_nama]), array());
            }
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