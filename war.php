<?php
    interface iUnit 
    {
        function getUnitStats();
        function __construct($name, $health, $armour, $damage, $count);
    }
    interface iArmy 
    {
        function __construct($name);
        function getUnits();
        function addUnits($unit);
        function getArmyStats();
    }
    class Unit implements iUnit{
        private $name; 
        private $health, $armour, $damage, $count;
        public function __construct($name, $health, $armour, $damage, $count)
        {
            $this->name = $name;
            $this->health = $health;
            $this->armour = $armour;
            $this->damage = $damage;
            $this->count = $count;
        }
        public function getUnitStats() 
        {
            return array($this->health, $this->armour, $this->damage, $this->count, $this->name);
        }
    }
    class Army implements iArmy {
        private $name;
        private $units = array(); 
        private $totalHealth;
        private $totalDamage;
        private $totalArmour;
        public function __construct($name) 
        {
            $this->name = $name;
        }
        public function getUnits()
        {
            $res = "";
            foreach($this->units as $unit)
            {
                $res .= $unit->getUnitStats()[4]." (".$unit->getUnitStats()[3]."),";
            }
            return $res;
        }
        public function addUnits($unit)
        {
            array_push($this->units, $unit);
            $this->totalHealth += $unit->getUnitStats()[0] * $unit->getUnitStats()[3];
            $this->totalArmour += $unit->getUnitStats()[1] * $unit->getUnitStats()[3];
            $this->totalDamage += $unit->getUnitStats()[2] * $unit->getUnitStats()[3];      
        }
        public function getArmyStats() 
        {
            return [$this-> totalHealth, $this -> totalDamage, $this -> totalArmour, $this->name];
        }
    }
    function startBattle($army1, $army2)
    {
        $duration = 0;
        $health1 = $army1->getArmyStats()[0];
        $health2 = $army2->getArmyStats()[0];
        $damage1 = $army1->getArmyStats()[1];
        $damage2 = $army2->getArmyStats()[1];
        while ($health1 >= 0 && $health2 >= 0) {
            $health1 -= $damage2;
            $health2 -= $damage1;
            $duration++;
        }
        return array($duration, $health1, $health2);
    }
    $novgorod = new Army('Александр Ярославович');
    $sweden = new Army('Ульф Фасе');
    $novgorod-> addUnits(new Unit('Infantry', 100, 10, 10, 200));
    $novgorod-> addUnits(new Unit('Archers', 100, 5, 20, 30));
    $novgorod-> addUnits(new Unit('Cavalry', 300, 30, 30, 30));
    $sweden-> addUnits(new Unit('Infantry', 100, 10, 10, 90));
    $sweden-> addUnits(new Unit('Archers', 100, 5, 20, 65));
    $sweden-> addUnits(new Unit('Cavalry', 300, 30, 30, 25));
    $battle = startBattle($novgorod, $sweden);
?>
<table border="1">
    <tr>
        <th></th>
        <th><?=$novgorod->getArmyStats()[3]?></th>
        <th><?=$sweden->getArmyStats()[3]?></th>
    </tr>
    <tr>
        <th>Army units:</th>
        <td><?=$novgorod->getUnits()?></td>
        <td><?=$sweden->getUnits()?></td>
    </tr>
    <tr>
        <th>Health after <?=$battle[0]?> hits:</th>
        <td><?=$battle[1]?></td>
        <td><?=$battle[2]?></td>
    </tr>
    <tr>
        <th>Result</th>
        <td><?=$battle[1] > $battle[2] ? 'WINNER' : 'LOOSER'?></td>
        <td><?=$health[2] > $battle[1] ? 'WINNER' : 'LOOSER'?></td>
    </tr>
</table>