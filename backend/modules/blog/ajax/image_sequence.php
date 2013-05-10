<?php

/*
 * This file is part of Fork CMS.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

/**
 * @author Dieter Vanden Eynde <dieter.vandeneynde@wijs.be>
 */
class BackendBlogAjaxImageSequence extends BackendBaseAJAXAction
{
	public function execute()
	{
		$newIdSequence = SpoonFilter::getPostValue('new_id_sequence', null, '');
		if($newIdSequence == '') $this->output(self::ERROR, null, BL::getError('InvalidParameters'));

		// loop id's and set new sequence
		$ids = (array) explode(',', rtrim($newIdSequence, ','));

		foreach($ids as $i => $id)
		{
			$id = (int) $id;
			$item['sequence'] = $i + 1;
			if(BackendBlogModel::existsImage($id)) BackendBlogModel::updateImage($id, $item);
		}

		$this->output(self::OK, null, 'sequence updated');
	}
}
