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

class Element extends \Twig_Node_Include {

    public function compile(\Twig_Compiler $compiler)
    {
        $compiler->addDebugInfo($this);

        if ($this->getAttribute('ignore_missing')) {
            $compiler
                ->write("try {\n")
                ->indent()
            ;
        }

        $compiler->raw('$content[\'_view\']->element(');

        $this->addTemplateArguments($compiler);

        $compiler->raw(");\n");

        if ($this->getAttribute('ignore_missing')) {
            $compiler
                ->outdent()
                ->write("} catch (Twig_Error_Loader \$e) {\n")
                ->indent()
                ->write("// ignore missing template\n")
                ->outdent()
                ->write("}\n\n")
            ;
        }
    }

    protected function addGetTemplate(Twig_Compiler $compiler)
    {
        if ($this->getNode('expr') instanceof Twig_Node_Expression_Constant) {
            $compiler
                ->subcompile($this->getNode('expr'))
            ;
        } else {
            $compiler
                ->write("\$this->env->resolveTemplate(")
                ->subcompile($this->getNode('expr'))
                ->raw(")")
            ;
        }
    }


}