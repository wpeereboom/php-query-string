<?php
namespace PhpQueryString;

class UrlParameter
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $domain;

    /**
     * UrlParameter constructor.
     * @param string $name
     * @param string $value
     * @param string $domain
     */
    public function __construct($name, $value, $domain)
    {
        $this->name = $name;
        $this->value = $value;
        $this->domain = $domain;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }
}
