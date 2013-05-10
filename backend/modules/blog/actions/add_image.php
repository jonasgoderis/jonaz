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
class BackendBlogAddImage extends BackendBaseActionAdd
{
	/**
	 * @var int
	 */
	protected $postId;

	public function execute()
	{
		parent::execute();

		$this->loadData();
		$this->loadForm();
		$this->validateForm();

		$this->parse();
		$this->display();
	}

	protected function loadData()
	{
		$this->postId = SpoonFilter::getGetValue('post_id', null, 0, 'int');

		if($this->postId == 0 || !BackendBlogModel::exists($this->postId))
		{
			$this->redirect(BackendModel::createURLForAction('index') . '&error=non-existing');
		}
	}

	protected function loadForm()
	{
		$this->frm = new BackendForm('add');
		$this->frm->addText(
			'title', null, null, 'inputText title', 'inputTextError title'
		);
		$this->frm->addImage('image');
	}

	protected function validateForm()
	{
		if($this->frm->isSubmitted())
		{
			$this->frm->cleanupFields();

			// validation
			$fields = $this->frm->getFields();
			$fields['title']->isFilled(BL::err('FieldIsRequired'));
			$fields['image']->isFilled(BL::err('FieldIsRequired'));

			if($this->frm->isCorrect())
			{
				$item['post_id'] = $this->postId;
				$item['title'] = $fields['title']->getValue();
				$item['image'] = SpoonFilter::urlise($item['title'] . ' ' . time()) . '.' . $fields['image']->getExtension();
				$item['sequence'] = BackendBlogModel::getMaxImageSequence($item['post_id']) + 1;
				$item['created_on'] = BackendModel::getUTCDate();

				$sizes = BackendBlogModel::getImageSizes();
				$imagesPath = FRONTEND_FILES_PATH . '/blog/images';
				foreach($sizes as $size)
				{
					$fullFilename = $imagesPath . '/' . $size['name'] . '/' . $item['image'];
					$fields['image']->createThumbnail(
						$fullFilename, $size['width'],
						$size['height'], true, false
					);
				}
				$fields['image']->moveFile($imagesPath . '/source/' . $item['image']);

				$item['id'] = BackendBlogModel::insertImage($item);

				$this->redirect(
					BackendModel::createURLForAction('edit') . '&id=' . $item['post_id'] . '&report=added&highlight=row-' . $item['id'] . '&var=' . $item['title'] . '#tabImages'
				);
			}
		}
	}
}
