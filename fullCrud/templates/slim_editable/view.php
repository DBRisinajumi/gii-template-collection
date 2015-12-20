<?php 
//add editable provider
$this->providers = ['gtc.fullCrud.providers.EditableProvider'];
?>
<?=
"<?php
    \$pageTitle = Yii::t('DdduModule.model', 'View {$this->class2name($this->modelClass)}');
    \$this->setPageTitle(\$pageTitle);    

" .    
'$cancel_buton = $this->widget("bootstrap.widgets.TbButton", array(
    #"label"=>Yii::t("' . $this->messageCatalogStandard . '","Cancel"),
    "icon"=>"chevron-left",
    "size"=>"large",
    "url"=>(isset($_GET["returnUrl"]))?$_GET["returnUrl"]:array("{$this->id}/admin"),
    "visible"=>(Yii::app()->user->checkAccess("' . $this->getRightsPrefix() . '.*") || Yii::app()->user->checkAccess("' . $this->getRightsPrefix() . '.View")),
    "htmlOptions"=>array(
                    "class"=>"search-button",
                    "data-toggle"=>"tooltip",
                    "title"=>Yii::t("' . $this->messageCatalogStandard . '","Back"),
                )
 ),true);
    
?>'    
?>

<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group"><?="<?php echo \$cancel_buton;?>"?></div>
        <div class="btn-group">
            <h1>
                <i class="<?=$this->icon;?>"></i>
                <?php  echo "<?php echo \$pageTitle;?>"?>
            </h1>
        </div>
        <div class="btn-group"><?php 
            $pk = CActiveRecord::model($this->modelClass)->tableSchema->primaryKey;
            echo '
            <?php
            
            $this->widget("bootstrap.widgets.TbButton", array(
                "label"=>Yii::t("' . $this->messageCatalogStandard . '","Delete"),
                "type"=>"danger",
                "icon"=>"icon-trash icon-white",
                "size"=>"large",
                "htmlOptions"=> array(
                    "submit"=>array("delete","' . $pk . '"=>$model->{$model->tableSchema->primaryKey}, "returnUrl"=>(Yii::app()->request->getParam("returnUrl"))?Yii::app()->request->getParam("returnUrl"):$this->createUrl("admin")),
                    "confirm"=>Yii::t("' . $this->messageCatalogStandard . '","Do you want to delete this item?")
                ),
                "visible"=> (Yii::app()->request->getParam("' . $pk . '")) && (Yii::app()->user->checkAccess("' . $this->getRightsPrefix() . '.*") || Yii::app()->user->checkAccess("' . $this->getRightsPrefix() . '.Delete"))
            ));
            ?>
';
        ?>
        </div>
    </div>
</div>

<?php
list($left_span,$right_span) = explode('-',$this->formLayout);
?>


<div class="row">
    <div class="<?= $left_span ?>">

        <?=
        "<?php
        \$this->widget(
            'TbDetailView',
            array(
                'data' => \$model,
                'attributes' => array(
        ";
        ?>
        <?php
        foreach ($this->tableSchema->columns as $column) {
            Yii::log(CJSON::encode($column));
            
            if($column->isPrimaryKey){
                continue;
            }            
           
            if ($this->provider()->skipColumn($this->modelClass, $column)) {
                continue;
            }
            echo $this->provider()->generateAttribute($this->model, $column);
        }
        ?>
        <?=
        "   ),
        )); ?>"?>

    </div>

<?php if ($this->formLayout == 'span12-span12'): ?>
    </div>
    <div class="row">
<?php endif; ?>

    <div class="<?= $right_span ?>">
        <?= "<?php \$this->renderPartial('_view-relations_grids',array('modelMain' => \$model, 'ajax' => false,)); ?>"; ?>
    </div>
</div>

<?= '<?php echo $cancel_buton; ?>'; ?>