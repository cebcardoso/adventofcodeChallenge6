<?php

class ChallengeSix {
	private $inputArray;
	private $changedInputArray;
	private $totalIterations = 0;
	private $oldBuckets = array();
	
	function __construct() {
        $this->inputArray = explode(';', file_get_contents('input.txt'));
    }
	
	public function getTotalIterations() {
		return $this->totalIterations;
	}
	
	public function getInputArray() {
		return $this->inputArray;
	}
	
	public function getChangedInputArray() {
		return $this->changedInputArray;
	}

	function pr($array) {
		echo '<pre>';
		print_r($array);
		echo '</pre>';
	}

	function compare($currentIteration) {
		return in_array($currentIteration, $this->oldBuckets);
	}

	
	/*
	* Accepts input array to perform check for largest bucket
	* Checks if the updated input array has already been found before
	*/
	function check($inputArray) {
		$largest = 0;
		$currentIterationLargest = 0;
		$this->totalIterations++;
		array_push($this->oldBuckets, implode(';', $inputArray));
		
		foreach($inputArray as $iteration => $bucketValue) {
			if ($bucketValue > $largest) {
				$largest = $bucketValue;
				$currentIterationLargest = $iteration;
			}
		}
		
		$this->change($inputArray, $currentIterationLargest, $largest);
		
		if (!$this->compare(implode(';', $this->changedInputArray))) {
			$this->check($this->changedInputArray);
		}
	}
	
	/*
	* Accepts array to change along with the position of bucket and number in the bucket
	* Updates the original array to newly changed array
	*/
	function change($inputArray, $position, $amount) {
		$inputArray[$position] = 0;
		$this->changedInputArray = $inputArray;
		$bucketCount = 0;
		
		for ($k = 0; $k < $amount; $k++) {
			foreach ($this->changedInputArray as $iterationPosition => $bucketValue) {
				// start from the position of the largest bucket
				if ($iterationPosition <= $position && $k == 0) continue;
				
				// only does iteration as long as number of buckets changed matches largest value
				if ($bucketCount < $amount) {
					$bucketCount++;
					$this->changedInputArray[$iterationPosition] += 1;
				}
			}
		}
	}
}

	$challengeSix = new ChallengeSix();
	$challengeSix->check($challengeSix->getInputArray());
	echo "Number of iterations: " . $challengeSix->getTotalIterations();
?>