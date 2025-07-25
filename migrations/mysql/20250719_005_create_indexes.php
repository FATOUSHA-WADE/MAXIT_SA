<?php
// Migration MySQL - Création des index spéciaux
return [
    
    "CREATE UNIQUE INDEX idx_unique_compte_principal 
     ON compte (client_id, type) "
    
];