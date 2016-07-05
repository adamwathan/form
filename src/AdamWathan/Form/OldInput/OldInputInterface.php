<?php

namespace AdamWathan\Form\OldInput;

/**
 * Interface OldInputInterface
 * @package AdamWathan\Form\OldInput
 */
interface OldInputInterface
{
    public function hasOldInput();

	/**
	 * @param $key
	 * @return mixed
	 */
	public function getOldInput($key);
}
