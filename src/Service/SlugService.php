<?php

namespace App\Service;

use App\Entity\Tip;

class SlugService
{
  /**
   * Generate a URL-friendly slug from a given text.
   *
   * @param string $text The input text to be converted.
   * @return string The generated slug.
   */
  public function generateSlug(string $text): string
  {
    // Convert accented characters to their ASCII equivalents
    $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);

    // Replace any non-alphanumeric characters (except dashes) with a dash
    $text = preg_replace('/[^a-zA-Z0-9-]+/', '-', $text);

    // Remove leading and trailing dashes and convert to lowercase
    return strtolower(trim($text, '-'));
  }

  /**
   * Generate slugs for all ingredients of a given Tip entity.
   *
   * @param Tip $tip The tip entity containing ingredients.
   */
  public function generateIngredientsSlug(Tip $tip): void
  {
    foreach ($tip->getQuantities() as $quantity) {
      $ingredient = $quantity->getIngredient();
      $ingredient->setSlug($this->generateSlug($ingredient->getName()));
    }
  }
}
