<?php
declare(strict_types=1);

namespace Slavlee\Waf\Middleware;

/**
 * This file is part of the "waf" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Kevin Chileong Lee <support@slavlee.de>, Slavlee
 */

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slavlee\Waf\Exception\RequestNotAllowedException;

class FrontendFirewall implements MiddlewareInterface
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
        private readonly \Slavlee\Waf\Domain\Service\FrontendFirewall $firewall
    )
    {

    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $this->firewall->handle($request);
        }catch(RequestNotAllowedException $e) {
            $response = $this->responseFactory->createResponse()
                ->withHeader('Status', '403');
            return $response;
        }

        return $handler->handle($request);
    }
}
