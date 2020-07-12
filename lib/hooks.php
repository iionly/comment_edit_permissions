<?php

/**
 * Allow comment owner, admins and group owners to edit (or delete) comments.
 *
 * @param string  $hook   'permissions_check'
 * @param string  $type   'object'
 * @param boolean $return Can the given user edit the given entity?
 * @param array   $params Array of parameters (entity, user)
 *
 * @return boolean Whether the given user is allowed to edit the given comment.
 */
function comment_edit_permissions_comments_permissions_override($hook, $type, $return, $params) {
	$entity = $params['entity'];
	// If not a comment return
	if (!($entity instanceof ElggComment)) {
		return $return;
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

/**
 * Allow discussion reply owner, admins and group owners to edit (or delete) discussion replies.
 *
 * @param string  $hook   'permissions_check'
 * @param string  $type   'object'
 * @param boolean $return
 * @param array   $params Array('entity' => ElggEntity, 'user' => ElggUser)
 * @return boolean Whether the given user is allowed to edit the given discussion reply.
 */
function comment_edit_permissions_discussion_can_edit_reply($hook, $type, $return, $params) {
	$entity = $params['entity'];
	// If not a discussion reply return
	if (!($entity instanceof ElggDiscussionReply)) {
		return $return;
	}

	$owner = $entity->getOwnerEntity();

	// First check if owner or admin is logged in for quick return if true
	if ($owner->canEdit()) {
		return true;
	}
	
	// Now check if discussion reply is in group and group owner is logged in
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

/**
 * Allow like annotation owner, owner of liked entity, admins and group owners to delete like annotations.
 *
 * @param string $hook   "permissions_check"
 * @param string $type   "annotation"
 * @param array  $return Current value
 * @param array  $params Hook parameters
 *
 * @return boolean Whether the given user is allowed to delete the given like annotation.
 */
function comment_edit_permissions_likes_permissions_check($hook, $type, $return, $params) {
	$annotation = $params['annotation'];
	// If no annotation or annotation is not a likenot a discussion reply return
	if (!$annotation || $annotation->name !== 'likes') {
		return $return;
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
