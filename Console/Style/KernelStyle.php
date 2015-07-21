<?php

namespace Smt\Component\Console\Style;

use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\SymfonyQuestionHelper;

class KernelStyle extends AbstractLinuxDistributionStyle
{

    /**
     * @inheritdoc
     */
    protected function getMessageSymbol()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    protected function getQuestionHelper()
    {
        return new SymfonyQuestionHelper();
    }

    /**
     * @inheritdoc
     */
    protected function customizeFormatter(OutputFormatterInterface $formatter)
    {
        $formatter->setStyle('success', new OutputFormatterStyle('green'));
        $formatter->setStyle('info', new OutputFormatterStyle('cyan'));
        $formatter->setStyle('warning', new OutputFormatterStyle('yellow'));
        $formatter->setStyle('error', new OutputFormatterStyle('red'));
        $formatter->setStyle('title', new OutputFormatterStyle(null, null, ['bold']));
        return $formatter;
    }

    /**
     * @inheritdoc
     */
    public function title($message)
    {
        $this->writeln(sprintf('<title>%s</title>', $message));
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function section($message)
    {
        $this->writeln($message);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function listing(array $elements)
    {
        $this->writeln(array_map(function ($element) {
            return ' ' . $element;
        }, $elements));
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function note($message)
    {
        return $this->message($message, 'note');
    }

    /**
     * @inheritdoc
     */
    public function caution($message)
    {
        return $this->message($message, 'caution');
    }

    /**
     * @inheritdoc
     */
    public function important($message)
    {
        return $this->message($message, 'important');
    }

    /**
     * @inheritdoc
     */
    protected function addPrefixes(OutputFormatterInterface $formatter)
    {
        $this->prefixes['error'] = $formatter->format('[<error>FAIL</error>] ');
        $this->prefixes['info'] = $formatter->format('[<info>INFO</info>] ');
        $this->prefixes['success'] = $formatter->format('[<success> OK </success>] ');
        $this->prefixes['warning'] = $formatter->format('[<warning>WARN</warning>] ');
        $this->prefixes['caution'] = $formatter->format('[<error> !! </error>] ');
        $this->prefixes['note'] = $formatter->format('[<info>NOTE</info>] ');
        $this->prefixes['important'] = $formatter->format('[<warning> !! </warning>] ');
    }
}