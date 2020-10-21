<?php

namespace Drupal\factorial_tools;

/**
 * Some tools to add and modify translations.
 */
class TranslationTools {

  /**
   * Add a new translation or update an existing one.
   *
   * @param string $language
   *   The target language.
   * @param array $data
   *   Key-value array with source->translation mapping.
   * @param string $context
   *   Optional context.
   */
  public static function add($language, array $data, $context = NULL) {
    /** @var \Drupal\locale\StringStorageInterface $local_storage */
    $local_storage = \Drupal::service('locale.storage');

    foreach ($data as $source => $target) {
      $search = [
        'source' => $source,
      ];
      if ($context) {
        $search['context'] = $context;
      }

      $string = $local_storage->findString($search);
      if (!$string) {
        $string = $local_storage->createString($search)->save();
      }
      // Create translation for new string and save it as non-customized.
      if ($string) {
        $data = [
          'lid' => $string->lid,
          'language' => $language,
          'translation' => $target,
        ];
        if ($context) {
          $data['context'] = $context;
        }
        $translation = $local_storage->createTranslation($data)->save();
      }
    }
  }

}
