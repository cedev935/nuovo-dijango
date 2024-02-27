<?php

return array(
  'backend' => array(
    'access' => array(
      'roles' => array(
        'cant_delete_admin' => 'Non puoi eliminare il ruolo Amministratore.',
        'needs_permission' => 'Devi selezionare almeno un permesso per questo ruolo.',
        'create_error' => 'Si è verificato un problema durante la creazione di questo ruolo. Riprova.',
        'update_error' => 'Si è verificato un problema durante l\'aggiornamento di questo ruolo. Riprova.',
        'already_exists' => 'Questo ruolo esiste già. Scegli un nome diverso.',
        'delete_error' => 'Si è verificato un problema durante l\'eliminazione di questo ruolo. Riprova.',
        'has_users' => 'Non puoi eliminare un ruolo con utenti associati.',
        'not_found' => 'Questo ruolo non esiste.',
      ),
      'users' => array(
        'already_confirmed' => 'Questo utente è già confermato.',
        'cant_delete_own_session' => 'Non puoi eliminare la tua sessione.',
        'session_wrong_driver' => 'Il driver della sessione deve essere impostato su database per utilizzare questa funzionalità.',
        'social_delete_error' => 'Si è verificato un problema durante la rimozione dell\'account social dall\'utente.',
        'role_needed_create' => 'Devi scegliere almeno un ruolo.',
        'create_error' => 'Si è verificato un problema durante la creazione di questo utente. Riprova.',
        'update_error' => 'Si è verificato un problema durante l\'aggiornamento di questo utente. Riprova.',
        'update_password_error' => 'Si è verificato un problema durante la modifica della password di questo utente. Riprova.',
        'cant_deactivate_self' => 'Non puoi farlo a te stesso.',
        'mark_error' => 'Si è verificato un problema durante l\'aggiornamento di questo utente. Riprova.',
        'cant_confirm' => 'Si è verificato un problema durante la conferma dell\'account utente.',
        'not_confirmed' => 'Questo utente non è confermato.',
        'cant_unconfirm_admin' => 'Non puoi annullare la conferma del super amministratore.',
        'cant_unconfirm_self' => 'Non puoi annullare la tua conferma.',
        'delete_first' => 'Questo utente deve essere eliminato prima di poter essere distrutto definitivamente.',
        'delete_error' => 'Si è verificato un problema durante l\'eliminazione di questo utente. Riprova.',
        'cant_restore' => 'Questo utente non è stato eliminato, quindi non può essere ripristinato.',
        'restore_error' => 'Si è verificato un problema durante il ripristino di questo utente. Riprova.',
        'email_error' => 'Quell\'indirizzo email appartiene a un utente diverso.',
        'not_found' => 'Questo utente non esiste.',
        'cant_delete_admin' => 'Non puoi eliminare il super amministratore.',
        'cant_delete_self' => 'Non puoi eliminare te stesso.',
        'role_needed' => 'Devi scegliere almeno un ruolo.',
      ),
    ),
  ),
  'frontend' => array(
    'auth' => array(
      'confirmation' => array(
        'success' => 'Il tuo account è stato confermato con successo!',
        'already_confirmed' => 'Il tuo account è già confermato.',
        'resent' => 'È stata inviata una nuova e-mail di conferma all\'indirizzo registrato.',
        'pending' => 'Il tuo account è in attesa di approvazione.',
        'resend' => 'Il tuo account non è ancora confermato. Fai clic sul link di conferma nell\'e-mail, o <a href=":url">clicca qui</a> per inviare nuovamente l\'e-mail di conferma.',
        'confirm' => 'Conferma il tuo account!',
        'mismatch' => 'Il codice di conferma non corrisponde.',
        'created_pending' => 'Il tuo account è stato creato con successo ed è in attesa di approvazione. Riceverai una e-mail quando il tuo account sarà approvato.',
        'created_confirm' => 'Il tuo account è stato creato con successo. Ti abbiamo inviato un\'e-mail per confermare il tuo account.',
        'not_found' => 'Il codice di conferma non esiste.',
      ),
      'deactivated' => 'Il tuo account è stato disattivato.',
      'password' => array(
        'reset_problem' => 'Si è verificato un problema durante il ripristino della tua password. Riprova ad inviare l\'e-mail di ripristino della password.',
        'change_mismatch' => 'Questa non è la tua vecchia password.',
      ),
      'email_taken' => 'Quell\'indirizzo e-mail è già in uso.',
      'registration_disabled' => 'La registrazione è attualmente chiusa.',
    ),
  ),
);

