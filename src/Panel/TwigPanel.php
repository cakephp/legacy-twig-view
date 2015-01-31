<?php

namespace WyriHaximus\TwigView\Panel;

use Cake\Event\Event;
use DebugKit\DebugPanel;

class TwigPanel extends DebugPanel
{
    public $plugin = 'WyriHaximus/TwigView';

    protected $profile;

    public function profile(Event $event)
    {
        $this->profile = $event->subject();
    }

    public function implementedEvents() {
        return [
            'TwigView.Twig.profile' => 'profile',
        ];
    }

    public function data()
    {
        return new \Twig_Markup((new \Twig_Profiler_Dumper_Html())->dump($this->profile), 'UTF-8');
    }
}
