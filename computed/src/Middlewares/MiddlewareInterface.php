<?php
// Justin PHP Framework
// (c)2021 SuperSonic(https://randychen.tk)

namespace Slim\Middlewares;

use Slim\Kernel\Context;

interface MiddlewareInterface
{
    public static function toUse(Context $context): void;
}
