<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class SAJenisKasusPenyakitM extends JeniskasuspenyakitM
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InstalasiM the static model class
     */
	public $ruangan_id;
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
	
	public function getItems(){
		$criteria = new CDbCriteria();
		$criteria->addCondition('jeniskasuspenyakit_aktif = TRUE');
		$criteria->order = 'jeniskasuspenyakit_nama ASC';
		$model = $this->model()->findAll($criteria);
		if(count((array)$model) > 0){
			return $model;
		}else{
			return array();
		}
	}
	
}
?>
