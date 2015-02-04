<?php
    abstract class MyActiveRecord extends CActiveRecord
    {
        /**
        * Prepares create_user_id and update_user_id attributes before saving
        */
        protected function beforeSave()
        {
            if(null !== Yii::app()->user)
                $id=Yii::app()->user->id;
            else
                $id=1;
            
            if($this->isNewRecord)
                $this->create_user_id=$id;
                
            $this->update_user_id=$id;
            
            return parent::beforeSave();
        }
        
        /**
        * Attaches the timestamp behavior to update our create and update times
        */
        public function behaviors()
        {
            return array(
                'CTimestampBehavior' => array(
                    'class' => 'zii.behaviors.CTimestampBehavior',
                    'createAttribute' => 'create_time',
                    'updateAttribute' => 'update_time',
                    'setUpdateOnCreate' => true,
                ),
            );
        }
        
        public function formatTime($time)
        {
	    return Yii::app()->dateFormatter->formatDateTime(strtotime($time), 'medium', 'medium');
        }
        
        public function formatDate($date)
        {
	    return Yii::app()->dateFormatter->formatDateTime(strtotime($date), 'medium', '');
        }
        
        /** 
        * 
        * @ Param Criteria $ CDbCriteria 
        * @ Return CActiveDataProvider 
        */ 
       public function getDataProvider($criteria=null, $pagination=null) {
           if ((is_array ($criteria)) || ($criteria instanceof CDbCriteria) )
              $this->getDbCriteria()->mergeWith($criteria);
           $pagination = CMap::mergeArray(array('pageSize' => 10),(array)$pagination); 
           return new CActiveDataProvider(__CLASS__, array(
                           'criteria'=>$this->getDbCriteria(),
                           'pagination' => $pagination
           ));
       }
    }