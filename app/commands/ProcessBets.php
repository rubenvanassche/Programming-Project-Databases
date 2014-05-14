<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ProcessBets extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ProcessBets';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'All bets processed if possible';

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
		$result = Bet::processAllBets();
		if ($result['matchCount'] == 0)
			echo "No bets processed";
		else
			echo $result['betCount'] . " bet(s) from " . $result['matchCount'] . " match(es) processed";
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
		return array();
	}

}
