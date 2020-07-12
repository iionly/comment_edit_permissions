<?php

function comment_edit_permissions_comments_permissions_override(\Elgg\Hook $hook) {

	$returnvalue = $hook->getValue();
	$params = $hook->getParams();

	$entity = $params['entity'];
	// If not a comment return
	if (!($entity instanceof ElggComment)) {
		return $returnvalue;
	}

	$owner = $entity->getOwnerEntity();

	// First check if owner or admin is logged in for quick return if true
	if ($owner->canEdit()) {
		return true;
	}

	// Now check if comment is in group and group owner is logged in
	// Iterate until container entity is no longer an object entity
	$container = $entity->getContainerEntity();
	while ($container instanceof ElggObject) {
		$container = $container->getContainerEntity();
	}
	// Is container a group and the group owner is logged in?
	if (($container instanceof ElggGroup) && $container->canEdit()) {
		return true;
	}

	// No group owner available or unspecific case so no edit permissions
	return false;
}

function comment_edit_permissions_likes_permissions_check(\Elgg\Hook $hook) {

	$returnvalue = $hook->getValue();
	$params = $hook->getParams();

	$annotation = $params['annotation'];
	// If no annotation or annotation is not a likenot a discussion reply return
	if (!$annotation || $annotation->name !== 'likes') {
		return $returnvalue;
	}

	$user = $params['user'];
	$owner = $annotation->getOwnerEntity();
	// Get entity the like has been made to
	$liked_on = get_entity($annotation->entity_guid);

	// First check if owner, liked entity owner or admin is logged in for quick return if true
	if ($owner->canEdit() || ($liked_on->owner_guid == $user->guid)) {
		return true;
	}

	// Now check if like annotation is in group and group owner is logged in
	// Iterate until container entity is no longer an object entity
	$container = $liked_on->getContainerEntity();
	while ($container instanceof ElggObject) {
		$container = $container->getContainerEntity();
	}
	// Is container a group and the group owner is logged in?
	if (($container instanceof ElggGroup) && $container->canEdit()) {
		return true;
	}

	// No group owner available or unspecific case so no edit permissions
	return false;
}
