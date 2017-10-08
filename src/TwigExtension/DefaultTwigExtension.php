<?php

namespace Drupal\factorial_tools\TwigExtension;

use Drupal\Core\Template\TwigExtension;
use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;

/**
 * Class DefaultTwigExtension.
 *
 * @package Drupal\factorial_tools
 */
class DefaultTwigExtension extends \Twig_Extension {

  /**
   * {@inheritdoc}
   */
  public function getTokenParsers() {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function getNodeVisitors() {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function getFilters() {
    return [
      new \Twig_SimpleFilter('filtered', array($this, 'filterMarkup'), array('is_safe' => array('html'))),
      new \Twig_SimpleFilter('cacheOnly', array($this, 'cacheOnly'), array('is_safe' => array('html'))),
      new \Twig_SimpleFilter('imageStyleUrl', array($this, 'imageStyleUrl', array('is_safe' => array('html'))))
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function filterMarkup($string) {
    $string_validate = is_string($string) ? $string : render($string);
    $string_validate = check_markup($string_validate, 'limited_richtext');
    $string_validate = strip_tags($string_validate, '<a><br><em><strong>');
    return $string_validate;
  }

  /**
   * {@inheritdoc}
   */
  public static function cacheOnly($input) {
    if (is_array($input)) {
      return [
        '#markup' => '',
        '#cache' => isset($input['#cache']) ? $input['#cache'] : NULL,
      ];
    }
    // If it's not an array return the input unhandled.
    return $input;
  }

  public static function imageStyleUrl($file, $image_style_name) {
    if (!$file instanceof File) {
      return '';
    }
    $original_image = $file->get('uri')->value;
    $style = ImageStyle::load($image_style_name);  // Load the image style configuration entity.
    return $style->buildUrl($original_image);
  }


  /**
   * {@inheritdoc}
   */
  public function getTests() {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function getFunctions() {
    return [
      new \Twig_SimpleFunction('patternlab_path', function () {
        $theme = \Drupal::service('theme.manager')->getActiveTheme();
        return base_path() . $theme->getPath() . '/source';
      }),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getOperators() {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return 'factorial_tools.twig.extension';
  }

}
