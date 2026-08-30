<?php

class SAPengumuman extends Pengumuman
{
        const STATUS_DRAFT=0;
	const STATUS_PUBLISH=1;
	const STATUS_ARSIP=2;
        public $status = array(0 =>'Draft',1 =>'Publish',2 =>'Arsip');
        public $nama_pemakai;
		
        public function daftarStatus()
        {
            return $this->status;
        }
        
        public function getStatusPublish()
        {
            return $this->status[$this->status_publish];
        }
        
        public function scopes() {
            return array(
                'published'=>array(
                      'condition'=>'status_publish='.self::STATUS_PUBLISH,
                ),
                'recently'=>array(
                      'order'=>'create_time DESC',
                      'limit'=>5,
                ),
            );
        }
		public function searchTabel()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = "t.*, loginpemakai_k.*";
		$criteria->join = "JOIN loginpemakai_k ON loginpemakai_k.loginpemakai_id = t.create_loginpemakai_id";
		$criteria->compare('LOWER(loginpemakai_k.nama_pemakai)',strtolower($this->nama_pemakai),true);
		$criteria->compare('pengumuman_id',$this->pengumuman_id);
		$criteria->compare('LOWER(judul)',strtolower($this->judul),true);
		$criteria->compare('LOWER(isi)',strtolower($this->isi),true);
		$criteria->compare('status_publish',$this->status_publish);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('publish_loginpemakai_id',$this->publish_loginpemakai_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Pengumuman the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}