<style type="text/css">
    .text-center{
        text-align: center !important;
    }
    .font-bold{
        font-weight: bold;
        color: black;
    }
</style>

<div class="row-fluid">
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"><strong>Early Warning Score Pasien</strong></div>
        </div> 
        <div class="panel-body">
            <?php 
                        $this->breadcrumbs=array(
            'Daftar Pasien' => Yii::app()->request->urlReferrer,
                                'Early Warning Score',
                        );
            ?>
            <?php 
                if(empty($_GET['frame'])){
                    $this->renderPartial($this->path_view.'_dataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien));
                }
            ?>
            
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Tabel Riwayat <strong>Early Warning Score</strong></div>
                </div>
                <div class="panel-body" style="overflow-x: auto; max-width: 100%;">
                    <div class="block-tabel">
                            <?php $this->renderPartial($this->path_view.'_riwayatTableEws',array('model'=>$model)) ?>
                    </div>
                </div>
            </div>
            
            <div class="panel panel-gradient panel-shadow">
                <div class="panel-heading">
                    <div class="panel-title"><strong><i>Early Warning Score</i></strong></div>
                </div>
                <div class="panel-body" style="overflow-x: auto; max-width: 100%;">
                    <div class="block-tabel">
                        <?php $this->renderPartial($this->path_view.'_form',array('model'=>$model,'modDetail'=>$modDetail,'modPasien'=>$modPasien)) ?>
                    </div>
                </div>
            </div>
            <?php $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model,'modDetail'=>$modDetail)); ?>
        </div>
    </div>
</div>