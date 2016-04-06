<?php
namespace PhpQueryString;

use PHPUnit_Framework_TestCase;

class UrlParameterReplacerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider getUrlsInContentProvider
     */
    public function testGetReplacedContent($content, $vars, $expectedContent)
    {
        $replacer = new UrlParameterReplacer();
        $replacer->setContent($content);

        foreach($vars as $var) {
            $replacer->setParam($var['name'], $var['value'], $var['domain']);
        }

        $this->assertSame($expectedContent, $replacer->getReplacedContent());
    }

    public function getUrlsInContentProvider()
    {
        return [
            [
                '<br/><a href="https://domain.nl/alles-erbij?var=1">Test</a>',
                [
                    'var' => ['name'=> 'var2', 'value'=> 'value2', 'domain' => 'domain.nl'],
                ],
                '<br/><a href="https://domain.nl/alles-erbij?var=1&var2=value2">Test</a>',
            ],
            [
                '<br/><a href="https://domain.nl/alles-erbij?var=1">Test</a><a href="https://domain.nl/alles-erbij?var=1">Test2</a>',
                [
                    'var' => ['name'=> 'var2', 'value'=> 'value2', 'domain' => 'domain.nl'],
                ],
                '<br/><a href="https://domain.nl/alles-erbij?var=1&var2=value2">Test</a><a href="https://domain.nl/alles-erbij?var=1&var2=value2">Test2</a>',
            ],
            [
                '<br/><a href="https://domain.nl/alles-erbij?var=1">Test</a><a href="https://domain.nl/alles-erbij?var=1">Test2</a><a href="https://domain.nl/alles-erbij?var=3">Test3</a>',
                [
                    'var' => ['name'=> 'var2', 'value'=> 'value2', 'domain' => 'domain.nl'],
                ],
                '<br/><a href="https://domain.nl/alles-erbij?var=1&var2=value2">Test</a><a href="https://domain.nl/alles-erbij?var=1&var2=value2">Test2</a><a href="https://domain.nl/alles-erbij?var=3&var2=value2">Test3</a>',
            ],
            [
                '<br/><a href="https://domain.nl/">Domain</a><a href="https://domain.nl/details">Details</a>',
                [
                    'var' => ['name'=> 'var2', 'value'=> 'value2', 'domain' => 'domain.nl'],
                ],
                '<br/><a href="https://domain.nl/?var2=value2">Domain</a><a href="https://domain.nl/details?var2=value2">Details</a>',
            ],
            [
                '<br/><a href="https://other-domain.nl/">Domain</a><a href="https://some-other.nl/details">Details</a>',
                [
                    'var' => ['name'=> 'var2', 'value'=> 'value2', 'domain' => 'else.nl'],
                ],
                '<br/><a href="https://other-domain.nl/">Domain</a><a href="https://some-other.nl/details">Details</a>',
            ],
        ];
    }
}
