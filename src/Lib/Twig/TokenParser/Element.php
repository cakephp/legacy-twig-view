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

/**
 * Class Element
 * @package WyriHaximus\TwigView\Lib\Twig\TokenParser
 */
class Element extends \Twig_TokenParser_Include {

    /**
     * @param \Twig_Token $token
     * @return \Twig_NodeInterface|ElementNode
     */
    public function parse(\Twig_Token $token)
    {
        $stream = $this->parser->getStream();
        $name = $this->parser->getExpressionParser()->parseExpression();
        if (!$stream->test(\Twig_Token::BLOCK_END_TYPE)) {
            $data = $this->parser->getExpressionParser()->parseExpression();
        } else {
            $data = null;
        }
        if (!$stream->test(\Twig_Token::BLOCK_END_TYPE)) {
            $options = $this->parser->getExpressionParser()->parseExpression();
        } else {
            $options = null;
        }

        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        return new ElementNode($name, $data, $options, $token->getLine(), $this->getTag());
    }

    /**
     * @param \Twig_Node_Expression $expr
     * @return \Twig_Node_Expression_Constant
     */
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

    /**
     * @return string
     */
    public function getTag()
    {
        return 'element';
    }

}
