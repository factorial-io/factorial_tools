# Entity Delete

!!! note
    These function are compatible with [hook_update_N()](https://api.drupal.org/api/drupal/core%21lib%21Drupal%21Core%21Extension%21module.api.php/function/hook_update_N/8.2.x).

## factorial_tools_entities_delete()

To delete all entities of particular type use `factorial_tools_entities_delete()`

### Examples

```
<?php

/**
 * Delete all nodes.
 */
function mysite_deploy_update_8001(&$sandbox) {
  return factorial_tools_entities_delete($sandbox, 'node');
}

/**
 * Delete all published nodes of type article.
 */
function mysite_deploy_update_8002(&$sandbox) {
  $conditions = [
   ['status', 1],
   ['type', 'article'],
  ];
  return factorial_tools_entities_delete($sandbox, 'node', $conditions);
}

/**
 * Delete all users except uid 0 and uid 1.
 */
function mysite_deploy_update_8003(&$sandbox) {
  $conditions = [
   ['uid', [0,1], 'NOT IN'],
  ];
  return factorial_tools_entities_delete($sandbox, 'user', $conditions);
}
```

## factorial_tools_entities_delete_by_query()

Optionally we have a helper function to delete entities by providing a [Drupal::entityQuery](https://api.drupal.org/api/drupal/core%21lib%21Drupal.php/function/Drupal%3A%3AentityQuery/8.2.x).

### Examples

```
<?php

/**
 * Delete all users except Anonymous and Super Admin.
 */
function mysite_deploy_update_8004(&$sandbox) {
  $query = \Drupal::entityQuery('user');
  $query->condition('uid', [0,1], 'NOT IN');
  return factorial_tools_entities_delete_by_query($sandbox, $query);
}
```


