<?php

/*
 * This file is part of Fork CMS.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

/**
 * @author Jonas Goderis <jonasgoderis@telenet.be>
 */
class BackendBlogDeleteImage extends BackendBaseActionDelete
{
	public function execute()
	{
		$this->id = $this->getParameter('id', 'int');
		if($this->id !== null && BackendBlogModel::existsImage($this->id))
		{
			parent::execute();

			$this->record = BackendBlogModel::getImage($this->id);

			BackendBlogModel::deleteImage($this->id);

			$this->redirect(
				BackendModel::createURLForAction('edit') . '&id=' . $this->record['post_id'] . '&report=deleted&var=' . urlencode($this->record['title']) . '#tabImages'
			);
		}
		else $this->redirect(BackendModel::createURLForAction('index') . '&error=non-existing');
	}
}
