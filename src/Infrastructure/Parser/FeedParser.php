<?php

namespace App\Infrastructure\Parser;


use App\Application\ProductCreator;
use DateTime;

class FeedParser
{
    /**
     * @var ProductCreator
     */
    private $productCreator;

    /**
     * @var array
     */
    private $products;

    public function __construct(ProductCreator $createProduct)
    {
        $this->productCreator = $createProduct;
        $this->products = [];
    }

    /**
     * @param string $feed
     * @return array
     * @throws \Exception
     */
    function parse(string $feed)
    {
        $xml = $this->getFeed($feed);

        foreach($xml->children() as $item) {
            $this->parseProduct($item);
        }

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

        $this->productCreator->execute($title, $link);
    }

    /**
     * @param string $feed
     * @return \SimpleXMLElement
     * @throws \Exception
     */
    protected function getFeed(string $feed): \SimpleXMLElement
    {
        $xml = simplexml_load_file($feed, "SimpleXMLElement", LIBXML_NOCDATA);

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
        throw new \Exception($errorMessage);
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
