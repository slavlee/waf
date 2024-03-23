<?php

declare(strict_types=1);

namespace Slavlee\Waf\Domain\Service;

/**
 * This file is part of the "waf" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Kevin Chileong Lee <support@slavlee.de>, Slavlee
 */

use Slavlee\Waf\Scanner\XssScanner;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Slavlee\Waf\Exception\RequestNotAllowedException;
use Slavlee\Waf\Scanner\SqlInjectionScanner;
use Slavlee\Waf\Scanner\CodeExecutionScanner;

class FrontendFirewall
{
    /**
     * ExtensionConfiguration
     * @var array
     */
    protected array $extConf = [];

    /**
     * @var ServerRequest
     */
    private ServerRequest $request;

    public function __construct(
        private readonly ExtensionConfiguration $extensionConfiguration,
        private readonly SqlInjectionScanner $sqlInjectionScanner,
        private readonly CodeExecutionScanner $codeExecutionScanner,
        private readonly XssScanner $xssScanner
    ) {
        $extConf = $this->extensionConfiguration->get('waf');

        if (\is_array($extConf) && \array_key_exists('firewall', $extConf)) {
            $this->extConf = $extConf['firewall']['frontend'];
            $this->sqlInjectionScanner->init($extConf['firewall']['sqlInjectionScanner']);
            $this->codeExecutionScanner->init($extConf['firewall']['codeExecutionScanner']);
            $this->xssScanner->init($extConf['firewall']['xssScanner']);
        }
    }


    /**
     * Handle a Request
     * @return void
     */
    public function handle(ServerRequest $request): void
    {
        $this->request = $request;

        if (empty ($this->extConf)) {
            return;
        }

        if (
            !$this->scanMethod() || !$this->scanUrlSegments()
            || !$this->sqlInjectionScanner->scanRequest()
            || !$this->codeExecutionScanner->scanRequest()
            || !$this->xssScanner->scanRequest()
        ) {
            throw new RequestNotAllowedException('Request not allowed', time());
        }
    }

    /**
     * Check if HTTP method is allowed
     * @return bool
     */
    private function scanMethod(): bool
    {
        return in_array($this->request->getMethod(), GeneralUtility::trimExplode(',', $this->extConf['allowedMethods'], true));
    }

    /**
     * Check if url path is allowed
     * @return bool
     */
    private function scanUrlSegments(): bool
    {
        $path = $this->request->getUri()->getPath();
        $invalidSegments = GeneralUtility::trimExplode(',', $this->extConf['disallowedFirstUrlSegments']);

        foreach ($invalidSegments as $invalidSegment) {
            if (\preg_match('/^\/' . $invalidSegment . '(\/.*)?$/', $path)) {
                return false;
            }
        }

        return true;
    }
}
