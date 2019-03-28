<?php

namespace Salesfire\Types;

class Transaction
{
    /**
     * @var string The order identifier
     */
    protected $id;

    /**
     * @var float The shipping price
     */
    protected $shipping;

    /**
     * @var string The affiliate code
     */
    protected $affiliate;

    /**
     * @var string The city code
     */
    protected $city;

    /**
     * @var string The state code
     */
    protected $state;

    /**
     * @var string The country code (ISO 3166-1 Alpha-2)
     */
    protected $country;

    /**
     * @var string The coupon code
     */
    protected $coupon;

    /**
     * @var string The currency (ISO 4217)
     */
    protected $currency = "GBP";

    /**
     * @var \Salesfire\Types\Product[] A list of products
     */
    protected $products = [];

    /**
     * @param array The data to be set from array
     * @return void
     */
    public function __construct(array $data = [])
    {
        foreach($data as $key => $val) {
            $this->{$key} = $val;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string The id to set
     * @return \Salesfire\Types\Transaction
     */
    public function setId(string $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return float
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * @param float The shipping to set
     * @return \Salesfire\Types\Transaction
     */
    public function setShipping(float $shipping)
    {
        $this->shipping = $shipping;

        return $this;
    }

    /**
     * @return string
     */
    public function getAffiliate()
    {
        return $this->affiliate;
    }

    /**
     * @param string The affiliate to set
     * @return \Salesfire\Types\Transaction
     */
    public function setAffiliate(string $affiliate)
    {
        $this->affiliate = $affiliate;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string The city to set
     * @return \Salesfire\Types\Transaction
     */
    public function setCity(string $city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string The state to set
     * @return \Salesfire\Types\Transaction
     */
    public function setState(string $state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string The country to set
     * @return \Salesfire\Types\Transaction
     */
    public function setCountry(string $country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string
     */
    public function getCoupon(): string
    {
        return $this->coupon;
    }

    /**
     * @param string The coupon to set
     * @return \Salesfire\Types\Transaction
     */
    public function setCoupon(string $coupon)
    {
        $this->coupon = $coupon;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(string $currency)
    {
        return $this->currency;
    }

    /**
     * @param string The currency code to set
     * @return \Salesfire\Types\Transaction
     */
    public function setCurrency(string $currency)
    {
        return $this->currency;
    }

    /**
     * @param \Salesfire\Product The product to add
     * @return \Salesfire\Types\Transaction
     */
    public function addProduct(Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * @return array
     */
    public function getProducts()
    {
        return array_map(function ($product) {
            return (array) $product;
        }, $this->products);
    }

    /**
     * @return float
     */
    public function getRevenue()
    {
        return array_reduce($this->products, function ($revenue, $product) {
            return $revenue + $product->getPrice();
        }, 0);
    }

    /**
     * @return float
     */
    public function getTax()
    {
        return array_reduce($this->products, function ($tax, $product) {
            return $tax + $product->getTax();
        }, 0);
    }

    /**
     * @return array
     */
    public function __toArray()
    {
        return array_filter([
            'id'        => $this->id,
            'revenue'   => $this->getRevenue(),
            'tax'       => $this->getTax(),
            'shipping'  => $this->shipping,
            'coupon'    => $this->coupon,
            'currency'  => $this->currency,
            'affiliate' => $this->affiliate,
            'city'      => $this->city,
            'state'     => $this->state,
            'country'   => $this->country,
            'products'  => $this->getProducts(),
        ]);
    }

}