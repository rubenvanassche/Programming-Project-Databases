<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class updateDB extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'updateDB';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Calls the crawler\'s updateDB method.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		// Call the update function.
		$now = new DateTime();
		echo "=== UPDATING DATABASE ===";
		echo "\n";
		CrawlerController::update();
		echo "=== UPDATING FINISHED ===";
		echo "\n";
		echo "=== PROCESSING BETS ===";
		echo "\n";
		$result = Bet::processAllBets($now);
		if ($result['matchCount'] == 0)
			echo "No bets processed";
		else
			echo $result['betCount'] . " bet(s) from " . $result['matchCount'] . " match(es) processed";
		echo "\n";
		echo "=== FINISHED ===";
		echo "\n";
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
