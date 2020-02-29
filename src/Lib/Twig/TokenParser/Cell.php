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

use Cake\TwigView\Lib\Twig\Node\Cell as CellNode;
use Twig\Node\Node;
use Twig\Token;
use Twig\TokenParser\IncludeTokenParser;

/**
 * Class Element.
 */
final class Cell extends IncludeTokenParser
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

        $variable = null;
        if ($stream->test(Token::NAME_TYPE)) {
            $variable = $stream->expect(Token::NAME_TYPE)->getValue();
        }
        $assign = false;
        if ($stream->test(Token::OPERATOR_TYPE)) {
            $stream->expect(Token::OPERATOR_TYPE, '=');
            $assign = true;
        }

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

        return new CellNode($assign, $variable, $name, $data, $options, $token->getLine(), $this->getTag());
    }

    /**
     * Tag name.
     *
     * @return string
     */
    public function getTag(): string
    {
        return 'cell';
    }
}
