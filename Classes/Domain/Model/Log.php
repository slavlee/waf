<?php

declare(strict_types=1);

namespace Slavlee\Waf\Domain\Model;

use Slavlee\Waf\Domain\DomainObject\LogObject;
use TYPO3\CMS\Extbase\Annotation\Validate;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/*
 * This file is part of the "waf" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
class Log extends AbstractEntity
{
    /**
     * @var int $type
     */
    protected int $type = 0;

    /**
     * @var int $channel
     */
    #[Validate([
        'validator' => 'NotEmpty',
    ])]
    protected string $channel = 'default';

    /**
     * @var string $logData
     */
    #[Validate([
        'validator' => 'NotEmpty',
    ])]
    protected string $logData = '';

    /**
     * @var string
     */
    protected string $message = '';

    /**
     * Get $type
     *
     * @return  int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set $type
     *
     * @param  int  $type  $type
     *
     * @return  self
     */
    public function setType(int $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of channel
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * Set the value of channel
     *
     * @return  self
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * Get the value of logData
     */
    public function getLogData()
    {
        return $this->logData;
    }

    /**
     * Set the value of logData
     *
     * @return  self
     */
    public function setLogData($logData)
    {
        $this->logData = $logData;

        return $this;
    }

    /**
     * Get the value of message
     *
     * @return  string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the value of message
     *
     * @param  string  $message
     *
     * @return  self
     */
    public function setMessage(string $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Init Log by LogObject
     * @param LogObject $logObject
     * @return void
     */
    public function setLogObject(LogObject $logObject): void
    {
        $vars = \get_object_vars($this);

        foreach ($vars as $propertyName => $value) {
            $this->$propertyName = $logObject->$propertyName;
        }
    }
}
