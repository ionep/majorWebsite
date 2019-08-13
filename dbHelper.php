<?php
	class Database
	{
		private $dbUser='root';
		private $dbPass='';
		private $host='mysql:dbname=Hexflood;host=localhost';
		private $conn;
		public function __construct()
		{
			try{
				$this->conn=new PDO($this->host,$this->dbUser,$this->dbPass);
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}
		}
		
		public function fetchByDay($day)
		{
			
			$data = array();
			
			$i=0;
			$conn=$this->conn;
			$sql="SELECT * FROM riverlevel WHERE dd='$day'";
			foreach($conn->query($sql) as $row)
			{
				$data[$i]=$row;
				$i++;
			}
			if(!empty($data))
			{
				return $data;
			}
			else
			{
				return false;
			}
		}

		public function fetchByMonth($month)
		{
			
			$data = array();
			
			$i=0;
			$conn=$this->conn;
			$sql="SELECT data,dd FROM riverlevel WHERE mm='$month'";
			foreach($conn->query($sql) as $row)
			{
				$data[$i]=$row;
				$i++;
			}
			if(!empty($data))
			{
				return $data;
			}
			else
			{
				return false;
			}
		}

		public function fetchByYear($year)
		{
			$data = array();
			
			$i=0;
			$conn=$this->conn;
			$sql="SELECT * FROM riverlevel WHERE yy='$year' AND mm=8";
			foreach($conn->query($sql) as $row)
			{
				$data[$i]=$row;
				$i++;
			}
			if(!empty($data))
			{
				return $data;
			}
			else
			{
				return false;
			}
		}

		public function fetchByLocation($location)
		{
			
			$data = array();
			
			$i=0;
			$conn=$this->conn;
			$sql="SELECT data FROM riverlevel WHERE location='$location' ORDER BY sn DESC LIMIT 1";
			foreach($conn->query($sql) as $row)
			{
				$data[$i]=$row;
				$i++;
			}
			if(!empty($data))
			{
				return $data[0];
			}
			else
			{
				return false;
			}
		}

		public function fetchPrediction(){
			$data = array();
			$now=time();
			$i=0;
			$conn=$this->conn;
			$sql="SELECT * FROM warning WHERE datetime>'$now' ORDER BY datetime ASC";
			foreach($conn->query($sql) as $row)
			{
				$row[1]=$row[1]-$now;
				$data[$i]=$row;
				$i++;
			}
			if(!empty($data))
			{
				return $data;
			}
			else
			{
				return false;
			}
		}

		public function addData($dat)
		{
			if(isset($dat['data']))
			{
				$data=htmlentities($dat['data']);
				$dd=htmlentities($dat['dd']);
				$mm=htmlentities($dat['mm']);
				$yy=htmlentities($dat['yy']);
				$location=htmlentities($dat['location']);
				
				
				$conn=$this->conn;
				try{

						$dat=[];
						$sql="SELECT * FROM riverlevel WHERE  dd='$dd' AND mm='$mm' AND yy='$yy' AND location ='$location';  ";
						foreach($conn->query($sql) as $row)
						{
							$dat=$row;
						}
						$dat=array();
						if(!empty($dat))
						{
							//$mm+=(int)$student[0];
						
							$sql="UPDATE riverlevel SET data='$data' WHERE dd='$dd' AND mm='$mm' AND yy='$yy' AND location='$location'";
							$conn->query($sql);
						}
				
						else
						{
							$sql="INSERT INTO riverlevel(data,dd,mm,yy,location) VALUES (:data,:dd,:mm,:yy,:location)";
							$stmt=$conn->prepare($sql);
							$stmt->bindValue('data',$data);
							$stmt->bindValue('dd',$dd);
							$stmt->bindValue('mm',$mm);
							$stmt->bindValue('yy',$yy);
							$stmt->bindValue('location',$location);
							$stmt->execute();
						}
						return true;
					
				}
				catch(PDOException $e)
				{
					return false;
					echo $e->getMessage();
				}
			}
			else if(isset($dat['delay'])){
				$delay=htmlentities($dat['delay']);
				$rise=htmlentities($dat['rise']);

				$predicted=time()+$delay;
				
				$conn=$this->conn;
				try{
					$sql="INSERT INTO warning(datetime,rise) VALUES (:datetime,:rise)";
					$stmt=$conn->prepare($sql);
					$stmt->bindValue('datetime',$predicted);
					$stmt->bindValue('rise',$rise);
					$stmt->execute();
					return true;
				}
				catch(PDOException $e)
				{
					return false;
					echo $e->getMessage();
				}
			}
		}
		

	}
?>
