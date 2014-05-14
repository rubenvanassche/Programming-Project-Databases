<?php
$user = new User;
if(UserGroup::isMember($user->ID(), $usergroup_id)) {
	echo Form::open(array('url' => 'usergroup/'.$usergroup_id.'/invite'));
	echo Form::text('invitee_name', Input::old('invitee_name'), array('class'=>'form-control'));
	echo Form::submit('Invite User', array('class'=>'btn btn-success form-control'));
	echo Form::token() . Form::close();
}else{
	echo "<p>You're not a member of this group!</p>";
}
?>