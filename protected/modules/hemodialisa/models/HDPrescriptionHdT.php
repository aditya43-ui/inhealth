<?php

class HDPrescriptionHdT extends PrescriptionHdT{
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public static function simpan_data($model, $post, $pendaftaran_id, $modPendaftaran, $modPasien){
        $model->pendaftaran_id = $pendaftaran_id;
        $model->pegawai_id = $modPendaftaran->pegawai_id;
        $model->pasien_id = $modPasien->pasien_id;
        $model->waktu_prescription = MyFormatter::formatDateTimeForDb($_POST['HDPrescriptionHdT']['waktu_prescription']);
        if(isset($_POST['HDPrescriptionHdT']['prescription_dokter'])){
            if($_POST['HDPrescriptionHdT']['prescription_dokter'] == 'akut'){
                $model->prescription_dokter_akut = true;
                $model->prescription_dokter_kronis = 0;
                $model->prescription_dokter_pirrt = 0;
            }elseif($_POST['HDPrescriptionHdT']['prescription_dokter'] == 'kronis'){
                $model->prescription_dokter_akut = 0;
                $model->prescription_dokter_kronis = true;
                $model->prescription_dokter_pirrt = 0;
            }elseif($_POST['HDPrescriptionHdT']['prescription_dokter'] == 'pirrt'){
                $model->prescription_dokter_akut = 0;
                $model->prescription_dokter_kronis = 0;
                $model->prescription_dokter_pirrt = true;
            }
        }else{
            $model->prescription_dokter_akut = 0;
            $model->prescription_dokter_kronis = 0;
            $model->prescription_dokter_pirrt = true;
        }

        $model->create_time = date('Y-m-d');
        $model->create_loginpmakai_id = Yii::app()->user->id;
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->save();
        
        return $model;
    }
}

