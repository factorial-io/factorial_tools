# factorial_tools
Drupal Module that provides various commonly used helper functions

Usage# 

To delete all entities of particular typ e use `factorial_tools_entities_delete()`
Example:
```php
/**
 * Delete all nodes.
 */
function mysite_deploy_update_8001(&$sandbox) {
  return factorial_tools_entities_delete($sandbox, 'node');
}

```
