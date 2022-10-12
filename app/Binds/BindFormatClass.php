<?php

namespace Modules\Tenancy\Binds;

use Modules\Tenancy\Binds\Actions\BuildFormatAction;
use Modules\Tenancy\Binds\Interfaces\FileFormatInterface;

class BindFormatClass
{
  public string $path;
  public array $content;
  public string $target;
  public bool $beforeTarget;

  public function __construct(FileFormatInterface $format)
  {
    $this->content = (new BuildFormatAction)($format);
    $this->path = $format->getPath();
    $this->target = $format->getTarget();
    $this->beforeTarget = $format->beforeTarget();
  }
}
