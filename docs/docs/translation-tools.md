# Translation tools

!!! note
    These function are compatible with [hook_update_N()](https://api.drupal.org/api/drupal/core%21lib%21Drupal%21Core%21Extension%21module.api.php/function/hook_update_N/8.2.x).

## TranslationTools::add($language, $data, $context)

To add a translation for language `$language` to the database, use this function. `$data` is a key-value-array holding the source- and the target translation (original => translation). 

You can provide a `$context` to differentiate between different meanings (See the documentation of `t()` for more info.

### Examples

```
<?php

use Drupal\factorial_tools\TranslationTools;

/**
 * Update localization.
 */
function mysite_deploy_update_8001(&$sandbox) {
  TranslationTools::add('de', [
    'Please enter a valid email address' => 'Bitte geben Sie eine valide E-Mail-Adresse an',
  ]);
}
```