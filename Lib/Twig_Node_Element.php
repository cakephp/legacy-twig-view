<?php
/**
 * Just a hacked version 'include'
 *
 *    {% element "login_form" %}
 *     
 *     => loads: APP/views/elements/login_form.tpl
 */

/*
 * This file is part of Twig.
 *
 * (c) 2009 Fabien Potencier
 * (c) 2009 Armin Ronacher
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class Twig_TokenParser_Element extends Twig_TokenParser {

/**
 * Parses a token and returns a node.
 *
 * @param Twig_Token $token A Twig_Token instance
 * @return Twig_NodeInterface A Twig_NodeInterface instance
 */
	public function parse(Twig_Token $token) {
		$expr = $this->parser->getExpressionParser()->parseExpression();
		$variables = null;
		if ($this->parser->getStream()->test(Twig_Token::NAME_TYPE, 'with')) {
			$this->parser->getStream()->next();
			$variables = $this->parser->getExpressionParser()->parseExpression();
		}

		$this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);
		return new Twig_Node_Element($expr, $variables, $token->getLine(), $this->getTag());
	}

/**
 * Gets the tag name associated with this token parser.
 *
 * @param string The tag name
 */
	public function getTag() {
		return 'element';
	}
}

/**
 * Represents an include node.
 *
 * Modified to use CakePHP paths
 *    @author Kjell Bublitz <m3nt0r.de@gmail.com>
 *
 * @package TwigView
 * @subpackage TwigView.Lib
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id$
 */
class Twig_Node_Element extends Twig_Node {

/**
 * Constructor
 *
 * @param Twig_Node_Expression $expr 
 * @param Twig_Node_Expression $variables 
 * @param string $lineno 
 * @param string $tag 
 */
	public function __construct(Twig_Node_Expression $expr, Twig_Node_Expression $variables = null, $lineno, $tag = null) {
		parent::__construct(array('expr' => $expr, 'variables' => $variables), array(), $lineno, $tag);
	}

/**
 * Compiles the node to PHP.
 *
 * @param Twig_Compiler A Twig_Compiler instance
 */
	public function compile(Twig_Compiler $compiler) {
		$compiler->addDebugInfo($this);
		if ($this->expr instanceof Twig_Node_Expression_Constant) {
			$value = 'elements' . DS . $this->expr->offsetGet('value') . '.tpl';
			$this->expr->offsetSet('value', $value);

			$compiler
				->write("\$this->env->loadTemplate(")
				->subcompile($this->expr)
				->raw(")->display(");
		} else {
			$compiler
				->write("\$template = ")
				->subcompile($this->expr)
				->raw(";\n")
				->write("if (!\$template")
				->raw(" instanceof Twig_Template) {\n")
				->indent()
				->write("\$template = \$this->env->loadTemplate(\$template);\n")
				->outdent()
				->write("}\n")
				->write('$template->display(');
		}

		if (null === $this->variables) {
			$compiler->raw('$context');
		} else {
			$compiler->subcompile($this->variables);
		}
		$compiler->raw(");\n");
	}
}
