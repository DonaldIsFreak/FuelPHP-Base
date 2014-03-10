<?php

class View_Home_Hello extends ViewModel
{

	public function view()
	{
		$this->name = $this->request()->param('name', 'World');
	}
}
