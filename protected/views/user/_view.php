<div class="view">

    <br />
      
    <h3><?php echo CHtml::link(CHtml::encode($data->username), array('view','id'=>$data->id)); ?></h3>

  <blockquote>
        
	<b><?php echo CHtml::encode($data->getAttributeLabel('last_login_time')); ?>:</b>
	<?php echo CHtml::encode($data->last_login_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->createUser->username); ?>
	<br />

  </blockquote>

</div>