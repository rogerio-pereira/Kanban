<?php

	abstract class TRecord2
	{
	
		protected $data;
		
		public function  __construct($codigo = NULL)
		{
			if ($codigo)
			{
				$object = $this->load($codigo);
				
				if ($object)
				{
					$this->fromArray($object->toArray());
				}
			}
		}
		
		public function __clone()
		{
			unset($this->codigo);
		}
		
		public function __set($prop, $value)
		{
			if (method_exists($this, 'set_'.$prop))
			{
				call_user_func(array($this, 'set_'.$prop), $value);
			}
			else
			{
				if($value == NULL)
				{
					unset($this->data[$prop]);
				}
				else
				{
					$this->data[$prop] = $value;
				}
			}
		}
		
		public function __get($prop)
		{
			if (method_exists($this, 'get_'.$prop))
			{
				return call_user_func(array($this, 'get_'.$prop));
			}
			else
			{
				if(isset($this->data[$prop]))
				{
					return $this->data[$prop];
				}
			}	
		}
		
		private function getEntity()
		{
			$class = get_class($this);
			return constant("{$class}::TABLENAME");
		}
		
		public function fromArray($data)
		{
			$this->data = $data;
		}
		
		public function toArray()
		{
			return $this->data;
		}
		
		public function store()
		{
			if (empty($this->data['codigo']) or (!$this->load($this->codigo))) 
			{
				/*if (empty($this->data['codigo'])) 
				{
					$this->codigo = $this->getLast() +1;
				}*/
				
				// cria instrução SQL
				$sql = new TSqlInsert;
				$sql->addEntity($this->getEntity());
				// percorre dados do objeto
				foreach ( $this->data as $key => $value )
				{
					// passa os dados do objeto para o SQL
					$sql->setRowData($key, $this->$key);
				}
			}
			else
			{
				// cria instru��o UPDATE
				$sql = new TSqlUpdate;
				$sql->addEntity($this->getEntity());
				
				$criteria = new TCriteria;
				$criteria->add(new TFilter('codigo', ' = ', $this->codigo));
				$sql->setCriteria($criteria);
				// percorre dados do objeto
				foreach ( $this->data as $key => $value )
				{
					if ($key !== 'codigo') {
						// passa os dados do objeto para o SQL
						$sql->setRowData($key, $this->$key);
					}
				}				
			}
				
			if ( $conn = TTransaction2::get() ) 
			{
				$result = $conn->exec($sql->getInstruction());
				return $result;
			}
			else
			{
				throw new Exception('Não há transação ativa');
			}
		}
		
		public function load($codigo)
		{
			// cria instrução SQL
			$sql = new TSqlSelect;
			$sql->addEntity($this->getEntity());
			$sql->addColumn('*');
			
			$criteria = new TCriteria;
			$criteria->add(new TFilter('codigo', '=', $codigo));
			$sql->setCriteria($criteria);
			
			if ( $conn = TTransaction2::get() ) 
			{
				$result = $conn->query($sql->getInstruction());
				if ( $result )
				{
					$object = $result->fetchObject(get_class($this));
				}
				return $object;
			}
			else
			{
				throw new Exception('Não há transação ativa');
			}
		}
		
		public function delete($codigo = NULL)
		{
		
			$codigo = $codigo ? $codigo : $this->codigo;
			
			// cria instrução SQL
			$sql = new TSqlDelete;
			$sql->addEntity($this->getEntity());
			
			$criteria = new TCriteria;
			$criteria->add(new TFilter('codigo', '=', $codigo));
			$sql->setCriteria($criteria);	

			if ( $conn = TTransaction2::get() ) 
			{
				$result = $conn->exec($sql->getInstruction());

				return $result;
			}
			else
			{
				throw new Exception('Não há transação ativa');
			}			
		}
		
		private function getLast()
		{
			if ( $conn = TTransaction2::get() ) 
			{
				// cria instrução SQL
				$sql = new TSqlSelect;
				$sql->addColumn('max(codigo) as codigo');
				$sql->addEntity($this->getEntity());			
			
				$result = $conn->query($sql->getInstruction());
				$row = $result->fetch();
				
				return $row[0];
			}
			else
			{
				throw new Exception('Não há transação ativa');
			}			
		}
	}
?>