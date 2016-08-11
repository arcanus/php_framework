<?php
ini_set('display_errors', 'On');
require_once('core/connection.php');
require_once('vendor/autoload.php');

//Las entidades deben extender la entidad base BaseEntity
//para así heredar sus métodos y atributos.
class employeeEntity
{
//--------------------------------PROPIEDADES----------------------------------//
	private $name;
	private $pass;
//-------------------------------------------------------------------------------

//-------------------------------CONSTRUCTORES-----------------------------------
	public function __construct(
		$name = null,
		$pass = null,
		)
	{

		$this->setId(null);
		$this->setName($name);
		$this->setPass($pass);
		$this->setIs_active(1);
	}
	//-------------------------------------------------------------------------------

	//-------------------------------GETERS/SETERS-----------------------------------
	public function getId()
	{
		return $this->id;
	}

	public function setId($value)
	{
		$this->id = $value;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setName($value)
	{
		$this->name = $value;
	}

	public function getPass()
	{
		return $this->pass;
	}

	public function setPass($value)
	{
		$this->pass = $value;
	}

	public function getIs_active()
	{
		return $this->is_active;
	}

	public function setIs_active($value)
	{
		$this->is_value = $value;
	}

	//-------------------------------------------------------------------------------

	//---------------------------------METODOS---------------------------------------
	private function validate()
	{
		if (
			isset($this->name)
			&& isset($this->pass)
			&& isset($this->is_active)
			)
			{
				return true;
			}
			else
			{
				return false;
			}
	}

	public function insert()
	{
		try
		{
			if ($this->validate())
			{
				$conn = connection::connect();
				$fpdo = new FluentPDO($conn);

				$values = array(
					'name' => $this->name,
					'pass' => $this->pass,
					'is_active' => $this->is_active
				);

				$query = $fpdo->insertInto(self::getTableName())->values($values);
				$resul = $query->execute();

				$query = null;
				$fpdo = null;
				$conn = null;

				$this->id = $resul;

				return true;
			}
			else
			{
				return null;
			}
		} catch (Exception $e) {
			die("ERROR: " . $e->getMessage());
		}
	}

	public function delete()
	{
		try
		{
			if (isset($this->id))
			{
				$conn = connection::connect();
				$fpdo = new FluentPDO($conn);

				$sql = $fpdo->update(self::getTableName())
										->set(array('is_active' => 0))
										->where('id', $this->id);

				$sql->execute();

				$query = null;
				$fpdo = null;
				$conn = null;

				return true;
			}
			else
			{
				return null;
			}
		} catch (Exception $e) {
			die("ERROR: " . $e->getMessage());
		}
	}

	//---------------------------------METODOS ESTATICOS-----------------------------
	public static function getTableName()
	{
		return chop(basename(__FILE__, '.php'), 'Entity');
	}

	public static function getAll()
	{
		try
		{
			$conn = connection::connect();
			$fpdo = new FluentPDO($conn);

			$resul = $fpdo->from(self::getTableName())->where('is_active', 1);
			$fpdo = null;
			$conn = null;

			if($resul)
			{
				return $resul->fetchAll();
			}
			else
			{
				return null;
			}
		} catch (Exception $e) {
			die("ERROR: " . $e->getMessage());
		}
	}

}
