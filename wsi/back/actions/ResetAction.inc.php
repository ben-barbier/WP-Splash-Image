<?php

// Vérification du token de sécurité.
check_admin_referer('reset','nonce_reset_field');

// Remise de toutes les options aux valeurs par défaut
MainManager::getInstance()->reset();

?>