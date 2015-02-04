<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<?php $this->beginWidget('bootstrap.widgets.TbHeroUnit',array(
    'heading'=>'Welcome to '.CHtml::encode(Yii::app()->name),
)); ?>

<p>This is your control panel for manipulating which ads show up when News demonstrates CBSPhilly.com on air.</p>
<legend>Currently Active Client</legend>
<h3><?php echo $activeclient->name; ?></h3>
<p>Pencil Ad: </p>
<?php echo CHtml::image($activeclient->ad1->getFilepath(), $activeclient->ad1->filename, array('width'=>300,'height'=>180,'class'=>'thumbnail')); ?>
<p>Right Side Ad: </p>
<?php echo CHtml::image($activeclient->ad2->getFilepath(), $activeclient->ad2->filename, array('width'=>100,'height'=>100,'class'=>'thumbnail')); ?>
<p>Skin Ad: </p>
<?php echo CHtml::image($activeclient->ad3->getFilepath(), $activeclient->ad3->filename, array('width'=>100,'height'=>100,'class'=>'thumbnail')); ?>

<?php $this->endWidget(); ?>

<h1>All Clients</h1>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped bordered condensed',
    'dataProvider'=>$clientDataProvider,
    //'template'=>"{items}",
    'columns'=>array(
        
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'header'=>'Activate?', 
            'template'=>'{activate}',
                'buttons'=>array
                (
                    'activate' => array
                    (
                        'label'=>'Make Active',
                        'url'=>'Yii::app()->createUrl("client/makeactive", array("id"=>$data->id))',
                        'visible'=>'$data->active == 0',
                        'options'=>array(
                            'class'=>'btn btn-primary btn-mini'
                        )
                    ),
            'htmlOptions'=>array('style'=>'width: 150px'),
                ),
        ),
        array(
                'class'=>'CLinkColumn',
                'labelExpression'=>'$data->name',
                'header'=>'Client Name', 
                'urlExpression'=>'Yii::app()->createUrl("client/view", array("id"=>$data->id))',
                'htmlOptions'=>array('style'=>'width: 500px'),
            ),
        array(
            'name'=>'active', 
            'header'=>'Active',
            'value'=>'$data->active == 1 ? "Yes" : "No"',
            'htmlOptions'=>array('style'=>'width: 50px'),
            ),
        array(
            'name'=>'create_user_id', 
            'header'=>'Created By',
            'value'=>'$data->createUser->username',
            'htmlOptions'=>array('style'=>'width: 150px'),
            ),
    ),
)); ?>