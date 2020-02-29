<?php
declare(strict_types=1);

namespace Cake\TwigView\Panel;

use Cake\TwigView\Lib\TreeScanner;
use DebugKit\DebugPanel;

final class TwigPanel extends DebugPanel
{
    /**
     * Plugin name.
     *
     * @var string
     */
    public $plugin = 'Cake/TwigView';

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

// phpcs:disable
class_alias('Cake\TwigView\Panel\TwigPanel', 'Wyrihaximus\TwigView\Panel\TwigPanel');
// phpcs:enable
