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
            ->title('::title')
            ->writeln('CONTENT')
            ->newLine()
            ->section('::section')
            ->writeln('CONTENT')
            ->newLine()
            ->success('::success')
            ->newLine()
            ->info('::info')
            ->newLine()
            ->text('::text')
            ->newLine()
            ->note('::note')
            ->newLine()
            ->warning('::warning')
            ->newLine()
            ->important('::important')
            ->newLine()
            ->error('::error')
            ->newLine()
            ->caution('::caution')
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
            ->info('Listing:')
            ->listing($l)
            ->newLine()
            ->info('Nested list:')
            ->nestedList([
                'Nested:',
                $l,
                'Another:',
                ['One:', ['Nested', ['List:', $l]]],
            ])
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