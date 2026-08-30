<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Bank Penerimaan / Pengeluaran RS</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Bank' => Yii::app()->request->getUrlReferrer(),
            'Lihat',
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Bank', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Bank', 'icon' => 'folder-open', 'url' => array('admin'))) :  '';

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'label' => 'Nama Bank',
                    'value' => $model->namabank,
                ),
                array(
                    'label' => 'No. Rekening',
                    'value' => $model->norekening,
                ),
                array(
                    'label' => 'Mata Uang',
                    'value' => !empty($model->matauang->matauang) ? $model->matauang->matauang : '-',
                ),
                array(
                    'label' => 'Provinsi',
                    'value' => !empty($model->propinsi->propinsi_nama) ? $model->propinsi->propinsi_nama : '-',
                ),
                array(
                    'label' => 'Kabupaten',
                    'value' => !empty($model->kabupaten->kabupaten_nama) ? $model->kabupaten->kabupaten_nama : '-',
                ),
                array(
                    'label' => 'Alamat Bank',
                    'value' => $model->alamatbank,
                ),
                array(
                    'label' => 'Telp Bank 1 / 2',
                    'value' => $model->telpbank1 . " / " . $model->telpbank2,
                ),
                array(
                    'label' => 'Fax Bank/<br>Kode Pos',
                    'value' => $model->faxbank . " / " . $model->kodepos,
                ),
                array(
                    'label' => 'Email/<br>Website',
                    'value' =>  $model->emailbank . " / " . $model->website,
                ),
                array(
                    'label' => 'Cabang dari/<br>Negara',
                    'value' => $model->cabangdari . " / " . $model->negara,
                ),
                //                    array(
                //                             'label'=>'Rekening Debit',
                //                             'type'=>'raw',
                //                             'value'=>$this->renderPartial($this->path_view. '_viewDebit',array('bank_id'=>$model->bank_id,'saldonormal'=>"D"),true),
                //                     ),
                //                     array(
                //                             'label'=>'Rekening Kredit',
                //                             'type'=>'raw',
                //                             'value'=>$this->renderPartial($this->path_view. '_viewKredit',array('bank_id'=>$model->bank_id,'saldonormal'=>"K"),true),
                //                     ),

            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Bank Penerimaan / Pengeluaran RS', array('{icon}' => '<i class="' . MyIcon::getIcons('pengaturan') . '"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-danger',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>