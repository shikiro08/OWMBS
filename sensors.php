<?php
class RelayEvents {
  private $link = '';

  function __construct($valve_id) {
    $this->connect();
    $this->storeInDB($valve_id);
  }

  function connect() {
    $this->link = mysqli_connect('localhost', 'u911639940_root', 'D3@th089', 'u911639940_OWMBS') or die('Cannot connect to the DB');
  }


  function storeInDB($valve_id) {
    $valve_id = mysqli_real_escape_string($this->link, $valve_id);

    $query = "INSERT INTO relay_events (valve_id) VALUES ('$valve_id')";
    $result = mysqli_query($this->link, $query);
    if (!$result) {
      die('Errant query: ' . $query . '. Error: ' . mysqli_error($this->link));
    } else {
      echo 'Data inserted successfully';
    }
  }

  function closeConnection() {
    mysqli_close($this->link);
  }
}

if (isset($_POST['valve_id'])) {
  $relayEvent = new RelayEvents($_POST['valve_id']);
  if ($relayEvent instanceof RelayEvents) {
    echo "Connected successfully";
  } else {
    echo "Error: " . mysqli_error($relayEvent->link);
  }
  $relayEvent->closeConnection();
}


class PhEvents {
    private $link = '';

    function __construct($sensor1, $sensor2) {
        $this->connect();
        $this->storeInDB($sensor1, $sensor2);
        $this->closeConnection();
    }

    function connect() {
        $this->link = mysqli_connect('localhost', 'u911639940_root', 'D3@th089', 'u911639940_OWMBS') or die('Cannot connect to the DB');
    }

    function storeInDB($sensor1, $sensor2) {
        $sensor1 = mysqli_real_escape_string($this->link, $sensor1);
        $sensor2 = mysqli_real_escape_string($this->link, $sensor2);

        $query = "INSERT INTO sensor_data (sensor1_value, sensor2_value) VALUES ('$sensor1', '$sensor2')";
        $result = mysqli_query($this->link, $query);

        if (!$result) {
            die('Errant query: ' . $query . '. Error: ' . mysqli_error($this->link));
        } else {
            echo 'Data inserted successfully';
        }
    }

    function closeConnection() {
        mysqli_close($this->link);
    }
}

if (isset($_POST['sensor1']) && isset($_POST['sensor2'])){
    $PhEvents = new PhEvents($_POST['sensor1'], $_POST['sensor2']);

    // Perform the success/error check using $monitorings->link
    if ($PhEvents) {
        echo "Connected successfully";
    } else {
        echo "Error: " . mysqli_error($PhEvents->link);
    }

}

class waterlevel{
  private $link = '';

  function __construct($ultra_id){
    $this->connect();
    $this->storeInDB($ultra_id);
    $this->closeConnection();
  }

  function connect() {
    $this->link = mysqli_connect('localhost', 'u911639940_root', 'D3@th089', 'u911639940_OWMBS') or die('Cannot connect to the DB');
  }
  
  function storeInDB($ultra_id){
    $ultra_id = mysqli_real_escape_string($this->link, $ultra_id);

    $query = "INSERT into waterLevel (water_Level) values ('$ultra_id')";
    $result = mysqli_query($this->link, $query);

    if (!$result) {
    die('Errant query: ' . $query . '. Error .' . mysqli_error($this->link));
  }else{
     echo 'Data inserted successfully';
  }
  }

  function closeConnection() {
        mysqli_close($this->link);
    }

}

if (isset($_POST['ultra_id'])) {
    $waterlevel = new waterlevel($_POST['ultra_id'], $_POST['ultra_id']);

    // Perform the success/error check using $monitorings->link
    if ($waterlevel) {
        echo "Connected successfully";
    } else {
        echo "Error: " . mysqli_error($waterlevel->link);
    }

}

?>
