<?php
    // Crea un div para cada alerta
    foreach ($alertas as $key => $mensajes) :
        foreach ($mensajes as $mensaje) :
?>  
    <div class="alerta error <?php echo $key ?>">
        <?php echo $mensaje;?>        
     </div>
<?php

            endforeach;
    endforeach;
?>

