<?php declare(strict_types=1);
/**
 * This file is part of TwigView.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WyriHaximus\TwigView\Lib\Twig\TokenParser;

use Twig\TokenParser\IncludeTokenParser;
use WyriHaximus\TwigView\Lib\Twig\Node\Element as ElementNode;

/**
 * Class Element.
 * @package WyriHaximus\TwigView\Lib\Twig\TokenParser
 */
class Element extends IncludeTokenParser
{
    /**
     * Parse token.
     *
     * @param \Twig\Token $token Token.
     *
     * @return \Twig\Node\NodeOutputInterface|ElementNode // FIXME or NodeCaptureInterface?
     */
    public function parse(\Twig\Token $token)
    {
        $stream = $this->parser->getStream();
        $name = $this->parser->getExpressionParser()->parseExpression();

        $data = null;
        if (!$stream->test(\Twig\Token::BLOCK_END_TYPE)) {
            $data = $this->parser->getExpressionParser()->parseExpression();
        }

        $options = null;
        if (!$stream->test(\Twig\Token::BLOCK_END_TYPE)) {
            $options = $this->parser->getExpressionParser()->parseExpression();
        }

        $stream->expect(\Twig\Token::BLOCK_END_TYPE);

        return new ElementNode($name, $data, $options, $token->getLine(), $this->getTag());
    }

    /**
     * Get tag name.
     *
     * @return string
     */
    public function getTag()
    {
        return 'element';
    }
}
