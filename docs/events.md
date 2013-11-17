Events
======

TwigView emits several events.

**Twig.TwigView.construct**
Is emitted when the object is constructed and can be used to load extra extensions into the `Twig` enviroment. For example as done by the plugin:

```php
class TwigRegisterTwigExtentionsListener implements CakeEventListener {

    public function implementedEvents() {
        return array(
            'Twig.TwigView.construct' => 'construct',
        );
    }

    public function construct($event) {	
        $event->data['TwigEnvironment']->addExtension(new Twig_Extension_StringLoader);
    }
}
``` 