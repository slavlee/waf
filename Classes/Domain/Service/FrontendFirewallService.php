<?php

declare(strict_types=1);

namespace Slavlee\Waf\Domain\Service;

use Slavlee\Waf\Exception\RequestNotAllowedException;
use Slavlee\Waf\Scanner\CodeExecutionScanner;
use Slavlee\Waf\Scanner\RequestScanner;
use Slavlee\Waf\Scanner\SqlInjectionScanner;
use Slavlee\Waf\Scanner\XssScanner;
use Slavlee\Waf\Utility\TYPO3\Persistence\PersistenceUtility;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This file is part of the "waf" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Kevin Chileong Lee <support@slavlee.de>, Slavlee
 */
class FrontendFirewallService
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

    /**
     * Stack of keywords, why last request was blocked
     * @var array
     */
    private array $blockReasons = [];

    public function __construct(
        private readonly ExtensionConfiguration $extensionConfiguration,
        private readonly SqlInjectionScanner $sqlInjectionScanner,
        private readonly CodeExecutionScanner $codeExecutionScanner,
        private readonly XssScanner $xssScanner,
        private readonly LogService $logService
    ) {
        $this->extConf = $this->extensionConfiguration->get('waf');

        if (\is_array($this->extConf) && \array_key_exists('firewall', $this->extConf)) {
            $this->sqlInjectionScanner->init($this->extConf['firewall']['sqlInjectionScanner']);
            $this->codeExecutionScanner->init($this->extConf['firewall']['codeExecutionScanner']);
            $this->xssScanner->init($this->extConf['firewall']['xssScanner']);
        }
    }

    /**
     * Handle a Request
     */
    public function handle(ServerRequest $request): void
    {
        $this->request = $request;
        $this->reset();

        if (empty($this->extConf)) {
            return;
        }

        if (
            !$this->scanMethod() || !$this->scanUrlSegments()
            || !$this->sqlInjectionScanner->scanRequest()
            || !$this->codeExecutionScanner->scanRequest()
            || !$this->xssScanner->scanRequest()
        ) {
            if ($this->extConf['log']['logOnBlockedRequest']) {
                $this->collectBlockReasons();
                $this->logService->logIfRequestBlocked($request, $this->blockReasons);
                PersistenceUtility::persistAll();
            }

            throw new RequestNotAllowedException('Request not allowed', time());
        }
    }

    /**
     * Reset the Firewall Service
     */
    public function reset(): void
    {
        $this->blockReasons = [];
    }

    /**
     * Collect all block reasons
     */
    protected function collectBlockReasons()
    {
        $this->mergeBlockReasons($this->sqlInjectionScanner);
        $this->mergeBlockReasons($this->codeExecutionScanner);
        $this->mergeBlockReasons($this->xssScanner);
    }

    /**
     * Check if HTTP method is allowed
     * @return bool
     */
    private function scanMethod(): bool
    {
        $validRequest = in_array($this->request->getMethod(), GeneralUtility::trimExplode(',', $this->extConf['firewall']['frontend']['allowedMethods'], true));

        if (!$validRequest) {
            $this->blockReasons[] = [
                'func' => 'scanMethod',
                'reason' => 'method not allowed',
            ];
        }

        return $validRequest;
    }

    /**
     * Check if url path is allowed
     * @return bool
     */
    private function scanUrlSegments(): bool
    {
        $path = $this->request->getUri()->getPath();
        $invalidSegments = GeneralUtility::trimExplode(',', $this->extConf['firewall']['frontend']['disallowedFirstUrlSegments']);

        foreach ($invalidSegments as $invalidSegment) {
            if (\preg_match('/^\/' . $invalidSegment . '(\/.*)?$/', $path)) {
                $this->blockReasons[] = [
                    'func' => 'scanUrlSegments',
                    'reason' => $path,
                ];
                return false;
            }
        }

        return true;
    }

    /**
     * Merge incoming block reasons from RequestScannerResultObject
     * with class $this->blockReasons
     * @param RequestScanner $requestScanner
     */
    private function mergeBlockReasons(RequestScanner $requestScanner): void
    {
        $resultObject = $requestScanner->getResultObject();

        if ($resultObject && !$resultObject->isEmpty()) {
            $resultObjectBlockReasons = $resultObject->getBlockReasons();
            ArrayUtility::mergeRecursiveWithOverrule($this->blockReasons, $resultObjectBlockReasons);
        }
    }
}
