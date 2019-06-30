<?php
declare(strict_types=1);

namespace WyriHaximus\TwigView\Panel;

use DebugKit\DebugPanel;
use WyriHaximus\TwigView\Lib\TreeScanner;

final class TwigPanel extends DebugPanel
{
    /**
     * Plugin name.
     *
     * @var string
     */
    public $plugin = 'WyriHaximus/TwigView';

    /**
     * Get the data for the twig panel.
     *
     * @return array
     */
    public function data(): array
    {
        return [
            'templates' => TreeScanner::all(),
        ];
    }
}
