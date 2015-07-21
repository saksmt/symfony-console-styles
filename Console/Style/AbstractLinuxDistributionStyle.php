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

abstract class AbstractLinuxDistributionStyle extends OutputStyle
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
     * @return $this
     */
    abstract public function title($message);

    /**
     * @inheritdoc
     * @return $this
     */
    abstract public function section($message);

    /**
     * @inheritdoc
     * @return $this
     */
    abstract public function listing(array $elements);

    /**
     * @param OutputFormatterInterface $formatter
     */
    protected function addPrefixes(OutputFormatterInterface $formatter)
    {
        ;
    }

    /**
     * @param string|array $message
     * @param string $type
     * @param string $prefix
     * @return $this
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
        $this->writeln($this->prefixes[$type] . $prefix . $message);
        return $this;
    }

    /**
     * @param string|array $message
     * @return $this
     */
    public function info($message)
    {
        $this->message($message, 'info');
        return $this;
    }

    /**
     * @inheritdoc
     * @return $this
     */
    public function text($message)
    {
        return $this->info($message);
    }

    /**
     * @inheritdoc
     * @return $this
     */
    public function success($message)
    {
        $this->message($message, 'success');
        return $this;
    }

    /**
     * @inheritdoc
     * @return $this
     */
    public function error($message)
    {
        $this->message($message, 'error');
        return $this;
    }

    /**
     * @inheritdoc
     * @return $this
     */
    public function warning($message)
    {
        $this->message($message, 'warning');
        return $this;
    }

    /**
     * @inheritdoc
     * @return $this
     */
    abstract public function note($message);

    /**
     * @inheritdoc
     * @return $this
     */
    abstract public function caution($message);

    /**
     * @param string $message
     * @return $this
     */
    abstract public function important($message);

    /**
     * @inheritdoc
     * @return $this
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
     * @return $this
     */
    public function newLine($count = 1)
    {
        $this->write(str_repeat(PHP_EOL, $count));
        return $this;
    }

    /**
     * @inheritdoc
     * @return $this
     */
    public function progressStart($max = 0)
    {
        $this->progressBar = $this->createProgressBar($max);
        $this->progressBar->start();
        return $this;
    }

    /**
     * @inheritdoc
     * @return $this
     */
    public function progressAdvance($step = 1)
    {
        $this->getProgressBar()->advance($step);
        return $this;
    }

    /**
     * @inheritdoc
     * @return $this
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
     * @return ProgressBar
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
     * @return $this
     */
    public function write($message, $newline = false, $type = self::OUTPUT_NORMAL)
    {
        parent::write($message, $newline, $type);
        return $this;
    }

    /**
     * @inheritdoc
     * @return $this
     */
    public function writeln($message, $type = self::OUTPUT_NORMAL)
    {
        parent::writeln($message, $type);
        return $this;
    }
}