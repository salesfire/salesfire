<?php

namespace Salesfire;

use Salesfire\Types\Transaction;
use Salefire\Types\Product;

class Formatter
{
    /**
     * @var array The site identifier
     */
    protected $uuid;

    /**
     * @var array The events to format
     */
    protected $events = [];

    /**
     * @param string The site identifier
     * @return \Salesfire\Formatter
     */
    public function __construct($uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param \Salesfire\Types\Transaction $transaction
     * @return \Salesfire\Formatter
     */
    public function addTransaction(Transaction $transaction): Formatter
    {
        $this->events[] = [
            'ecommerce' => [
                'purchase' => (array) $transaction,
            ]
        ];

        return $this;
    }

    /**
     * @param \Salesfire\Types\Product $product
     * @return \Salesfire\Formatter
     */
    public function addProductView(Product $product): Formatter
    {
        $this->events[] = [
            'ecommerce' => [
                'view' => (array) $product,
            ]
        ];

        return $this;
    }

    /**
     * @param \Salesfire\Types\Product $product
     * @return \Salesfire\Formatter
     */
    public function addBasketAdd(Product $product): Formatter
    {
        $this->events[] = [
            'ecommerce' => [
                'add' => (array) $product,
            ]
        ];

        return $this;
    }

    /**
     * @param \Salesfire\Types\Product $product
     * @return \Salesfire\Formatter
     */
    public function addBasketRemove(Product $product): Formatter
    {
        $this->events[] = [
            'ecommerce' => [
                'remove' => (array) $product,
            ]
        ];

        return $this;
    }

    public function __toArray(): array
    {
        return $this->events;
    }

    /**
     * @return string
     */
     public function toJson(): string
     {
        return json_encode($this->events);
     }

    /**
     * @return string
     */
    public function toScriptTag(): string
    {
        $script = '';
        if (count($this->events) > 0) {

            $script .= "<script>\n";
            $script .= "sfDataLayer = window.sfDataLayer || [];\n";
            $script .= "sfDataLayer.push(" . $this->toJson() . ");\n";
            $script .= "</script>\n";
        }

        $script .= "<script async src='https://cdn.salesfire.co.uk/code/" . $this->getUuid() . ".js'></script>\n";

        return $script;
    }
}
