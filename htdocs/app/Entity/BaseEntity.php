<?php

namespace App\Entity;

use RuntimeException;

class BaseEntity
{
  protected function illegalAssignment(string $propety, $value)
  {
    throw new RuntimeException("Illegal assignment for article.$propety: $value");
  }
}
