<?php

namespace Drupal\factorial_tools\TwigExtension;

use Twig\TwigFunction;
use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;
use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;

/**
 * Class DefaultTwigExtension.
 *
 * @package Drupal\factorial_tools
 */
class DefaultTwigExtension extends AbstractExtension {

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
      new TwigFilter('filtered', [$this, 'filterMarkup'], ['is_safe' => ['html']]),
      new TwigFilter('cacheOnly', [$this, 'cacheOnly'], ['is_safe' => ['html']]),
      new TwigFilter('imageStyleUrl', [$this, 'imageStyleUrl', ['is_safe' => ['html']]]),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function filterMarkup($string) {
    $renderer = \Drupal::service('renderer');
    $string_validate = is_string($string) ? $string : $renderer->render($string);
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

  /**
   *
   */
  public static function imageStyleUrl($file, $image_style_name) {
    if (!$file instanceof File) {
      return '';
    }
    $original_image = $file->get('uri')->value;
    // Load the image style configuration entity.
    $style = ImageStyle::load($image_style_name);
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
      new TwigFunction('patternlab_path', function () {
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
