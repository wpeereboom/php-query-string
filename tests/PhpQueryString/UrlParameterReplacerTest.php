<?php
namespace PhpQueryString;

use PHPUnit_Framework_TestCase;

class UrlParameterReplacerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider getUrlsInContentProvider
     */
    public function testGetReplacedContent($content, $domain, $vars, $expectedContent)
    {
        $replacer = new UrlParameterReplacer();
        $replacer->setContent($content, $domain);

        foreach($vars as $var) {
            $replacer->setParam($var['name'], $var['value']);
        }

        $this->assertSame($expectedContent, $replacer->getReplacedContent());
    }

    public function getUrlsInContentProvider()
    {
        return [
            [
                '<br/><a href="https://domain.nl/alles-erbij?var=1">Test</a>',
                'domain.nl',
                [
                    'var' => ['name'=> 'var2', 'value'=> 'value2'],
                ],
                '<br/><a href="https://domain.nl/alles-erbij?var=1&var2=value2">Test</a>',
            ],
            [
                '<br/><a href="https://domain.nl/alles-erbij?var=1">Test</a><a href="https://domain.nl/alles-erbij?var=1">Test2</a>',
                'domain.nl',
                [
                    'var' => ['name'=> 'var2', 'value'=> 'value2'],
                ],
                '<br/><a href="https://domain.nl/alles-erbij?var=1&var2=value2">Test</a><a href="https://domain.nl/alles-erbij?var=1&var2=value2">Test2</a>',
            ],
            [
                '<br/><a href="https://domain.nl/alles-erbij?var=1">Test</a><a href="https://domain.nl/alles-erbij?var=1">Test2</a><a href="https://domain.nl/alles-erbij?var=3">Test3</a>',
                'domain.nl',
                [
                    'var' => ['name'=> 'var2', 'value'=> 'value2'],
                ],
                '<br/><a href="https://domain.nl/alles-erbij?var=1&var2=value2">Test</a><a href="https://domain.nl/alles-erbij?var=1&var2=value2">Test2</a><a href="https://domain.nl/alles-erbij?var=3&var2=value2">Test3</a>',
            ],
            [
                '<br/><a href="https://domain.nl/">Domain</a><a href="https://domain.nl/details">Details</a>',
                'domain.nl',
                [
                    'var' => ['name'=> 'var2', 'value'=> 'value2'],
                ],
                '<br/><a href="https://domain.nl/?var2=value2">Domain</a><a href="https://domain.nl/details?var2=value2">Details</a>',
            ],
            [
                '<br/><a href="https://other-domain.nl/">Domain</a><a href="https://some-other.nl/details">Details</a>',
                'else.nl',
                [
                    'var' => ['name'=> 'var2', 'value'=> 'value2'],
                ],
                '<br/><a href="https://other-domain.nl/">Domain</a><a href="https://some-other.nl/details">Details</a>',
            ],
            [
                '<a class="button productBoxButton" href="http://domain.nl/campaign-response/record/336/product-view/product/959-2b7e865aade619dc82887c20160406082841/1a1b37b1e90bfc2f4fe78be5869f1e07.1" style="margin-bottom: 0;display: inline-block;outline: 0 none;border-radius: .25em;border: 1px solid #00ac3b;padding: 0 .7em;cursor: pointer;font-family: \'Helvetica Neue\', arial, sans-serif;min-height: 2.8125em;line-height: 2.8125em;text-align: center;text-decoration: none;-webkit-appearance: none;-moz-appearance: none;color: #ffffff;background: #4DB500;box-shadow: inset 0px -3px 0px 0px #378200;filter: none;font-size: 16px;width: 190px;">
                                        <strong>Naar Accu\'s</strong>
                                                    </a>',
                'domain.nl',
                [
                    'var' => ['name'=> 'var2', 'value'=> 'value2'],
                ],
                '<a class="button productBoxButton" href="http://domain.nl/campaign-response/record/336/product-view/product/959-2b7e865aade619dc82887c20160406082841/1a1b37b1e90bfc2f4fe78be5869f1e07.1?var2=value2" style="margin-bottom: 0;display: inline-block;outline: 0 none;border-radius: .25em;border: 1px solid #00ac3b;padding: 0 .7em;cursor: pointer;font-family: \'Helvetica Neue\', arial, sans-serif;min-height: 2.8125em;line-height: 2.8125em;text-align: center;text-decoration: none;-webkit-appearance: none;-moz-appearance: none;color: #ffffff;background: #4DB500;box-shadow: inset 0px -3px 0px 0px #378200;filter: none;font-size: 16px;width: 190px;">
                                        <strong>Naar Accu\'s</strong>
                                                    </a>',
            ]
        ];
    }
}
