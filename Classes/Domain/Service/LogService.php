<?php

declare(strict_types=1);

namespace Slavlee\Waf\Domain\Service;

use Slavlee\Waf\Domain\DomainObject\LogObject;
use Slavlee\Waf\Domain\Model\Log;
use Slavlee\Waf\Domain\Repository\LogRepository;
use Slavlee\Waf\Utility\TYPO3\Persistence\RepositoryUtility;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This file is part of the "waf" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Kevin Chileong Lee <support@slavlee.de>, Slavlee
 */
class LogService
{
    /**
     * ExtensionConfiguration
     * @var array
     */
    protected array $extConf = [];

    public function __construct(
        private readonly ExtensionConfiguration $extensionConfiguration,
        private readonly LogRepository $logRepository
    ) {
        $extConf = $this->extensionConfiguration->get('waf');

        if (\is_array($extConf) && \array_key_exists('log', $extConf)) {
            $this->extConf = $extConf['log'];
        }

        RepositoryUtility::disableRespectStoragePage($this->logRepository);
    }

    /**
     * Handle a Request
     */
    public function log(LogObject $logObject): void
    {
        $log = GeneralUtility::makeInstance(Log::class);
        $log->setLogObject($logObject);
        $this->logRepository->add($log);
    }

    /**
     * Create a log entry, when a request was blocked
     * @param ServerRequest $request
     * @param array $blockReasons
     * @return void
     */
    public function logIfRequestBlocked(ServerRequest $request, array $blockReasons): void
    {
        $logObject = new LogObject();
        $logObject->type = LogObject::TYPE_REQUEST_BLOCKED;
        $logObject->channel = LogObject::CHANNEL_FIREWALL;
        $logObject->logData = \json_encode($blockReasons);
        $logObject->message = LogObject::MESSAGE_REQUEST_BLOCKED;
        $this->log($logObject);
    }
}
