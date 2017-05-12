<?php

class UserListView
{
	private $_model = null;

	public function __construct(UserListModel $model)
	{
		$this->_model = $model;
	}

	public function render()
	{
		$html = '<div class="row">
	<div class="col-lg-10 col-md-10 col-sm-10 col-12">
		<div class="panel">
			<h4><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Benutzer</h4>
		</div>
	</div>
</div>';
		$html .= '<table class="table table-hover table-striped">';
		$html .= '<thead>';
		$html .= '<th>#</th>';
		$html .= '<th>Vorname</th>';
		$html .= '<th>Nachname</th>';
		$html .= '<th>Email</th>';
		$html .= '<th>Erstellt am</th>';
		$html .= '<th>Username</th>';
		$html .= '<th>Aktiv</th>';
		$html .= '</thead>';
		$html .= '<tbody>';

		foreach ($this->_model->listAll() as $values) {
			$html .= '<tr><td>'.$values['id'].'</td>';
			$html .= '<td>'.$values['firstname'].'</td>';
			$html .= '<td>'.$values['lastname'].'</td>';
			$html .= '<td>'.$values['email'].'</td>';
			$html .= '<td>'.strftime('%d.%m.%Y', $values['datetime']).'</td>';
			$html .= '<td>'.$values['username'].'</td>';
			$html .= '<td>'.$values['active'].'</td></tr>';
		}

		$html .= '</tbody>';

		return $html .= '</table>';
	}
}