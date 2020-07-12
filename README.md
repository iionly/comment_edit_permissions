Comment Edit Permissions for Elgg 3.3 and newer Elgg 3.X
========================================================

Latest Version: 3.3.0  
Released: 2020-07-12  
Contact: iionly@gmx.de  
License: GNU General Public License version 2  
Copyright: (c) iionly 2017


Description
-----------

Defines custom edit/delete permissions for comments, discussion replies and likes.

New permissions:

- Comments: outside group context only the comment owner and admins are allowed to edit/delete a comment. Inside group context the group owner also has edit/delete permissions,
- Discussion replies: same as comments because discussion replies are handled as comments on Elgg 3,
- Likes: outside group context the like annotation owner, the owner of the entity the like was added to and admins are allowed to delete a like. Inside group context the group owner also has delete permission.


Installation
------------

1. If you have a previous version of the Comment Edit Permissions plugin installed, first disable the Comment Edit Permissions plugin on your site, then remove the comment_edit_permissions folder from the mod folder on your server before installing the new version,
2. Copy the comment_edit_permissions plugin folder into the mod folder on your server,
3. Enable the plugin in the admin section of your site.
