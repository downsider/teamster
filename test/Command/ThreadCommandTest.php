<?php

namespace Lexide\Teamster\Test\Command;

use Lexide\Teamster\Command\ThreadCommand;
use Lexide\Teamster\Pool\Runner\RunnerFactory;
use Lexide\Teamster\Pool\Runner\RunnerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputDefinition;

/**
 *
 */
class ThreadCommandTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Mockery\Mock|RunnerFactory
     */
    protected $runnerFactory;

    /**
     * @var \Mockery\Mock|RunnerInterface
     */
    protected $runner;

    /**
     * @var \Mockery\Mock|InputDefinition $input
     */
    protected $inputDefinition;

    /**
     * @var \Mockery\Mock|InputInterface $input
     */
    protected $input;

    /**
     * @var \Mockery\Mock|OutputInterface $input
     */
    protected $output;

    protected $argList = [
        "threadCommand" => "runner:command",
        "type" => "console",
        "maxRunCount" => 3
    ];

    public function setup()
    {
        $this->runner = \Mockery::mock("Lexide\\Teamster\\Pool\\Runner\\RunnerInterface")->shouldIgnoreMissing();

        $this->runnerFactory = \Mockery::mock("Lexide\\Teamster\\Pool\\Runner\\RunnerFactory")->shouldIgnoreMissing();


        $this->inputDefinition = \Mockery::mock("Symfony\\Component\\Console\\Input\\InputDefinition");

        $this->input = \Mockery::mock("Symfony\\Component\\Console\\Input\\InputInterface");
        $this->output = \Mockery::mock("Symfony\\Component\\Console\\Output\\OutputInterface");
    }

    public function testSignature()
    {
        $this->inputDefinition->shouldReceive("addArgument")->times(3);

        $this->runnerFactory->shouldReceive("createRunner")->andReturn($this->runner);

        $commandName = "thread:command";

        $command = new ThreadCommand($commandName, $this->runnerFactory);
        $command->setDefinition($this->inputDefinition);
        $command->configure();
        $this->assertEquals($commandName, $command->getName());
    }

    public function testExecuteCommand()
    {
        foreach ($this->argList as $arg => $value) {
            $this->input->shouldReceive("getArgument")->with($arg)->once()->andReturn($value);
        }
        $this->runnerFactory->shouldReceive("createRunner")->withArgs([$this->argList["type"], "", $this->argList["maxRunCount"]])->once()->andReturn($this->runner);
        $this->runner->shouldReceive("execute")->withArgs([$this->argList["threadCommand"]])->once();

        $command = new ThreadCommand("thread:command", $this->runnerFactory);
        $command->execute($this->input, $this->output);
    }

}
