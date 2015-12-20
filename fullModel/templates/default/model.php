<?php
/**
 * This is the template for generating the model class of a specified table.
 * In addition to the default model Code, this adds the GtcSaveRelationsBehavior
 * to the model class definition.
 * - $this: the ModelCode object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name=>CDbColumnSchema)
 * - $labels: list of attribute labels (name=>label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 */
?>
<?php echo "<?php\n"; ?>

// auto-loading
Yii::setPathOfAlias('<?php echo $modelClass; ?>', dirname(__FILE__));
Yii::import('<?php echo $modelClass; ?>.*');

class <?php echo $modelClass; ?> extends <?php echo 'Base' . $modelClass."\n"; ?>
{

    static $listData = false;

    // Add your model-specific methods here. This file will not be overriden by gtc except you force it.
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function init()
    {
        return parent::init();
    }

    public function getItemLabel()
    {
        return parent::getItemLabel();
    }

    static public function getListData(){
        if(self::$listData){
            return self::$listData;
        }
        $findCriteria = [
            // 'condition' => " ... ",
            'limit' => 1000,
            //'order' => 'velchile_code'
        ];
        self::$listData = CHtml::listData(self::model()->findAll($findCriteria), 'id', 'itemLabel');
        
        return self::$listData;
    }    
    
    static public function getItemLabelById($id){
        $listData = self::getListData();
        if(!isset($listData[$id])){
            return null;
        }
        return $listData[$id];
    }    
    
    public function behaviors()
    {
        <?php
        $behaviors = 'return array_merge(
            parent::behaviors(),
            array()
        );';
        echo $behaviors."\n";
        ?>
    }

    public function rules()
    {
        return array_merge(
            parent::rules()
        /* , array(
          array('column1, column2', 'rule1'),
          array('column3', 'rule2'),
          ) */
        );
    }

    public function search($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }
        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $this->searchCriteria($criteria),
            'pagination' => array('pageSize' => 25),
           // 'sort'=>array(
           //     'defaultOrder'=>'id DESC',
           // ),                        
        ));
    }

<?php
    if(!isset($columns['deleted'])){
?>

    public function delete() {
    
        /**
        * delete related records
        */
        foreach ($this->relations() as $relName => $relation) {
            if ($relation[0] != self::HAS_MANY && $relation[0] != self::HAS_ONE) {
                continue;
            }
            foreach ($this->$relName as $relRecord)
                $relRecord->delete();
        }
        return parent::delete();
    }
    
    public function canDelete() {
    
        /**
        * check relations
        */
        foreach ($this->relations() as $relName => $relation) {
            if ($relation[0] != self::HAS_MANY && $relation[0] != self::HAS_ONE) {
                continue;
            }

            /**
             * exist related record
             */
            foreach ($this->$relName as $relRecord)
                return false;
        }
        return true;
    }    
<?php
    }
?>

}
