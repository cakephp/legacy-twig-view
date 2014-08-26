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

use WyriHaximus\TwigView\Lib\Twig\Node\Cell as CellNode;

/**
 * Class Element
 * @package WyriHaximus\TwigView\Lib\Twig\TokenParser
 */
class Cell extends \Twig_TokenParser_Include {

/**
 * Parse token
 *
 * @param \Twig_Token $token Token
 * @return CellNode
 */
	public function parse(\Twig_Token $token) {
		$stream = $this->parser->getStream();
		$variable = $stream->expect(\Twig_Token::NAME_TYPE)->getValue();
		$stream->expect(\Twig_Token::OPERATOR_TYPE, '=');
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

		return new CellNode($variable, $name, $data, $options, $token->getLine(), $this->getTag());
	}

/**
 * Tag name
 *
 * @return string
 */
	public function getTag() {
		return 'cell';
	}

}
