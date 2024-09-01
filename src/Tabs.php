<?php

namespace App;

use App\Renderers\TabsRenderer;
use Chewie\Concerns\CreatesAnAltScreen;
use Chewie\Concerns\RegistersRenderers;
use Chewie\Input\KeyPressListener;
use Laravel\Prompts\Prompt;

class Tabs extends Prompt
{
    use RegistersRenderers, CreatesAnAltScreen;

    public array $tabs = [
        [
            'tab' => 'About Me',
            'content' => 'I am a curious creative coder.'
        ],
        [
            'tab' => 'Projects',
            'content' => 'I am working on a few projects.'
        ],
        [
            'tab' => 'Contact',
            'content' => 'You can reach me at my email address.'
        ],
        [
            'tab' => 'Skills',
            'content' => 'I am a designer and dev.'
        ]
    ];

    public int $selectedTab = 0;

    public function __construct()
    {
        $this->registerRenderer(TabsRenderer::class);

        $this->createAltScreen();

        KeyPressListener::for($this)
            ->listenForQuit()
            ->onRight(fn() => $this->selectedTab = min($this->selectedTab + 1, count($this->tabs) - 1))
            ->onLeft(fn() => $this->selectedTab = max($this->selectedTab - 1, 0))
            ->on('q', fn() => $this->terminal()->exit())
            ->listen();
    }

    public function value(): mixed
    {
        return null;
    }
}
