<?php

namespace App\Infrastructure\Parser;


use App\Application\ProductCreator;
use App\Infrastructure\Logger\ErrorLogger;
use App\Infrastructure\Logger\InfoLogger;
use DateTime;

class FeedParser extends FeedParserBase
{
    /**
     * @var ProductCreator
     */
    private $productCreator;

    /**
     * @var ErrorLogger
     */
    private $errorLogger;

    /**
     * @var InfoLogger
     */
    private $infoLogger;

    /**
     * @var array
     */
    private $products;

    public function __construct($strFeedUrl, ProductCreator $createProduct)
    {
        parent::__construct($strFeedUrl);
        $this->productCreator = $createProduct;
        $this->errorLogger = new ErrorLogger();
        $this->infoLogger = new InfoLogger();
        $this->products = [];
    }

    /**
     * @throws \Exception
     */
    function parse()
    {
        $xml = $this->getFeed();

        $this->logInfo('Starting to parse');

        foreach($xml->children() as $item) {
            $this->parseProduct($item);
        }

        $this->logInfo('Finished');

        return $this->products;
    }

    /**
     * @param \SimpleXMLElement $item
     * @throws \Exception
     */
    protected function parseProduct(\SimpleXMLElement $item): void
    {
        $title = $this->parseTitle($item);
        $link = $this->parseLink($item);
        $pubDate = $this->parsePubDate($item);

        $this->logInfo('Parsing item ' . $title);

        $this->products[] = $this->productCreator->execute($title, $link, $pubDate);
    }

    /**
     * @return \SimpleXMLElement
     * @throws \Exception
     */
    protected function getFeed(): \SimpleXMLElement
    {
        $xml = simplexml_load_file($this->_strFeedUrl, "SimpleXMLElement", LIBXML_NOCDATA);

        if (false === $xml) {
            $this->handleError('The feed could not be found');
        }

        return $xml;
    }

    /**
     * @param string $errorMessage
     * @throws \Exception
     */
    private function handleError(string $errorMessage)
    {
        $this->errorLogger->notify($this, $errorMessage);

        throw new \Exception($errorMessage);
    }

    private function logInfo(string $info)
    {
        $this->infoLogger->notify($this, $info);
    }

    /**
     * @param \SimpleXMLElement $item
     * @return \SimpleXMLElement
     * @throws \Exception
     */
    protected function parseTitle(\SimpleXMLElement $item): \SimpleXMLElement
    {
        $title = $item->children()->title;

        if (null === $title) {
            $this->handleError('Title can not be empty');
        }

        return $title;
    }

    /**
     * @param \SimpleXMLElement $item
     * @return \SimpleXMLElement
     * @throws \Exception
     */
    protected function parseLink(\SimpleXMLElement $item): \SimpleXMLElement
    {
        $link = $item->children()->link;

        if (null === $link) {
            $this->handleError('Link can not be empty');
        }

        return $link;
    }

    /**
     * @param \SimpleXMLElement $item
     * @return \DateTime
     * @throws \Exception
     */
    protected function parsePubDate(\SimpleXMLElement $item): DateTime
    {
        $pubDateString = $item->children()->pubDate;

        if (null === $pubDateString) {
            $this->handleError('PubDate can not be empty');
        }

        try {
            $pubDate = new DateTime($pubDateString);
        } catch (\Exception $e) {
            $this->handleError('PubDate is not a valid date');
        }

        return $pubDate;
    }
}
