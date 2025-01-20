<?php

namespace App\Service;

use App\Entity\Tip;

class TipService
{
  public function __construct(
    private readonly SlugService $slugService
  ) {}

  /**
   * Prepare a Tip entity before persisting it to the database.
   *
   * @param Tip $tip The tip entity to be prepared.
   */
  public function prepareTipForPersistence(Tip $tip): void
  {
    // Generate a slug based on the tip's title
    $tip->setSlug($this->slugService->generateSlug($tip->getTitle()));

    // Generate slugs for the tip's ingredients
    $this->slugService->generateIngredientsSlug($tip);

    // Set the default status of the tip to 'draft'
    $tip->setStatus('draft');

    // Set the creation date to the current timestamp
    $tip->setCreatedAt(new \DateTimeImmutable());
  }
}
