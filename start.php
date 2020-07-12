<?php

require_once(dirname(__FILE__) . '/lib/hooks.php');

elgg_register_event_handler('init', 'system', 'comment_edit_permissions_init');

function comment_edit_permissions_init() {
	elgg_unregister_plugin_hook_handler('permissions_check', 'object', '_elgg_comments_permissions_override');
	elgg_register_plugin_hook_handler('permissions_check', 'object', 'comment_edit_permissions_comments_permissions_override');

	if (elgg_is_active_plugin('discussions')) {
		elgg_unregister_plugin_hook_handler('permissions_check', 'object', 'discussion_can_edit_reply');
		elgg_register_plugin_hook_handler('permissions_check', 'object', 'comment_edit_permissions_discussion_can_edit_reply');
	}

	if (elgg_is_active_plugin('likes')) {
		elgg_unregister_plugin_hook_handler('permissions_check', 'annotation', 'likes_permissions_check');
		elgg_register_plugin_hook_handler('permissions_check', 'annotation', 'comment_edit_permissions_likes_permissions_check');
	}
}
