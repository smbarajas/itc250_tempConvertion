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
   $initial_temperature = filter_input(INPUT_POST, 'initial_temperature', FILTER_VALIDATE_FLOAT);
   $temperature_unit = $_POST['temperature_unit'];
   $convert_to_temperature_unit = $_POST['convert_to_temperature_unit'];
   $error_message = '';
  
   //validate temperature
   if($initial_temperature === FALSE){
       $error_message .= 'Enter a valid number.<br>';
       $inital_temp_err = TRUE;
   }

   if(!in_array($temperature_unit, array("fahrenheit", "celsius", "kelvin"))){
       $error_message .= 'Select a temperature unit.<br>';
       $temp_unit_err = TRUE;
   }
  
   if(!in_array($convert_to_temperature_unit, array("fahrenheit", "celsius", "kelvin"))){
       $error_message .= 'Select a temperature unit to convert to.<br>';
       $conv_to_temp_err = TRUE;
   }
  
   if ($error_message ===  '') {
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
               $temperature = $temperature_c;
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
      <title>Temperature Conversion</title>
      <link rel="stylesheet" type="text/css" href="main.css">
   </head>
   <body>
       <main>
       <h1>Temperature Conversion</h1>
      
       <!--if there is an error msg style it and print -->
       <?php if (!empty($error_message)) : ?>
           <p class="error"><?php echo $error_message; ?></p>
       <?php endif; ?>   
  
                   
           <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
           <div id="data">
               <label> Initial Temperature: </label>
               <input type="text" name="initial_temperature" value="<?php if (isset($_POST['initial_temperature'])) echo $_POST['initial_temperature']; ?>">
           <?php if (isset($inital_temp_err)) : ?><span class="error" style="font-size:150%">*</span><?php endif; ?> 
           <br />
           <label>
            What is your current temperature unit?
               <select name="temperature_unit" >
                   <option value="">Choose your unit</option>
                   <option value="fahrenheit" <?php echo (isset($_POST['temperature_unit']) && $_POST['temperature_unit'] == 'fahrenheit') ? 'selected="selected"' : ''; ?>>Fahrenheit</option>
                   <option value="celsius" <?php echo (isset($_POST['temperature_unit']) && $_POST['temperature_unit'] == 'celsius') ? 'selected="selected"' : ''; ?>>Celsius</option>
                   <option value="kelvin" <?php echo (isset($_POST['temperature_unit']) && $_POST['temperature_unit'] == 'kelvin') ? 'selected="selected"' : ''; ?>>Kelvin</option>

               </select>
           <?php if (isset($temp_unit_err)) : ?><span class="error" style="font-size:150%">*</span><?php endif; ?>  
     	    </label>  
            <label>
            What temperature unit do you want to convert to?<br />
               <select name="convert_to_temperature_unit">
                   <option value="">Choose your unit</option>
                   <option value="fahrenheit" <?php echo (isset($_POST['convert_to_temperature_unit']) && $_POST['convert_to_temperature_unit'] == 'fahrenheit') ? 'selected="selected"' : ''; ?>>Fahrenheit</option>
                   <option value="celsius" <?php echo (isset($_POST['convert_to_temperature_unit']) && $_POST['convert_to_temperature_unit'] == 'celsius') ? 'selected="selected"' : ''; ?>>Celsius</option>
                   <option value="kelvin" <?php echo (isset($_POST['convert_to_temperature_unit']) && $_POST['convert_to_temperature_unit'] == 'kelvin') ? 'selected="selected"' : ''; ?>>Kelvin</option>

               </select>
           <?php if (isset($conv_to_temp_err)) : ?><span class="error" style="font-size:150%">*</span><?php endif; ?>
     	    </label>  
              
           </div>
              
               <div id="button">
                 <label>&nbsp;</label>
                   <input type="submit" value="Convert"><br />
               </div>
             <div id="results">
          
            <label> Converted Temperature: </label>
               <input type="text" name="temperature" value="<?php if (!empty($temperature)) echo $temperature; ?>"><br/>  
            </div> 
              
           </form>
      </main>
   </body>
</html>
