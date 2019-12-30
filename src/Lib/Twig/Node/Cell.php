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
use Twig\Node\NodeOutputInterface;

/**
 * Class Cell.
 * @package WyriHaximus\TwigView\Lib\Twig\Node
 */
final class Cell extends Node implements NodeOutputInterface
{
    /**
     * Whether to assign the data or not.
     *
     * @var bool
     */
    protected $assign = false;

    /**
     * Constructor.
     *
     * @param bool                                     $assign   Assign or echo.
     * @param mixed                                    $variable Variable to assign to.
     * @param \Twig\Node\Expression\AbstractExpression $name     Name.
     * @param \Twig\Node\Expression\AbstractExpression $data     Data array.
     * @param \Twig\Node\Expression\AbstractExpression $options  Options array.
     * @param int                                      $lineno   Line number.
     * @param string                                   $tag      Tag name.
     */
    public function __construct(
        $assign,
        $variable,
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
            [
                'variable' => $variable,
            ],
            $lineno,
            $tag
        );

        $this->assign = $assign;
    }

    /**
     * Compile tag.
     *
     * @param \Twig\Compiler $compiler Compiler.
     *
     */
    public function compile(Compiler $compiler)
    {
        $compiler->addDebugInfo($this);

        if ($this->assign) {
            $compiler->raw('$context[\'' . $this->getAttribute('variable') . '\'] = ');
        } else {
            $compiler->raw('echo ');
        }
        $compiler->raw('$context[\'_view\']->cell(');
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
