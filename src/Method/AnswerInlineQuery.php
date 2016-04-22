<?php

namespace Steelbot\TelegramBotApi\Method;

class AnswerInlineQuery extends AbstractMethod implements \JsonSerializable
{
    /**
     * @var string
     */
    protected $inlineQueryId;

    /**
     * @var array
     */
    protected $results;

    /**
     * @var int
     */
    protected $cacheTime;

    /**
     * @var bool
     */
    protected $isPersonal;

    /**
     * @var string
     */
    protected $nextOffset;

    /**
     * @var string|null
     */
    protected $switchPmText;

    /**
     * @var string|null
     */
    protected $switchPmParameter;

    public function __construct($inlineQueryId, array $results)
    {
        $this->inlineQueryId = $inlineQueryId;
        $this->results = $results;
    }

    /**
     * @return string
     */
    public function getInlineQueryId()
    {
        return $this->inlineQueryId;
    }

    /**
     * @param string $inlineQueryId
     *
     * @return AnswerInlineQuery
     */
    public function setInlineQueryId($inlineQueryId)
    {
        $this->inlineQueryId = $inlineQueryId;

        return $this;
    }

    /**
     * @return string
     */
    public function getNextOffset()
    {
        return $this->nextOffset;
    }

    /**
     * @param string $nextOffset
     *
     * @return AnswerInlineQuery
     */
    public function setNextOffset($nextOffset): self
    {
        $this->nextOffset = $nextOffset;

        return $this;
    }

    /**
     * @return array
     */
    public function getResults(): array
    {
        return $this->results;
    }

    /**
     * @param array $results
     *
     * @return AnswerInlineQuery
     */
    public function setResults($results)
    {
        $this->results = $results;

        return $this;
    }

    /**
     * @return int
     */
    public function getCacheTime()
    {
        return $this->cacheTime;
    }

    /**
     * @param int $cacheTime
     *
     * @return AnswerInlineQuery
     */
    public function setCacheTime(int $cacheTime = null)
    {
        $this->cacheTime = $cacheTime;

        return $this;
    }

    /**
     * @return boolean
     */
    public function GetIsPersonal()
    {
        return $this->isPersonal;
    }

    /**
     * @param boolean $isPersonal
     *
     * @return AnswerInlineQuery
     */
    public function setIsPersonal($isPersonal)
    {
        $this->isPersonal = $isPersonal;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSwitchPmText()
    {
        return $this->switchPmText;
    }

    /**
     * @param null|string $switchPmText
     *
     * @return self
     */
    public function setSwitchPmText(string $switchPmText = null)
    {
        $this->switchPmText = $switchPmText;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSwitchPmParameter()
    {
        return $this->switchPmParameter;
    }

    /**
     * @param null|string $switchPmParameter
     *
     * @return self
     */
    public function setSwitchPmParameter(string $switchPmParameter = null)
    {
        $this->switchPmParameter = $switchPmParameter;

        return $this;
    }

    /**
     * Get method name.
     *
     * @return string
     */
    public function getMethodName(): string
    {
        return 'answerInlineQuery';
    }

    /**
     *
     * @return string
     */
    public function getHttpMethod(): string
    {
        return self::HTTP_POST;
    }

    /**
     * Get parameters for HTTP query.
     *
     * @return mixed
     */
    public function getParams(): array
    {
        $params = [
            'inline_query_id' => $this->inlineQueryId,
        ];

        if ($this->cacheTime) {
            $params['cache_time'] = $this->cacheTime;
        }

        if ($this->isPersonal !== null) {
            $params['is_personal'] = (int)$this->isPersonal;
        }

        if ($this->nextOffset) {
            $params['next_offset'] = $this->nextOffset;
        }

        return $params;
    }

    /**
     * Build result type from array of data.
     *
     * @param bool $result
     *
     * @return bool
     */
    public function buildResult($result): bool
    {
        return $result;
    }

    /**
     * @return array
     */
    function jsonSerialize()
    {
        $result =  [
            'results' => $this->results
        ];

        if ($this->switchPmText !== null) {
            $result['switch_pm_parameter'] = $this->switchPmParameter;
        }

        if ($this->switchPmText !== null) {
            $result['switch_pm_text'] = $this->switchPmText;
        }

        return $result;
    }
}
