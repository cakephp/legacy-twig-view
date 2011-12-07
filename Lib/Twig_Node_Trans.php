<?php
/**
 * Represents a trans node.
 *
 * Modified to use CakePHP functions
 * @author Kjell Bublitz <m3nt0r.de@gmail.com>
 * 
 * @package    twig
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id$
 */
class Twig_Node_Trans extends Twig_Node {

/**
 * Constructor
 *
 * @param Twig_NodeInterface $body 
 * @param Twig_NodeInterface $plural 
 * @param Twig_Node_Expression $count 
 * @param string $lineno 
 * @param string $tag 
 */
	public function __construct(Twig_NodeInterface $body, Twig_NodeInterface $plural = null, Twig_Node_Expression $count = null, $lineno, $tag = null) {
		parent::__construct(array('count' => $count, 'body' => $body, 'plural' => $plural), array(), $lineno, $tag);
	}

/**
 * Compiles the node to PHP.
 *
 * @param Twig_Compiler A Twig_Compiler instance
 */
	public function compile(Twig_Compiler $compiler) {
		$compiler->addDebugInfo($this);
		list($msg, $vars) = $this->compileString($this->nodes['body']);

		if (null !== $this->nodes['plural']) {
			list($msg1, $vars1) = $this->compileString($this->nodes['plural']);
			$vars = array_merge($vars, $vars1);
		}

		$function = null === $this->nodes['plural'] ? '__' : '__n';

		if ($vars) {
			$compiler
				->write('echo strtr('.$function.'(')
				->subcompile($msg);

			if (null !== $this->nodes['plural']) {
				$compiler
					->raw(', ')
					->subcompile($msg1)
					->raw(', abs(')
					->subcompile($this->nodes['count'])
					->raw(')');
			}

			$compiler->raw(', true), array('); // modified: cakephp $return flag

			foreach ($vars as $var) {
				if ('count' === $var->getAttribute('name')) {
					$compiler
						->string('%count%')
						->raw(' => abs(')
						->subcompile($this->nodes['count'])
						->raw('), ');
				} else {
					$compiler
						->string('%'.$var->getAttribute('name').'%')
						->raw(' => ')
						->subcompile($var)
						->raw(', ');
				}
			}

			$compiler->raw("));\n");
		} else {
			$compiler
				->write('echo '.$function.'(')
				->subcompile($msg);

			if (null !== $this->nodes['plural']) {
				$compiler
					->raw(', ')
					->subcompile($msg1)
					->raw(', abs(')
					->subcompile($this->nodes['count'])
					->raw(')');
			}

			$compiler->raw(', true);'); // modified: cakephp $return flag
		}
	}

/**
 * Compile String
 *
 * @param string $body 
 * @return void
 */
	protected function compileString($body) {
		if ($body instanceof Twig_Node_Expression_Name || $body instanceof Twig_Node_Expression_Constant) {
			return array($body, array());
		}

		$msg = '';
		$vars = array();

		if ($body instanceof Twig_Node_Text) {
			$node = $body;
			$msg = $node->getAttribute('data');
		} else {
			foreach ($body->nodes as $node) {
				if ($node instanceof Twig_Node_Print) {
					$n = $node->getNode('expr');
					while ($n instanceof Twig_Node_Expression_Filter) {
						$n = $n->getNode('node');
					}
					$msg .= sprintf('%%%s%%', $n->getAttribute('name'));
					$vars[] = new Twig_Node_Expression_Name($n->getAttribute('name'), $n->getLine());
				} else {
					$msg .= $node->getAttribute('data');
				}
			}
		}

		return array(new Twig_Node(array(new Twig_Node_Expression_Constant(trim($msg), $node->getLine()))), $vars);
	}
}
