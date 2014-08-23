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
class Cell extends \Twig_Node {

    /**
     * @param \Twig_Node_Expression $name
     */
    public function __construct($variable, \Twig_Node_Expression $name, \Twig_Node_Expression $data = null, \Twig_Node_Expression $options = null, $lineno, $tag = null)
    {
        parent::__construct([
            'name' => $name,
            'data' => $data,
            'options' => $options,
        ], [
            'variable' => $variable,
        ], $lineno, $tag);
    }

    /**
     * @param \Twig_Compiler $compiler
     */
    public function compile(\Twig_Compiler $compiler)
    {
        $compiler->addDebugInfo($this);

        $compiler->raw('$context[\'' . $this->getAttribute('variable') . '\'] = $context[\'_view\']->cell(');
        $compiler->subcompile($this->getNode('name'));
        $data = $this->getNode('data');
        if ($data !== null) {
            $compiler->raw(',');
            $compiler->subcompile($data);
        }
        $options = $this->getNode('options');
        if ($data !== null) {
            $compiler->raw(',');
            $compiler->subcompile($options);
        }
        $compiler->raw(");\n");
    }
}
