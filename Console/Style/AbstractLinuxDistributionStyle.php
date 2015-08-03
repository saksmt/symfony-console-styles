<?php

namespace Smt\Component\Console\Style;

use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\OutputStyle;

/**
 * Base class for all linux distribution styles
 * @package Smt\Component\Console\Style
 */
abstract class AbstractLinuxDistributionStyle extends OutputStyle implements ImprovedStyleInterface
{

    /**
     * @var InputInterface
     */
    private $in;

    /**
     * @var ProgressBar
     */
    private $progressBar;

    /**
     * @var string[]
     */
    protected $prefixes = [];

    /**
     * @var QuestionHelper
     */
    private $questionHelper;

    /**
     * @return string
     */
    abstract protected function getMessageSymbol();

    /**
     * @return QuestionHelper
     */
    abstract protected function getQuestionHelper();

    /**
     * @param OutputFormatterInterface $formatter
     * @return OutputFormatterInterface
     */
    abstract protected function customizeFormatter(OutputFormatterInterface $formatter);

    /**
     * @param OutputInterface $out
     * @param InputInterface $in
     */
    public function __construct(OutputInterface $out, InputInterface $in)
    {
        $this->in = $in;
        $output = clone $out;
        $formatter = $this->customizeFormatter($out->getFormatter());
        $output->setFormatter($formatter);
        foreach (['success', 'info', 'warning', 'error'] as $type) {
            $this->prefixes[$type] = $formatter->format(sprintf(' <%s>%s</%s> ',
                $type,
                $this->getMessageSymbol(),
                $type));
        }
        $this->addPrefixes($formatter);
        parent::__construct($output);
    }

    /**
     * @inheritdoc
     */
    abstract public function title($message);

    /**
     * @inheritdoc
     */
    abstract public function section($message);

    /**
     * @inheritdoc
     */
    public function listing(array $elements)
    {
        return $this->nestedList($elements);
    }

    /**
     * @param string $element
     * @param int $level
     * @return $this
     */
    abstract protected function nestedListElement($element, $level = 1);

    /**
     * @inheritdoc
     */
    public function nestedList(array $elements, $level = 1)
    {
        foreach ($elements as $element) {
            if (is_array($element)) {
                $this->nestedList($element, $level + 1);
            } else {
                $this->nestedListElement($element, $level);
            }
        }
        return $this;
    }

    /**
     * @param OutputFormatterInterface $formatter
     */
    protected function addPrefixes(OutputFormatterInterface $formatter)
    {
    }

    /**
     * @inheritdoc
     */
    public function message($message, $type, $prefix = '')
    {
        $type = strtolower($type);
        if (!isset($this->prefixes[$type])) {
            throw new \InvalidArgumentException(sprintf('Message type "%s" is not defined!', $type));
        }
        if (is_array($message)) {
            $message = implode(PHP_EOL . $this->prefixes[$type] . $prefix, $message);
        }
        return $this->writeln($this->prefixes[$type] . $prefix . $message);
    }

    /**
     * @inheritdoc
     */
    public function info($message)
    {
        return $this->message($message, 'info');
    }

    /**
     * @inheritdoc
     */
    public function text($message)
    {
        return $this->info($message);
    }

    /**
     * @inheritdoc
     */
    public function success($message)
    {
        return $this->message($message, 'success');
    }

    /**
     * @inheritdoc
     */
    public function error($message)
    {
        return $this->message($message, 'error');
    }

    /**
     * @inheritdoc
     */
    public function warning($message)
    {
        return $this->message($message, 'warning');
    }

    /**
     * @inheritdoc
     */
    abstract public function note($message);

    /**
     * @inheritdoc
     */
    abstract public function caution($message);

    /**
     * @inheritdoc
     */
    abstract public function important($message);

    /**
     * @inheritdoc
     */
    public function table(array $headers, array $rows)
    {
        $table = new Table($this);
        $table->setHeaders($headers);
        $table->setRows($rows);
        $table->render();
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function ask($question, $default = null, $validator = null)
    {
        return $this->askQuestion((new Question($question, $default))
            ->setValidator($validator));
    }

    /**
     * @inheritdoc
     */
    public function askHidden($question, $validator = null)
    {
        return $this->askQuestion((new Question())
            ->setHidden(true)
            ->setValidator($validator));
    }

    /**
     * @inheritdoc
     */
    public function confirm($question, $default = true)
    {
        return $this->askQuestion(new ConfirmationQuestion($question, $default));
    }

    /**
     * @inheritdoc
     */
    public function choice($question, array $choices, $default = null)
    {
        return $this->askQuestion(new ChoiceQuestion($question, $choices, $default));
    }

    /**
     * @inheritdoc
     */
    public function newLine($count = 1)
    {
        return $this->write(str_repeat(PHP_EOL, $count));
    }

    /**
     * @inheritdoc
     */
    public function progressStart($max = 0)
    {
        $this->progressBar = $this->createProgressBar($max);
        $this->progressBar->start();
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function progressAdvance($step = 1)
    {
        $this->getProgressBar()->advance($step);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function progressFinish()
    {
        $this->getProgressBar()->finish();
        $this->newLine(2);
        $this->progressBar = null;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function createProgressBar($max = 0)
    {
        $progressBar = parent::createProgressBar($max);

        if ('\\' === DIRECTORY_SEPARATOR) {
            $progressBar->setEmptyBarCharacter('░'); // light shade character \u2591
            $progressBar->setProgressCharacter('');
            $progressBar->setBarCharacter('▓'); // dark shade character \u2593
        }

        return $progressBar;
    }

    /**
     * @inheritdoc
     */
    public function getProgressBar()
    {
        return $this->progressBar;
    }

    /**
     * @param Question $question
     * @return string|bool|number
     */
    private function askQuestion(Question $question)
    {
        if (!isset($this->questionHelper)) {
            $this->questionHelper = $this->getQuestionHelper();
        }

        return $this->questionHelper->ask($this->in, $this, $question);
    }

    /**
     * @inheritdoc
     */
    public function write($message, $newline = false, $type = self::OUTPUT_NORMAL)
    {
        parent::write($message, $newline, $type);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function writeln($message, $type = self::OUTPUT_NORMAL)
    {
        parent::writeln($message, $type);
        return $this;
    }

    /** @inheritdoc */
    public function isQuiet()
    {
        return $this->getVerbosity() >= self::VERBOSITY_QUIET;
    }

    /** @inheritdoc */
    public function isVerbose()
    {
        return $this->getVerbosity() >= self::VERBOSITY_VERBOSE;
    }

    /** @inheritdoc */
    public function isVeryVerbose()
    {
        return $this->getVerbosity() >= self::VERBOSITY_VERY_VERBOSE;
    }

    /** @inheritdoc */
    public function isDebug()
    {
        return $this->getVerbosity() >= self::VERBOSITY_DEBUG;
    }
}