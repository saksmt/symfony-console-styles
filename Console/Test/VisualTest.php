<?php

namespace Smt\Component\Console\Test;

use Smt\Component\Console\Style\AbstractLinuxDistributionStyle;

class VisualTest
{
    public function run(AbstractLinuxDistributionStyle $style)
    {
        $m = ['Multi', 'Line', 'Message'];
        $l = ['First item', 'Second item', 'Third item'];
        $style
            ->title('Test title')
            ->writeln('CONTENT')
            ->newLine()
            ->section('Test section title')
            ->writeln('CONTENT')
            ->newLine()
            ->success('Success message')
            ->newLine()
            ->info('Info message')
            ->newLine()
            ->text('Text message')
            ->newLine()
            ->note('Note message')
            ->newLine()
            ->warning('Warning message')
            ->newLine()
            ->important('Important message')
            ->newLine()
            ->error('Error message')
            ->newLine()
            ->caution('Caution message')
            ->newLine()
            ->success($m)
            ->newLine()
            ->info($m)
            ->newLine()
            ->text($m)
            ->newLine()
            ->note($m)
            ->newLine()
            ->warning($m)
            ->newLine()
            ->important($m)
            ->newLine()
            ->error($m)
            ->newLine()
            ->caution($m)
            ->newLine()
            ->writeln('List:')
            ->listing($l)
            ->newLine()
        ;
        $style->ask('Question?');
        $style->ask('Question with default?', 'yes');
        $style->confirm('Confirm?');
        $style->confirm('Inverse confirm?', false);
        $style->choice('Choice?', ['y' => 'yes', 'n' => 'no', 'm' => 'maybe']);
        $style->choice('Choice with default?', ['y' => 'yes', 'n' => 'no', 'm' => 'maybe'], 'y');
        $style->newLine(2);

    }
}