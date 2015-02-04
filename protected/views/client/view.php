<?php
$this->breadcrumbs=array(
	'Clients'=>array('index'),
	$model->name,
);

$this->widget('ext.timeago.JTimeAgo', array(
    'selector' => ' .timeago',
));

$this->menu=array(
	array('label'=>'List Client','url'=>array('index')),
	array('label'=>'Create Client','url'=>array('create')),
	array('label'=>'Update Client','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Client','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Client','url'=>array('admin')),
);
?>

<h1><?php echo $model->name; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		array(
                        'name'=>$model->getAttributeLabel('create_time'),
                        'type'=>'html',
                        'value'=>' <abbr class=\'timeago\' rel="tooltip" title=\''.$model->create_time.'\'>'.$model->formatTime($model->create_time).'</abbr>',
                ),
		array(
			'name'=>$model->getAttributeLabel('create_user_id'),
                        'type'=>'raw',
			'value'=>CHtml::link(CHtml::encode($model->createUser->username),
                                            array('user/view','id'=>$model->createUser->id)),
		    ),
		array(
			'name'=>$model->getAttributeLabel('update_time'),
                        'type'=>'html',
                        'value'=>' <abbr class=\'timeago\' rel="tooltip" title=\''.$model->update_time.'\'>'.$model->formatTime($model->update_time).'</abbr>',
			'visible'=>($model->update_time == $model->create_time ? false : true),
		    ),
                array(
                        'name'=>$model->getAttributeLabel('update_user_id'),
                        'type'=>'raw',
                        'value'=>CHtml::link(CHtml::encode($model->updateUser->username),
                                            array('user/view','id'=>$model->updateUser->id)),
                        'visible'=> ($model->update_time == $model->create_time ? false : true),
                    ),
                array(
                        'name'=>$model->getAttributeLabel('Active'),
                        'value'=>$model->active == 1 ? 'Yes' : 'No',
                ),
	),
)); ?>


<?php if(empty($model->ad_1))
{
        $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>'Add 977x66 Ad',
            'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            //'size'=>'small', // null, 'large', 'small' or 'mini'
                'url'=>array('upload/create','id'=>$model->id,'column'=>'ad_1'),
        )); 
} else {
    $imageUrl = CHtml::image($model->ad1->getFilepath(), $model->ad1->filename, array('width'=>700,'height'=>180,'class'=>'thumbnail'));
                    echo CHtml::link($imageUrl, array('upload/view', 'id'=>$model->ad1->id));
    echo '<div class="btn-toolbar">';
    $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>'Replace Ad',
            'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            //'size'=>'small', // null, 'large', 'small' or 'mini'
                'url'=>array('upload/replace','id'=>$model->id,'column'=>'ad_1','uid'=>$model->ad1->id),
        ));
    echo '</div>';
}
        ?>
<hr>
<?php if(empty($model->ad_2))
{
        $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>'Add 300x250 Ad',
            'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            //'size'=>'small', // null, 'large', 'small' or 'mini'
                'url'=>array('upload/create','id'=>$model->id,'column'=>'ad_2'),
        )); 
} else {
    $imageUrl = CHtml::image($model->ad2->getFilepath(), $model->ad2->filename, array('width'=>300,'height'=>250,'class'=>'thumbnail'));
                    echo CHtml::link($imageUrl, array('upload/view', 'id'=>$model->ad2->id));
                     echo '<div class="btn-toolbar">';
    $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>'Replace Ad',
            'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            //'size'=>'small', // null, 'large', 'small' or 'mini'
                'url'=>array('upload/replace','id'=>$model->id,'column'=>'ad_2', 'uid'=>$model->ad2->id),
        ));
    echo '</div>';
}
?>
<hr>
<?php if(empty($model->ad_3))
{
        $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>'Add Skin Ad',
            'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            //'size'=>'small', // null, 'large', 'small' or 'mini'
                'url'=>array('upload/create','id'=>$model->id,'column'=>'ad_3'),
        )); 
} else {
    $imageUrl = CHtml::image($model->ad3->getFilepath(), $model->ad3->filename, array('width'=>700,'height'=>480,'class'=>'thumbnail'));
                    echo CHtml::link($imageUrl, array('upload/view', 'id'=>$model->ad3->id));
    echo '<div class="btn-toolbar">';
    $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>'Replace Ad',
            'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            //'size'=>'small', // null, 'large', 'small' or 'mini'
                'url'=>array('upload/replace','id'=>$model->id,'column'=>'ad_3','uid'=>$model->ad3->id),
        ));
    $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>'Use Generic Skin',
            'type'=>'info', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            //'size'=>'small', // null, 'large', 'small' or 'mini'
                'url'=>array('upload/generic','uid'=>$model->ad3->id),
        ));
    echo '</div>';
}
?>

<hr>
<?php if(empty($model->ad_4))
{
        $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>'Add 120x60 Ad',
            'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            //'size'=>'small', // null, 'large', 'small' or 'mini'
                'url'=>array('upload/create','id'=>$model->id,'column'=>'ad_4'),
        )); 
} else {
    $imageUrl = CHtml::image($model->ad4->getFilepath(), $model->ad4->filename, array('width'=>120,'height'=>60,'class'=>'thumbnail'));
                    echo CHtml::link($imageUrl, array('upload/view', 'id'=>$model->ad4->id));
    echo '<div class="btn-toolbar">';
    $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>'Replace Ad',
            'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            //'size'=>'small', // null, 'large', 'small' or 'mini'
                'url'=>array('upload/replace','id'=>$model->id,'column'=>'ad_4','uid'=>$model->ad4->id),
        ));
    $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>'Use Generic 120x60 Ad',
            'type'=>'info', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            //'size'=>'small', // null, 'large', 'small' or 'mini'
                'url'=>array('upload/blank','uid'=>$model->ad4->id),
        ));
    echo '</div>';
}
?>





