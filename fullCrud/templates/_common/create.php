<?php
$label = $this->pluralize($this->class2name($this->modelClass));
?><?=
"<?php
\$this->setPageTitle(
    Yii::t('{$this->messageCatalog}', '{$this->class2name($this->modelClass)}')
    . ' - '
    . Yii::t('{$this->messageCatalog}', 'Create')
);

\$this->breadcrumbs[Yii::t('" . $this->messageCatalog . "', '$label')] = array('admin');
\$this->breadcrumbs[] = Yii::t('" . $this->messageCatalog . "', 'Create');
?>";
?>

<?= '<?php $this->widget("TbBreadcrumbs", array("links" => $this->breadcrumbs)) ?>'; ?>

    <h1>
        <?=
        "<?php echo Yii::t('" . $this->messageCatalog . "', '" . $this->class2name($this->modelClass) . "'); ?>
        <small><?php echo Yii::t('" . $this->messageCatalog . "', 'Create'); ?></small>

    ";
    ?></h1>

<?= '<?php $this->renderPartial("_toolbar", array("model" => $model)); ?>'; ?>

<?=
"<?php \$this->renderPartial('_form', array('model' => \$model, 'buttons' => 'create')); ?>";
?>