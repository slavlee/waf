<?php

declare(strict_types=1);

namespace Slavlee\Waf\Domain\DomainObject;

use TYPO3\CMS\Extbase\DomainObject\AbstractValueObject;

/*
 * This file is part of the "waf" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
class LogObject extends AbstractValueObject
{
    /**
     * @var int
     */
    public const TYPE_REQUEST_BLOCKED = 0;

    /**
     * @var string
     */
    public const CHANNEL_FIREWALL = 'firewall';

    /**
     * @var string
     */
    public const MESSAGE_REQUEST_BLOCKED = 'Request blocked';

    /**
     * @var int $type
     */
    public int $type = 0;

    /**
     * @var string $channel
     */
    public string $channel = 'default';

    /**
     * @var string $logData
     */
    public string $logData = '';

    /**
     * @var string
     */
    public string $message = '';
}
