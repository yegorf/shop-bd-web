<?php
/**
 * Created by PhpStorm.
 * User: yegor
 * Date: 03.11.2018
 * Time: 13:35
 */

class DbHandler {
    private $table;

    public function addForm() {
        mysql_connect("212.66.38.153:33306", "egor", "zxQcMUOKaDdXjmwy");
        mysql_select_db("shop");

        $result = mysql_query("SHOW COLUMNS FROM ".$this->table);
        if (!$result) {
            echo 'Ошибка при выполнении запроса: ' . mysql_error();
            exit;
        }

        echo "<form method='get' action='' align='right'>";
        echo "<h1>Добавление записи:</h1></br>";

        $arr = array();
        $i = 0;

        while ($row = mysql_fetch_assoc($result)) {
            echo $row[Field] . "</br>";
            echo "<input type='text' name = '{$row[Field]}'/>";
            echo "</br>";
            $arr[$i] = $row[Field];
            $i++;
        }

        echo "<input type='submit' name='done' value='Добавить'>";
        echo "</form>";

        $this->addToDb($arr);
        mysql_close();
    }

    public function addToDb($arr) {
        $insert = "INSERT INTO ".$this->table." (";

        for($i = 0; $i < count($arr); $i++) {
            if($i != count($arr)-1) {
                $insert = $insert . $arr[$i] . ", ";
            } else {
                $insert = $insert . $arr[$i] . ") VALUES(";
            }
        }

        for($i = 0; $i < count($arr); $i++) {
            if($i != count($arr)-1) {
                $insert = $insert ."'".$_GET[$arr[$i]]."'". ", ";
            } else {
                $insert = $insert ."'".$_GET[$arr[$i]]."'". ")";
            }
        }
        mysql_query($insert);
        mysql_close();
    }

    public function showAllTables() {
        mysql_connect("212.66.38.153:33306", "egor", "zxQcMUOKaDdXjmwy");
        mysql_select_db("shop");
        $result = mysql_query("SHOW TABLES FROM shop");

        echo "<form method='post' action=''>";
        echo "<select name='home' onchange='this.form.submit()'>";
        echo "<option> look here </option>";
        while ($row = mysql_fetch_row($result)) {
            echo "<option value = '$row[0]' > $row[0] </option>";
        }
        echo "</select>";
        echo "</form>";


        if(isset($_POST['home'])) {
            $this->table = $_POST['home'];
            $this->printAllEntries($this->table);
        }

        mysql_close();
    }

    public function printAllEntries($tableName) {
        $connection = mysql_connect("212.66.38.153:33306", "egor", "zxQcMUOKaDdXjmwy");
        $db = mysql_select_db("shop");
        mysql_query(" SET NAMES 'utf8 ");

        if(!$connection || !$db) {
            exit(mysql_error());
        }

        $result = mysql_query("SELECT * FROM ".$tableName);

        echo '<table border="1" cellpadding="5" style="border-collapse: collapse;" align="left">';

        $printed_headers = false;
        while($row = mysql_fetch_assoc($result))
        {
            if (!$printed_headers) {
                echo "<tr>";
                foreach (array_keys($row) as $header)
                {
                    echo "<th>$header</th>";
                }
                echo "</tr>";
                $printed_headers = true;
            }

            echo "<tr>";
            foreach ($row as $val)
            {
                echo "<td>$val</td>";
            }
            echo "</tr>";
        }
        echo '</table>';

        mysql_close();
    }
}