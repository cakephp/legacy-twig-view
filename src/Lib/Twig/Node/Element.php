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

namespace WyriHaximus\TwigView\Lib\Twig\Node;

use Twig\Compiler;
use Twig\Node\Expression\AbstractExpression;
use Twig\Node\Expression\ArrayExpression;
use Twig\Node\Node;

/**
 * Class Element.
 * @package WyriHaximus\TwigView\Lib\Twig\Node
 */
final class Element extends Node
{
    /**
     * Constructor.
     *
     * @param \Twig\Node\Expression\AbstractExpression $name    Name.
     * @param \Twig\Node\Expression\AbstractExpression $data    Data.
     * @param \Twig\Node\Expression\AbstractExpression $options Options.
     * @param int                                      $lineno  Linenumber.
     * @param string                                   $tag     Tag.
     */
    public function __construct(
        AbstractExpression $name,
        ?AbstractExpression $data = null,
        ?AbstractExpression $options = null,
        int $lineno = 0,
        ?string $tag = null
    ) {
        if ($data === null) {
            $data = new ArrayExpression([], $lineno);
        }

        if ($options === null) {
            $options = new ArrayExpression([], $lineno);
        }

        parent::__construct(
            [
                'name' => $name,
                'data' => $data,
                'options' => $options,
            ],
            [],
            $lineno,
            $tag
        );
    }

    /**
     * Compile node.
     *
     * @param \Twig\Compiler $compiler Compiler.
     *
     */
    public function compile(Compiler $compiler)
    {
        $compiler->addDebugInfo($this);

        $compiler->raw('echo $context[\'_view\']->element(');
        $compiler->subcompile($this->getNode('name'));
        $data = $this->getNode('data');
        if ($data !== null) {
            $compiler->raw(',');
            $compiler->subcompile($data);
        }
        $options = $this->getNode('options');
        if ($options !== null) {
            $compiler->raw(',');
            $compiler->subcompile($options);
        }
        $compiler->raw(");\n");
    }
}
