<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->username,
);

$this->widget('ext.timeago.JTimeAgo', array(
    'selector' => ' .timeago',
));

$this->menu=array(
	array('label'=>'List User','url'=>array('index')),
	array('label'=>'Create User','url'=>array('create')),
	array('label'=>'Update User','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete User','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage User','url'=>array('admin')),
);
?>

<h1><?php echo $model->username; ?></h1>

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
                        'name'=>$model->getAttributeLabel('last_login_time'),
                        'type'=>'html',
                        'value'=>' <abbr class=\'timeago\' rel="tooltip" title=\''.$model->last_login_time.'\'>'.$model->formatTime($model->last_login_time).'</abbr>',
                ),
                array(
                        'name'=>$model->getAttributeLabel('status'),
                        'value'=>$model->status == 1 ? 'Active' : 'Locked Out',
                ),
	),
)); ?>
