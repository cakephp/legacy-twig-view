<?php

/**
 * This file is part of TwigView.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WyriHaximus\TwigView\Lib\Twig\TokenParser;

use WyriHaximus\TwigView\Lib\Twig\Node\Element as ElementNode;

class Element extends \Twig_TokenParser_Include {

    public function parse(\Twig_Token $token)
    {
        $expr = $this->parser->getExpressionParser()->parseExpression();

        list($variables, $only, $ignoreMissing) = $this->parseArguments();

        return new ElementNode($expr, $variables, $only, $ignoreMissing, $token->getLine(), $this->getTag());
    }

    protected function insertElementLocation(\Twig_Node_Expression $expr) {
        $name = $expr->getAttribute('value');

        list($plugin, $file) = pluginSplit($name);
        if ($plugin === null || !Plugin::loaded($plugin)) {
            $name = $plugin . '.Elements/' . $file;
        } else {
            $name = 'Elements/' . $file;
        }

        return new \Twig_Node_Expression_Constant($name, $expr->getLine());
    }

    public function getTag()
    {
        return 'element';
    }

}
