<?php

namespace AdamWathan\Form\ErrorStore;

/**
 * Interface ErrorStoreInterface
 * @package AdamWathan\Form\ErrorStore
 */
interface ErrorStoreInterface
{
	/**
	 * @param $key
	 * @return mixed
	 */
	public function hasError($key);

	/**
	 * @param $key
	 * @return mixed
	 */
	public function getError($key);
}
