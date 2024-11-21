<?php
if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");

function ShowEditBotsPage()
{
    echo '<div class="botheader"><button onclick="location.href = \'admin.php?page=EditBots\'">show bots contingents</button>
    <button onclick="location.href = \'admin.php?page=EditBots&mode=show_all_bots\'">show bots</button> 
    <button onclick="location.href = \'admin.php?page=EditBots&mode= edit_bot_types\'">edit bot types</button>
    <button onclick="location.href = \'admin.php?page=EditBots&mode=edit_bot_users\'">edit bots</button>
    <button onclick="location.href = \'admin.php?page=EditBots&mode=edit_bot_planets\'">edit bot planets</button>
    <button onclick="location.href = \'admin.php?page=EditBots&mode=edit_bot_planets\'">create bots</button></div>
    <hr>
    <style> 
    .botheader { background: #555; padding: 10px; margin-bottom: 10px; }
    .botheader button { margin-right: 10px; font-size: 20px; font-weight: bold; border: 3px solid #aaa;  padding: 5px; }
    a { color: #5ef !important; } 
    td { text-align:right; padding:0px 10px; } 
    table {     background: #333;
    display: inline-block;
    vertical-align: top; } 
    .bot_type{     display: inline-block;
    background: #333;
    border: 1px solid #aaa;
    padding: 10px;
    border-radius: 10px;
    margin: 10px; }
    body { color:#fff; } 
    input{
    text-align: right;
    background: #fff;
    border: 1px solid #000;
    border-radius: 10px;
    padding-right: 10px;
    width: 100px;
    }
    button {
    margin-left: 21px;
    border: 1px solid #fff;
    margin-top: 5px;
    border-radius: 10px;
    }
    button:hover { cursor: pointer; background: #000; color: #fff; }
    table button { margin-left: 0px; }
    form { display: inline; }
    .alert{
        background: #922;
    font-weight: bold;
    color: #fff;
    padding: 10px;
    font-size: 14px;
}
    #botshead th:hover{
        cursor: pointer;
        background: #666;
        
    }
        table input{
                width: auto;
        }
    </style>';
    if (isset($_GET['mode'])) {
        if ($_GET['mode'] == 'ress_to_all_planets') {
            ress_to_all_planets();
        } elseif ($_GET['mode'] == 'set_on_all_planets') {
            set_on_all_planets();
        } elseif ($_GET['mode'] == 'make_bot_planets') {
            make_bot_planets();
        } elseif ($_GET['mode'] == 'reset_bots') {
            reset_bots();
        } elseif ($_GET['mode'] == ' edit_bot_types') {
            edit_bot_types();
        } elseif ($_GET['mode'] == 'show_all_bots') {
            show_all_bots();
        } elseif ($_GET['mode'] == 'set_bot_types') {
            set_bot_types();
        } elseif ($_GET['mode'] == 'add_ship') {
            add_ship();
        } elseif ($_GET['mode'] == 'delete_ship') {
            delete_ship();
        } elseif ($_GET['mode'] == 'set_ship_factor') {
            set_ship_factor();
        } elseif ($_GET['mode'] == 'reset_contingents') {
            reset_contingents();
            showbots();
        } elseif ($_GET['mode'] == 'edit_bot_planets') {
            edit_bot_planets();
        } elseif ($_GET['mode'] == 'edit_bot_users') {
            edit_bot_users();
        }elseif ($_GET['mode'] == 'werkseinstellungen') {
            werkseinstellungen();
        }
    } else {
        
        showbots();
    }
}



#------------------------------------pages-----------------------------------------------------

function showbots()
{
    $db = Database::get();
 
    $bot_setting_all = $db->select('select * from uni1_bot_setting');
    $all_contingent = array('full(defined)' => array('contingent' => 0, 'contingent_used' => 0),'all ress(calc)' => array('contingent' => 0, 'contingent_used' => 0),'ship_ress' => array('contingent' => 0, 'contingent_used' => 0), 'ress' => array('contingent' => 0, 'contingent_used' => 0));
    echo '<button onclick="location.href = \'admin.php?page=EditBots&mode=reset_contingents\'">reset contingents</button><hr>';
    foreach ($bot_setting_all as $key => $bot_setting) {
        echo '<h3>bot type: ' . $bot_setting['id'] . ' - ' . $bot_setting['name'] . '</h3>';
        $ships_array = unserialize($bot_setting['ships_array']);
        $all_contingent['full(defined)']['contingent'] += $bot_setting['full_contingent'];
        $all_contingent['ress']['contingent'] += $bot_setting['ress_contingent'];
        $all_contingent['full(defined)']['contingent_used'] += $bot_setting['full_contingent_used'];
        $all_contingent['ress']['contingent_used'] += $bot_setting['ress_contingent_used'];
        $all_contingent['all ress(calc)']['contingent'] += $bot_setting['ress_contingent'];
        $all_contingent['all ress(calc)']['contingent_used'] += $bot_setting['ress_contingent_used'];
        
        echo '<table><tr><th colspan="3">bot settings income</th></tr>
        <tr><th></th><th>per second</th><th>per day</th><th>per month</th></tr>
        ';
        $tmp = '';
        foreach ($ships_array as $key => $value) {
            echo '<tr><th>' . $value['name'] . ' per bot</th><td>' . pretty_number($value['per_second']) . '</td><td>' . pretty_number($value['per_second'] * 86400) . '</td><td>' . pretty_number($value['per_second'] * 2592000) . '</td></tr>';
            $tmp .= '<tr><th>' . $value['name'] . ' all bots</th><td>' . pretty_number($value['per_second'] * $bot_setting['number_of_bots']) . '</td><td>' . pretty_number($value['per_second'] * 86400 * $bot_setting['number_of_bots']) . '</td><td>' . pretty_number($value['per_second'] * 2592000 * $bot_setting['number_of_bots']) . '</td></tr>';
        }

        echo $tmp .'
    <tr><th>metal_per_bot</th><td>' . pretty_number($bot_setting['metal_per_second']) . '</td><td>' . pretty_number($bot_setting['metal_per_second']  * 86400) . '</td><td>' . pretty_number($bot_setting['metal_per_second']  * 2592000) . '</td></tr>
    <tr><th>crystal_per_bot</th><td>' . pretty_number($bot_setting['crystal_per_second']) . '</td><td>' . pretty_number($bot_setting['crystal_per_second']  * 86400) . '</td><td>' . pretty_number($bot_setting['crystal_per_second']  * 2592000) . '</td></tr>
    <tr><th>deuterium_per_bot</th><td>' . pretty_number($bot_setting['deuterium_per_second']) . '</td><td>' . pretty_number($bot_setting['deuterium_per_second']  * 86400) . '</td><td>' . pretty_number($bot_setting['deuterium_per_second']  * 2592000) . '</td></tr>
    <tr><th>ress_per_bot</th><td>' . pretty_number(($bot_setting['deuterium_per_second'] + $bot_setting['crystal_per_second'] + $bot_setting['metal_per_second'])) . '</td><td>' . pretty_number(($bot_setting['deuterium_per_second'] + $bot_setting['crystal_per_second'] + $bot_setting['metal_per_second'])  * 86400) . '</td><td>' . pretty_number(($bot_setting['deuterium_per_second'] + $bot_setting['crystal_per_second'] + $bot_setting['metal_per_second'])  * 2592000) . '</td></tr>
    <tr><th>ress_all_bots</th><td>' . pretty_number(($bot_setting['deuterium_per_second'] + $bot_setting['crystal_per_second'] + $bot_setting['metal_per_second']) * $bot_setting['number_of_bots']) . '</td><td>' . pretty_number(($bot_setting['deuterium_per_second'] + $bot_setting['crystal_per_second'] + $bot_setting['metal_per_second']) * $bot_setting['number_of_bots'] * 86400) . '</td><td>' . pretty_number(($bot_setting['deuterium_per_second'] + $bot_setting['crystal_per_second'] + $bot_setting['metal_per_second']) * $bot_setting['number_of_bots'] * 2592000) . '</td></tr>
    
    </table>';
        echo '
       <table><tr><th colspan="3">monthly bots income</th></tr>
       <tr><th></th><th>contingent</th><th>used</th><th>percent</th></tr>
       <tr title="total of ress for this bot type per month and total given ress to bot types bots since start of month(month=30 days does not start at 1.1)"><th>total output</th><td>' . pretty_number($bot_setting['full_contingent']) . '</td><td>' . pretty_number($bot_setting['full_contingent_used']) . '</td><td>' . round($bot_setting['full_contingent_used'] > 0 ? $bot_setting['full_contingent_used'] / ($bot_setting['full_contingent'] * .01) : 0, 4) . '%</td></tr>
       <tr title="all ress this bot types bots will get in one month and how much have been given since this month started"><th>ress</th><td>' . pretty_number($bot_setting['ress_contingent'])  . '</td><td>' . pretty_number($bot_setting['ress_contingent_used']) . '</td><td>' . round($bot_setting['ress_contingent_used'] > 0 ? $bot_setting['ress_contingent_used'] / ($bot_setting['ress_contingent'] * .01) : 0, 4) . '%</td></tr>
      ';
        foreach ($ships_array as $key => $value) {
            echo '<tr title="amount of '.$value['name'].' this bot type gets per month and the ships given within this month"><th>' . $value['name'] . '</th><td>' . pretty_number($value['contingent'])  . '</td><td>' . pretty_number($value['contingent_used']) . '</td><td>' . round($value['contingent_used'] > 0 ? $value['contingent_used'] / ($value['contingent'] * .01) : 0, 4) . '%</td></tr>';
            if (!isset($all_contingent[$value['name']])){ $all_contingent[$value['name']] = array('contingent' => 0, 'contingent_used' => 0); }
            $all_contingent[$value['name']]['contingent'] += $value['contingent'];
            $all_contingent[$value['name']]['contingent_used'] += $value['contingent_used'];
            $all_contingent['ship_ress']['contingent_used'] += $value['contingent_used'] * $value['shipvalue'];
            $all_contingent['ship_ress']['contingent'] += $value['contingent'] * $value['shipvalue'];
            $all_contingent['all ress(calc)']['contingent_used'] += $value['contingent_used'] * $value['shipvalue'];
            $all_contingent['all ress(calc)']['contingent'] += $value['contingent'] * $value['shipvalue'];
        }



        echo ' <tr title="one period of has 30 days. this line shows how much time since the start of the period(month) has passed"><th>30 days</th><td>' . pretty_time(2592000) . '</td><td>' . pretty_time(time() - $bot_setting['last_set']) . '</td><td>' . round((time() - $bot_setting['last_set']) > 0 ? (time() - $bot_setting['last_set']) / 25920 : 0, 4) . '%</td></tr>
       <tr title="number of bots this bot type has"><th>number of bots</th><td>' . $bot_setting['number_of_bots'] . '</td></tr>
       </table><hr>';
    }
    echo '<h3>all bots</h3><table><tr><th colspan="3">all bots income</th></tr>
       <tr><th></th><th>contingent</th><th>used</th><th>percent</th></tr>';
    foreach ($all_contingent as $key => $value) {

        echo '<tr><td>' . $key . '</td><td>' . pretty_number($value['contingent']) . '</td><td>' . pretty_number($value['contingent_used']) . '</td><td>' . round($value['contingent_used'] > 0 ? $value['contingent_used'] / ($value['contingent'] * .01) : 0, 4) . '%</td></tr>';
    }
}



#bot types
function edit_bot_types()
{

    #$botlist = $db->select('SELECT * FROM %%USERS%% WHERE is_bot = 1');

    #$botselect = '<select id="selector">';
    #foreach ($botlist as $key => $bot) {
    #    $botselect .= '<option value="' . $bot['id'] . '">' . ($key + 1) . '.' . $bot['username'] . '</option>';
    #}
    #$botselect .= '</select>';
    #echo $botselect;
    /**/
    global $resource;


    $db = Database::get();
    $bot_types = $db->select('SELECT * FROM uni1_bot_setting');
    foreach ($bot_types as $key => $bot_type) {
        echo '<div class="bot_type"><h1>' . $bot_type['id'] . '.' . $bot_type['name'] . '</h1><form method="post" action="admin.php?page=EditBots&mode=set_bot_types">';
        $ships_array = unserialize($bot_type['ships_array']);
        echo '<input type="text" name="name" value="' . $bot_type['name'] . '" title="the name of the bot type, just there for your information"><label>name</label><br>
        <input type="hidden" name="id" value="' . $bot_type['id'] . '" title="the id is how the bots are tied to the bot type, no change needed normaly, exept when want to switch settings">
        <input type="number" name="first_points_multiplicator" value="' . $bot_type['first_points_multiplicator'] . '" title="the ressource output in fleet and ress per month is the (points of the first player * first_points_multiplicator) it defines how much ressources the bots get per month. you may start with 500"><label>first_points_multiplicator</label><br>
        <input type="number" min="0" max="1" step="0.1" name="ress_factor" value="' . $bot_type['ress_factor'] . '" title="factor is used to determine how much of the monthly contingent is spend to ress , the rest is for fleet 0,1 = 10% ,sould not be more then 1"><label>ress factor</label><br>
        <input type="number" min="0" max="1" step="0.01" name="ress_value_metal" value="' . $bot_type['ress_value_metal'] . '" title="the metal factor tell how much of the resource contingent will be used for metal 0,1 = 10%"><label>metal factor</label><br>
        <input type="number" min="0" max="1" step="0.01" name="ress_value_crystal" value="' . $bot_type['ress_value_crystal'] . '" title="the crystal factor tell how much of the resource contingent will be used for crystal 0,1 = 10%"><label>crystal factor</label><br>
        <input type="number" min="0" max="1" step="0.01" name="ress_value_deuterium" value="' . $bot_type['ress_value_deuterium'] . '" title="the deuterium factor tell how much of the resource contingent will be used for deuterium 0,1 = 10%"><label>deuterium factor</label><br>
<input type="number" min="0" step="120" name="min_fleet_seconds_in_space" value="' . $bot_type['min_fleet_seconds_in_space'] . '" title="minimum time in second wich the bots fleet be save in space before landing again"><label>min fleet time in space</label><br>
<input type="number" min="0" step="120" name="max_fleet_seconds_in_space" value="' . $bot_type['max_fleet_seconds_in_space'] . '" title="maximum time in second wich the bots fleet be save in space before landing again"><label>max fleet time in space</label><br>
<input type="number" min="0" step="120" name="min_fleet_seconds_on_planet" value="' . $bot_type['min_fleet_seconds_on_planet'] . '" title="minimum time in second wich the bots fleet will hold on a planet"><label>min fleet time on planet</label><br>
<input type="number" min="0" step="120" name="max_fleet_seconds_on_planet" value="' . $bot_type['max_fleet_seconds_on_planet'] . '" title="maximum time in second wich the bots fleet will hold on a planet"><label>max fleettime on planet</label><br>
        ';
        echo '<button value="set bot types" />set bot types</button></form><br><br>bot ships:<br><table><tr><th>ship</th><th>factor</th><th>leave on planet</th><th>delete</th></tr>';
        foreach ($ships_array as $key => $value) {
            echo '<tr><td>' . $value['name'] . '</td>
            <td><input type="number"  min="0" max="1" step="0.001" name="factor" onkeyup="sendtoserver(' . $bot_type['id'] . ',\'' . $value['name'] . '\',this.value)" onchange="sendtoserver(' . $bot_type['id'] . ',\'' . $value['name'] . '\',this.value)" value="' . round(isset($value['factor']) ? $value['factor'] : (1 / count($ships_array)), 3) . '"></td>
            <td><input type="number" min="0" max="1" step="0.001" name="leave_on_planet_factor" value="'. $value['leave_on_planet'] .'"></td>
            <td><form method="post" action="admin.php?page=EditBots&mode=delete_ship"><input type="hidden" name="bot_type" value="' . $bot_type['id'] . '"><input type="hidden" name="ship" value="' . $value['name'] . '">
            <button>delete</button></form></td></tr>';
        }
        echo '</table><script>
         function sendtoserver(bot_type,ship,factor){
             var xmlhttp = new XMLHttpRequest();
             xmlhttp.open("POST", "admin.php?page=EditBots&mode=set_ship_factor", true);
             xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
             xmlhttp.send("bot_type="+bot_type+"&ship="+ship+"&factor="+factor);
         }
        
        </script><br><form method="post" action="admin.php?page=EditBots&mode=add_ship">
        <input type="hidden" name="bot_type" value="' . $bot_type['id'] . '"><select name="ship">';

        foreach ($resource as $key1 => $value1) {
            if ($key1 > 200 && $key1 < 300) {
                echo '<option value="' . $value1 . '">' . $value1 . '</option>';
            }
        }
        echo '</select><button>add new ship</button></form>';
        echo '</div>';
    }
}


function edit_bot_users()
{
    #get researchlevels, bot_type , planets and fleets
    echo '<button class="alert" onclick="location.href = \'admin.php?page=EditBots&mode=reset_bots\'">reset bots: delete all bot fleets, ress and contingents</button>
    <button class="alert" onclick="location.href = \'admin.php?page=EditBots&mode=reset_bots\'">reset ress on all bots</button>
    <button class="alert" onclick="location.href = \'admin.php?page=EditBots&mode=reset_bots\'">reset fleets on all bots</button>
    <button class="alert" onclick="location.href = \'admin.php?page=EditBots&mode=werkseinstellungen\'">reset bot types</button>
    ';
}
function edit_bot_planets()
{
    global $resource, $LNG;
    echo '
    <button class="alert" onclick="location.href = \'admin.php?page=EditBots&mode=make_bot_planets\'">make botplanets +1 for each bot(max 15) also set is_bot flag on planets of bots</button><br>
    
    ';
    echo '<hr><h3>set element on all botplanets:</h3><form method="post" action="admin.php?page=EditBots&mode=set_on_all_planets">
<select name="elementid"  onchange="updateSelectedText()">';
    foreach ($resource as $key => $value) {
        if ($key < 600) {
            if ($key < 200 && $key > 100) {
                continue;
            }
            echo '<option value="' . $key . '">' . $LNG['tech'][$key] . '</option>';
        }
    }
    echo '
</select>
   <input type="number" name="elemval" value="0" placeholder="value" />
   <button>set on all bot planets</button></form><hr>';
    echo '<h3>set resources on all botplanets:</h3><form method="post" action="admin.php?page=EditBots&mode=ress_to_all_planets">
   metal<input type="number" name="metal" value="100000" />
   crystal<input type="number" name="crystal" value="70000" />
   deut<input type="number" name="deuterium" value="0" />
   <button value="Ress to all bots" />put ress on all bot planets</button></form>';
}

#shows all bots and their fleet and ress and status with planets and fleets
function show_all_bots()
{
    
    $db = Database::get();
    $setting_ships_array = unserialize($db->select('select ships_array from uni1_bot_setting')[0]['ships_array']);
    $potplanets = $db->select('select * from uni1_planets where is_bot=1 and planet_type = 1;');

    $botfleetso = $db->select('select ships_array , owner_id,next_fleet_action,id,action_index,`bot_type` from uni1_bots');
    $botown = array();
    $bot_base_array = array('metal' => 0, 'crystal' => 0, 'deuterium' => 0, 'ress' => 0, 'planetcount' => 0,  'next_fleet_action' => time(), 'landed' => 0, 'bot_type' => 0);



    foreach ($botfleetso as $key => $value) {
        if (!isset($botown[$value['owner_id']])) {
            $botown[$value['owner_id']]  = $bot_base_array;
        }
        $ships_array = unserialize($value['ships_array']);
        foreach ($ships_array as $key => $value2) {
            $botown[$value['owner_id']][$value2['name']] = isset($botown[$value['owner_id']][$value2['name']]) ? $botown[$value['owner_id']][$value2['name']] + $value2['amount'] : $value2['amount'];
            $bot_base_array[$value2['name']] = 0;
           
        }
        $botown[$value['owner_id']]['bot_type'] = $value['bot_type'];
        $botown[$value['owner_id']]['landed'] += $value['action_index'];
        $botown[$value['owner_id']]['next_fleet_action'] = $value['next_fleet_action'];
    }
    foreach ($potplanets as $key => $value) {
        if (!isset($botown[$value['id_owner']])) {

            $botown[$value['id_owner']]  = $bot_base_array;
        }
        foreach ($setting_ships_array as $key => $value2) {
            $botown[$value['id_owner']][$value2['name']] = isset($botown[$value['id_owner']][$value2['name']]) ? $botown[$value['id_owner']][$value2['name']] + $value[$value2['name']] : $value[$value2['name']];
            $bot_base_array[$value2['name']] = 0;
        }
        $botown[$value['id_owner']]['planetcount'] += 1;
        $botown[$value['id_owner']]['metal'] += $value['metal'];
        $botown[$value['id_owner']]['crystal'] += $value['crystal'];
        $botown[$value['id_owner']]['deuterium'] += $value['deuterium'];
        $botown[$value['id_owner']]['ress'] += $value['metal'] + $value['crystal'] + $value['deuterium'];
    }
    ksort($botown);
    $output = "";
    $all_bots_own = $bot_base_array;



    foreach ($botown as $key => $value) {

        $output .= '<tr><td><a href="admin.php?page=Userpage&admpanel=1&userid=' . $key . '" target="_blank">' . $key . '</a></td>';
        foreach ($value as $key2 => $value2) {
            $all_bots_own[$key2] +=  $value2;
            if ($key2 == 'next_fleet_action') {
                $output .= '<td>' . pretty_time(abs(time() - $value2)) . '</td>';
            } else {
                $output .= '<td>' . pretty_number(round($value2)) . '</td>';
            }
        }
        $output .=  '</td></tr>';
    }

    $output1 = '';
    $output1 .= '<tr><td>all bots</td>';

    foreach ($all_bots_own as $key => $value) {
        $output1 .= '<td>' . pretty_number(round($value)) . '</td>';
    }
    $output1 .= '</tr>';
    $tablehead = '<thead id="botshead"><tr><th onclick="sortTable(0)">id</th>
    <th onclick="sortTable(1)">met</th><th   onclick="sortTable(2)">crys</th>
    <th onclick="sortTable(3)">deut</th><th onclick="sortTable(4)">ress</th><th onclick="sortTable(5)">planetcount</th>
    <th onclick="sortTable(6)">next_fleet_action</th><th onclick="sortTable(7)">1 = on planet</th><th onclick="sortTable(8)">bot_type</td>';
    $i = 8;
    foreach ($setting_ships_array as $key => $value) {
        $i++;
        $tablehead .= '<th onclick="sortTable(' . ($i) . ')">' . $value['name'] . '</th>';
    }

    $tablehead .= '</tr>';
    echo '<table id="bottable">' . $tablehead . '</thead>' . $output1 .  $output . '</table>';
    echo '
    <script>
function sortTable(columnIndex) {
    var table = document.getElementById("bottable");
    var rows = Array.from(table.rows).slice(1); // Exclude header row
rows = rows.slice(1);
    rows.sort(function(rowA, rowB) {
        var cellA = rowA.cells[columnIndex].textContent.trim();
        var cellB = rowB.cells[columnIndex].textContent.trim();

        // Attempt to convert to numbers
        var numA = cellA.replace(/\./g, ""); // Adjust for decimal separator
        var numB = cellB.replace(/\./g, "");
       
        // Check if both are numbers
        if (!isNaN(numA) && !isNaN(numB)) {
            return numB - numA; // Sort numerically (descending)
        } else {
            return cellA.localeCompare(cellB); // Sort alphabetically
        }
    });

    // Re-attach sorted rows
    rows.forEach(row => table.appendChild(row));
}
        </script>';
}


#-------------------------------------------functions----------------------------------------------------

function reset_contingents()
{
    $db = Database::get();

    $bot_setting = $db->select('select * from uni1_bot_setting');
    foreach ($bot_setting as $key => $value) {
        $bot_setting[$key]['ships_array'] = unserialize($value['ships_array']);
    }
    foreach ($bot_setting as $key => $bot_setting1) {

        $number_of_bots = count($db->select('select id as number_of_bots from uni1_bots where bot_type = :id_botsetting', array(':id_botsetting' => $bot_setting1['id'])));
        $number_of_bots_factor = $number_of_bots == 0 ? 0 : (1 / $number_of_bots);
        $month_in_seconds = 2592000;
        $monthly_resspoints = Config::get()->first_player_points * $bot_setting1['first_points_multiplicator'];
        $monthly_resspoints_for_ships = $monthly_resspoints * (1 - $bot_setting1['ress_factor']); #1-ressfactor is the factor for the ships
        #$ress_for_each_ship_type = ($monthly_resspoints_for_ships / count($bot_setting1['ships_array']));
        $montly_resspoints_for_ress = $monthly_resspoints * $bot_setting1['ress_factor'];
        $real_resspoints_for_ships = 0;
        foreach ($bot_setting1['ships_array'] as $key => $ship) {
            $ship_contingent_temp = ((($monthly_resspoints_for_ships * $ship['factor'] * $number_of_bots_factor) / $ship['shipvalue'])); #monthly available ships for each botfleet, factor reduces the ress dedicated to each shiptype
            $montly_resspoints_for_ress += floor(($monthly_resspoints_for_ships * $ship['factor'] * $number_of_bots_factor) - ($ship_contingent_temp * $ship['shipvalue']));
            $bot_setting1['ships_array'][$key]['per_second'] = $ship_contingent_temp <= 0 ? 0 : ($ship_contingent_temp / $month_in_seconds);
            $bot_setting1['ships_array'][$key]['contingent'] = $ship_contingent_temp * $number_of_bots;
            $bot_setting1['ships_array'][$key]['contingent_used'] = 0;
            $real_resspoints_for_ships += $bot_setting1['ships_array'][$key]['contingent'] * $ship['shipvalue'];
        }
        $montly_resspoints_for_ress += ($monthly_resspoints_for_ships - $real_resspoints_for_ships);#the monthly resspoits differ a liitle bit from the original, cause of rounding errors?
        $db->update(
            'update uni1_bot_setting set 
            metal_per_second = :metal_per_second, 
            crystal_per_second = :crystal_per_second, 
            deuterium_per_second = :deuterium_per_second , 
            last_set = :last_set , 
            `ress_contingent` = :ress_contingenta ,
            `ress_ships_contingent` = :ress_ships_contingent ,
            `full_contingent` = :full_contingenta , 
            `ships_array` = :ships_array , 
            `ress_contingent_used` = 0 ,
            `ress_ships_contingent_used` = 0 , 
            `full_contingent_used` = 0 ,
            `number_of_bots` = :number_of_bots
            where id = :bot_type',
            array(
                ':metal_per_second' => $montly_resspoints_for_ress <= 0 ? 0 : (($montly_resspoints_for_ress * $bot_setting1['ress_value_metal']) / $month_in_seconds) * $number_of_bots_factor, //per second per bot
                ':crystal_per_second' => $montly_resspoints_for_ress <= 0 ? 0 : (($montly_resspoints_for_ress * $bot_setting1['ress_value_crystal']) / $month_in_seconds) * $number_of_bots_factor,
                ':deuterium_per_second' => $montly_resspoints_for_ress <= 0 ? 0 : (($montly_resspoints_for_ress * $bot_setting1['ress_value_deuterium']) / $month_in_seconds) * $number_of_bots_factor,
                ':ress_contingenta' => $montly_resspoints_for_ress,
                ':ress_ships_contingent' => $real_resspoints_for_ships,
                ':full_contingenta' => $monthly_resspoints,
                ':ships_array' => serialize($bot_setting1['ships_array']),
                ':bot_type' => $bot_setting1['id'],
                ':number_of_bots' => $number_of_bots,
                ':last_set' => time()
            )
        );
    }
}

function set_bot_types()
{
    $db = Database::get();
    $db->update(
        'update uni1_bot_setting set 
    name = :name , 
    ress_value_metal = :ress_value_metal,
    ress_value_crystal = :ress_value_crystal,
    ress_value_deuterium = :ress_value_deuterium,
    first_points_multiplicator = :first_points_multiplicator,
    min_fleet_seconds_in_space = :min_fleet_seconds_in_space,
    max_fleet_seconds_in_space = :max_fleet_seconds_in_space,
    min_fleet_seconds_on_planet = :min_fleet_seconds_on_planet,
    max_fleet_seconds_on_planet = :max_fleet_seconds_on_planet
    where id = :id',
        array(
            ':name' => $_POST['name'],
            ':id' => $_POST['id'],
            ':ress_value_metal' => $_POST['ress_value_metal'],
            ':ress_value_crystal' => $_POST['ress_value_crystal'],
            ':ress_value_deuterium' => $_POST['ress_value_deuterium'],
            ':first_points_multiplicator' => $_POST['first_points_multiplicator'],
            ':min_fleet_seconds_in_space' => $_POST['min_fleet_seconds_in_space'],
            ':max_fleet_seconds_in_space' => $_POST['max_fleet_seconds_in_space'],
            ':min_fleet_seconds_on_planet' => $_POST['min_fleet_seconds_on_planet'],
            ':max_fleet_seconds_on_planet' => $_POST['max_fleet_seconds_on_planet']
        )
    );
    echo 'edited bot type: ' . $_POST['name'];
    edit_bot_types();
}


function set_on_all_planets()
{
    global $resource;
    $db = Database::get();
    $db->update('update uni1_planets set ' . $resource[$_POST['elementid']] . ' = :value where is_bot = 1', array(':value' => $_POST['elemval']));
    echo 'done: ' . $resource[$_POST['elementid']] . ' is ' . $_POST['elemval'] . ' on all botplanets now.';
}


function add_ship()
{
    global $resource, $pricelist;
    $flipressource = array_flip($resource);
    $db = Database::get();
    $bot = $db->select('select * from uni1_bot_setting where id = :id', array(':id' => $_POST['bot_type']));
    $ships_array = unserialize($bot[0]['ships_array']);
    $ships_array[$_POST['ship']] = array('name' => $_POST['ship'], 'factor' => 1 / count($ships_array), 'per_second' => 0, 'contingent' => 0, 'contingent_used' => 0, 'shipvalue' => $pricelist[$flipressource[$_POST['ship']]]['cost'][901] + $pricelist[$flipressource[$_POST['ship']]]['cost'][902] + $pricelist[$flipressource[$_POST['ship']]]['cost'][903], 'leave_on_planet' => 0);
    $db->update('update uni1_bot_setting set ships_array = :ships_array where id = :id', array(':ships_array' => serialize($ships_array), ':id' => $_POST['bot_type']));
    echo 'added ship: ' . $_POST['ship'];
    edit_bot_types();
}

function delete_ship()
{
    $db = Database::get();
    $bot = $db->select('select * from uni1_bot_setting where id = :id', array(':id' => $_POST['bot_type']));
    $ships_array = unserialize($bot[0]['ships_array']);
    unset($ships_array[$_POST['ship']]);
    $db->update('update uni1_bot_setting set ships_array = :ships_array where id = :id', array(':ships_array' => serialize($ships_array), ':id' => $_POST['bot_type']));
    echo 'deleted ship: ' . $_POST['ship'];
    edit_bot_types();
}

function set_ship_factor()
{
    $db = Database::get();
    $bot = $db->select('select * from uni1_bot_setting where id = :id', array(':id' => $_POST['bot_type']));
    $ships_array = unserialize($bot[0]['ships_array']);
    $ships_array[$_POST['ship']]['factor'] = $_POST['factor'];
    $db->update('update uni1_bot_setting set ships_array = :ships_array where id = :id', array(':ships_array' => serialize($ships_array), ':id' => $_POST['bot_type']));
    echo 'edited ship: ' . $_POST['ship'];
    edit_bot_types();
}

function ress_to_all_planets()
{
    $metal = $_POST['metal'];
    $crystal = $_POST['crystal'];
    $deuterium = $_POST['deuterium'];
    $db = Database::get();
    $botlist = $db->select('SELECT * FROM %%USERS%% WHERE is_bot = 1');
    foreach ($botlist as $key => $bot) {
        $db->update(
            'update %%PLANETS%% set bankm = bankm + :metal, bankc = bankc + :crystal, bankd = bankd + :deuterium where id_owner = :userId and planet_type = 1; ',
            array(':metal' => $metal, ':crystal' => $crystal, ':deuterium' => $deuterium, ':userId' => $bot['id'])
        );
    }
    echo 'all bots got ' . $metal . 'metal, ' . $crystal . 'crystal and ' . $deuterium . 'deuterium';
}






function research_to_all_bots()
{
    global $resource, $reslist;
    foreach ($reslist['research'] as $id => $research_name) {
    }
}





#make al bots 15 planets
function make_bot_planets()
{
    $db = Database::get();
    echo 'makeing bot planets...';
    $botlist = $db->select('SELECT * FROM %%USERS%% WHERE is_bot = 1');

    $config    = Config::get(Universe::current());
    foreach ($botlist as $key => $bot) {
        $planets = $db->select('select id,is_bot from uni1_planets where id_owner = :userId and planet_type = 1;', array(':userId' => $bot['id']));
        foreach ($planets as $key => $planet) {
            if ($planet['is_bot'] == 0) {
                $db->update('update uni1_planets set is_bot = 1 where id = :id', array(':id' => $planet['id']));
            }
        }
        if (count($planets) >= 15) {
            continue;
        }
        $galaxy    = mt_rand(1, $config->max_galaxy);
        $system = mt_rand(1, $config->max_system);
        $planet = mt_rand(1, $config->max_planets);

        if ($galaxy > $config->max_galaxy) {
            $galaxy    = mt_rand(1, $config->max_galaxy);
        }

        if ($system > $config->max_system) {
            $system    = mt_rand(1, $config->max_system);
        }

        do {
            $position = mt_rand(round($config->max_planets * 0.2), round($config->max_planets * 0.8));
            if ($planet < 3) {
                $planet += 1;
            } else {
                if ($system >= $config->max_system) {
                    $system = mt_rand(1, $config->max_system);
                    if ($galaxy >= $config->max_galaxy) {
                        $galaxy    = mt_rand(1, $config->max_galaxy);
                    } else {
                        $galaxy = mt_rand(1, $config->max_galaxy);
                    }
                } else {
                    $system = mt_rand(1, $config->max_system);
                }
            }
        } while (PlayerUtil::isPositionFree(Universe::current(), $galaxy, $system, $position) === false);

        // Update last coordinates to config table
        $config->LastSettedGalaxyPos = $galaxy;
        $config->LastSettedSystemPos = $system;
        $config->LastSettedPlanetPos = $planet;

        PlayerUtil::createPlanet($galaxy, $system, $position, Universe::current(), $bot['id']);
    }
}


function set_bot_fleet_arrays() #rewrits the ships_arrays in the bots according to the bot_setting and bot type,resets fleet timers
{
    $db = Database::get();

    $ships_array = array();
    $botsetting = $db->select('select * from uni1_bot_setting');
    foreach ($botsetting as $key => $value) {
        $valuee = unserialize($value['ships_array']);
        foreach ($valuee as $key => $value1) {

            $ships_array[$value1['name']] = array(
                'bonus_time' => 0,
                'name' => $value1['name'],
                'amount' => 0
            );
        }
        $db->update('update uni1_bots set ships_array = :ships_array ,ress_bonus_time = 0,next_fleet_action = ' . time() . ', action_index = 1,next_fleet_action = ' . time() . ' where bot_type = :value', array(':ships_array' => serialize($ships_array), ':value' => $value['id']));
    }

    echo 'done setting bots ships arrays';
}




function set_bot_ships_arrays()
{
    #select from bot_setting, make ships_arrays for the bots and apply them, eventually keep old amount
}

function delete_bot_fleets()
{ #sets amount of all botfleets to 0
    $db = Database::get();
    $bots = $db->select('SELECT * FROM uni1_bots');
    foreach ($bots as $bot) {
        $ships_array = unserialize($bot['ships_array']);
        foreach ($ships_array as $key => $value) {
            $ships_array[$key]['amount'] = 0;
        }
        $db->update('update uni1_bots set ships_array = :ships_array where id = :id', array(':ships_array' => serialize($ships_array), ':id' => $bot['id']));
    }
}
function reset_bots() #erases all buildings,fleet,def , ress from botplanets, overwrits bots ships_arrays, and resets the contingent counters
{
    $db = Database::get();
    global $resource;
    $planets_delete_sql = '';
    foreach ($resource as $key => $value) {
        if ($key < 600) {
            if ($key < 200 && $key > 100) {
                continue;
            }
            $planets_delete_sql .= '`' . $value . '` = 0 , ';
        }
    }
    $db->update('UPDATE uni1_planets SET ' . $planets_delete_sql . 'metal = 0,crystal = 0,deuterium = 0 where is_bot = 1');
    set_bot_fleet_arrays(); #rewrits the fleetarray of each bot
    reset_contingents();
    #$db->update('UPDATE uni1_bot_setting SET last_set = 0 ');

    echo 'reseted bots';
}



/*--------------------------------------------------------reperatur tools----------------------------------------*/
function werkseinstellungen()
{
    $ships_array =  array(
        'cx22' => array(
            'per_second' => 0,
            'contingent' => 0,
            'name' => 'cx22',
            'contingent_used' => 0,
            'shipvalue' => '8000',
            'factor' => .33,
            'leave_on_planet' => 0
        ),
        'cx215' => array(
            'per_second' => 0,
            'contingent' => 0,
            'name' => 'cx215',
            'contingent_used' => 0,
            'shipvalue' => '80000',
            'factor' => .33,
            'leave_on_planet' => 0
        ),
        'cx2150' => array(
            'per_second' => 0,
            'contingent' => 0,
            'name' => 'cx2150',
            'contingent_used' => 0,
            'shipvalue' => '800000',
            'factor' => .33,
            'leave_on_planet' => 0
        )
    );
    $db = Database::get();
    $db->update('update uni1_bot_setting set ships_array = :ships_array', array(':ships_array' => serialize($ships_array)));
    set_bot_fleet_arrays();
    echo 'resetted bots to default settings';
}


function repair_bot_fleet_arrays() ## shall maintain fleet amounts
{
    $db = Database::get();

    $ships_array = array();
    $botsetting = $db->select('select * from uni1_bot_setting');
    foreach ($botsetting as $key => $value) {
        $valuee = unserialize($value['ships_array']);
        foreach ($valuee as $key => $value1) {

            $ships_array[$value1['name']] = array(
                'bonus_time' => 0,
                'name' => $value1['name'],
                'amount' => 0
            );
        }
    }
    $db->update('update uni1_bots set ships_array = :ships_array where bot_type = 0', array(':ships_array' => serialize($ships_array)));
    echo 'done setting bots ships arrays';
}

function create_bots()
{
    $db = Database::get();
       #make is_bot columns if not exist
       $db->query('ALTER TABLE `uni1_users` ADD COLUMN IF NOT EXISTS `is_bot` INT DEFAULT 0;');
       $db->query('ALTER TABLE `uni1_planets` ADD COLUMN IF NOT EXISTS `is_bot` INT DEFAULT 0;');
    
    echo 'created bots';
}