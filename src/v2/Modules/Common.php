<?php

declare(strict_types=1);

namespace Feedex\Coinex\v2\Modules;

use Feedex\Contracts\Modules\CommonModuleInterface;

final class Common extends Module implements CommonModuleInterface
{
    /** @return array<string, mixed> */
    public function ping(): array
    {
        return $this->publicGet('/ping');
    }

    /** @return array<string, mixed> */
    public function time(): array
    {
        return $this->publicGet('/time');
    }

    /** @return array<string, mixed> */
    public function maintainInfo(): array
    {
        return $this->publicGet('/maintain/info');
    }
}
