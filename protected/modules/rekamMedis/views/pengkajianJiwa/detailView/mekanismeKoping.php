<?php

$ceklis = '<span class="fa fa-check-square-o"></span>';
$unceklis = '<span class="fa fa-square-o"></span>';

?>

<div class="panel panel-success panel_detail" id='panel_9'>
    <div class="panel-heading">
        <div class="panel-title">Mekanisme Koping</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class='col-sm-6'>
                <div>
                    <div class="label_d">Adatif</div>
                    <div class="kolon_d">:</div>
                    <div class="body_d">
                        <?php 
                        $koping = LookupM::getItemsUrutan('askepjiwa_kopingadatif');
                        $data_koping = empty($model->koping_adatif) ? array() : CJSON::decode($model->koping_adatif);

                        foreach ($koping as $val => $label): 
                            echo '<div>';
                            echo in_array($val, $data_koping) ? $ceklis : $unceklis;
                            echo " ".$label."  ";
                            echo '</div>';
                        endforeach; ?>
                    </div>
                </div>
            </div>
            <div class='col-sm-6'>
                <div>
                    <div class="label_d">Maladatif</div>
                    <div class="kolon_d">:</div>
                    <div class="body_d">
                        <?php 
                        $koping = LookupM::getItemsUrutan('askepjiwa_kopingmaladatif');
                        $data_koping = empty($model->koping_maladatif) ? array() : CJSON::decode($model->koping_maladatif);

                        foreach ($koping as $val => $label): 
                            echo '<div>';
                            echo in_array($val, $data_koping) ? $ceklis : $unceklis;
                            echo " ".$label."  ";
                            echo '</div>';
                        endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>