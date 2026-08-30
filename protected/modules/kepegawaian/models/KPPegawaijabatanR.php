<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class KPPegawaijabatanR extends PegawaijabatanR {

    public static function model($className = __CLASS__) {
        parent::model($className);
    }
	
	public function searchInfo($pegawai = null)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
		if(!empty($pegawai)){
		$criteria->addCondition('pegawai_id = '.$pegawai);
		}
		if(!empty($this->pegawaijabatan_id)){
		$criteria->addCondition('pegawaijabatan_id = '.$this->pegawaijabatan_id);
		}
		$criteria->compare('LOWER(tmtjabatan)',strtolower($this->tmtjabatan),true);
		$criteria->compare('LOWER(tglakhirjabatan)',strtolower($this->tglakhirjabatan),true);
		$criteria->compare('LOWER(nomorkeputusanjabatan)',strtolower($this->nomorkeputusanjabatan),true);
		$criteria->compare('DATE(tglditetapkanjabatan)',$this->tglditetapkanjabatan);
		$criteria->compare('LOWER(pejabatygmemjabatan)',strtolower($this->pejabatygmemjabatan),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->order='pegawaijabatan_id';
		$criteria->limit=5; 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}

?>
