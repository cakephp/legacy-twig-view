<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
  <head>
	{{ html.charset() }}
	<title>{{ 'CakePHP: the rapid development php framework'|trans }}: {{ title_for_layout }}</title>
	{{ html.meta('icon') }}
	{{ html.css('cake.generic') }}
	{{ scripts_for_layout }}
  </head>
  <body>
	<div id="container">
		<div id="header">
			<h1>{{ 
				html.link('CakePHP: the rapid development php framework'|trans, 'http://cakephp.org')
			}}</h1>
		</div>
		<div id="content">
			{{ session.flash() }}
			{{ content_for_layout }}
		</div>
		<div id="footer">
		{{ 
			html.image('cake.power.gif', {
				'alt': 'Powered by CakePHP'|trans,
				'url': 'http://cakephp.org'
			})
		}}
		</div>
	</div>
  </body>
</html>