<?php
//functions to convert temperature
function F_to_C($temperature_f){
$temperature_c = ($temperature_f - 32) * (5/9);
return $temperature_c;
}

function K_to_C($temperature_k){
$temperature_c = $temperature_k - 273.15;
return $temperature_c;
}

function C_to_F($temperature_c){
$temperature_f = $temperature_c * (9/5) + 32;
return $temperature_f;
}

function C_to_K($temperature_c){
$temperature_k = $temperature_c + 273.15;
return $temperature_k;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
//get temperature values and units for converting
$initial_temperature = filter_input(INPUT_POST, 'temperature', FILTER_VALIDATE_FLOAT);
$temperature_unit = $_POST['temperature_unit'];
$convert_to_temperature_unit = $_POST['convert_to_temperature_unit'];

//validate temperature
if($initial_temperature === FALSE){
$error_message = 'Enter a valid number.';
}else {
$error_message = '';
}
if ($error_message === '') {
//convert inital temp to C
switch($temperature_unit) {
case "fahrenheit":
$temperature_c = F_to_C($initial_temperature);
break;
case "celsius":
$temperature_c = $initial_temperature;
break;
case "kelvin":
$temperature_c = K_to_C($initial_temperature);
break;
}
//convert $temperature in C to the final unit
switch($convert_to_temperature_unit){
case "fahrenheit":
$temperature = C_to_F($temperature_c);
break;
case "celsius":
break;
case "kelvin":
$temperature = C_to_K($temperature_c);
break;
}
//round temperature to 2 decimal places
$temperature = round($temperature, 2);
}

}
?>

<!DOCTYPE html>
<html>
    <head>
       <title>Temperature Convertion</title>
       <link rel="stylesheet" type="text/css" href="main.css">
    </head>
    <body>
        <main>
        <h1>Temperature Convertion</h1>
        
        <?php 
        //if there is an error msg style it and
        //print
        if(!empty($error_message)){?>
        <p class="error"><?php echo 
            htmlspecialchars($error_message); ?></p>
        
    <?php } ?> 
            <?php if (!empty($temperature)) : ?>
        <?php echo $initial_temperature . " " .  $temperature_unit . " = " . $temperature . " " . $convert_to_temperature_unit;  ?>
    <?php endif; ?>
                     
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <div id="data">
                <label> Initial Temperature: </label>
                <input type="text" name="initial_temperature"><br />
             <label>
			What is your current temperature unit?
                <select name="temperature_unit" >
                    <option value="">Choose your unit</option>
                    <option value="fahrenheit">Fahrenheit</option>
                    <option value="celcius">Celcius</option>
                    <option value="kelvin">Kelvin</option>

                </select>
		     </label>   
             <label>
			What temperature unit do you want to convert to?<br />
                <select name="convert_to_temperature_unit">
                    <option value="">Choose your unit</option>
                    <option value="fahrenheit">Fahrenheit</option>
                    <option value="celcius">Celcius</option>
                    <option value="kelvin">Kelvin</option>

                </select>
		     </label>   
                
            </div>
                
                <div id="button">
                  <label>&nbsp;</label> 
                    <input type="submit" value="Convert"><br />
                </div>
              <div id="results">
            
             <label> Converted Temperature: </label>
                <input type="text" name="temperature"><br/>   
             </div>  
                
            </form>
       </main>
    </body>
</html>
