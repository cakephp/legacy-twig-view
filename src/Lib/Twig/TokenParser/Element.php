<?php
declare(strict_types=1);

/**
 * This file is part of TwigView.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cake\TwigView\Lib\Twig\TokenParser;

use Cake\TwigView\Lib\Twig\Node\Element as ElementNode;
use Twig\Node\Node;
use Twig\Token;
use Twig\TokenParser\IncludeTokenParser;

/**
 * Class Element.
 *
 * @internal
 */
final class Element extends IncludeTokenParser
{
    /**
     * Parse token.
     *
     * @param \Twig\Token $token Token.
     * @return \Twig\Node\Node
     */
    public function parse(Token $token): Node
    {
        $stream = $this->parser->getStream();
        $name = $this->parser->getExpressionParser()->parseExpression();

        $data = null;
        if (!$stream->test(Token::BLOCK_END_TYPE)) {
            $data = $this->parser->getExpressionParser()->parseExpression();
        }

        $options = null;
        if (!$stream->test(Token::BLOCK_END_TYPE)) {
            $options = $this->parser->getExpressionParser()->parseExpression();
        }

        $stream->expect(Token::BLOCK_END_TYPE);

        return new ElementNode($name, $data, $options, $token->getLine(), $this->getTag());
    }

    /**
     * Get tag name.
     *
     * @return string
     */
    public function getTag(): string
    {
        return 'element';
    }
}
