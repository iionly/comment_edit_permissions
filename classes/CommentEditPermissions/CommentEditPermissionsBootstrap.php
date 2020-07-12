<?php

namespace CommentEditPermissions;

use Elgg\DefaultPluginBootstrap;

class CommentEditPermissionsBootstrap extends DefaultPluginBootstrap {

	public function init() {
		elgg_unregister_plugin_hook_handler('permissions_check', 'object', '_elgg_comments_permissions_override');
		elgg_register_plugin_hook_handler('permissions_check', 'object', 'comment_edit_permissions_comments_permissions_override');

		if (elgg_is_active_plugin('likes')) {
			elgg_unregister_plugin_hook_handler('permissions_check', 'annotation', 'likes_permissions_check');
			elgg_register_plugin_hook_handler('permissions_check', 'annotation', 'comment_edit_permissions_likes_permissions_check');
		}
	}
}
