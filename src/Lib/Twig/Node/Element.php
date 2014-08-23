<?php

/**
 * This file is part of TwigView.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WyriHaximus\TwigView\Lib\Twig\Node;

/**
 * Class Element
 * @package WyriHaximus\TwigView\Lib\Twig\Node
 */
class Element extends \Twig_Node {

    /**
     * @param \Twig_Node_Expression $name
     */
    public function __construct(\Twig_Node_Expression $name)
    {
        parent::__construct([
            'name' => $name,
        ], []);
    }

    /**
     * @param \Twig_Compiler $compiler
     */
    public function compile(\Twig_Compiler $compiler)
    {
        $compiler->addDebugInfo($this);

        $compiler->raw('echo $context[\'_view\']->element(');
        $compiler->subcompile($this->getNode('name'));
        $compiler->raw(");\n");
    }
}
