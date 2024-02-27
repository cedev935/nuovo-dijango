<?php

return array (
  'required' => 'Il campo :attribute è obbligatorio.',
  'attributes' => 
  array (
    'frontend' => 
    array (
      'old_password' => 'Vecchia Password',
      'male' => 'Maschio',
      'female' => 'Femmina',
      'other' => 'Altro',
      'password' => 'Password',
      'password_confirmation' => 'Conferma Password',
      'avatar' => 'Posizione Avatar',
      'first_name' => 'Nome',
      'last_name' => 'Cognome',
      'email' => 'Indirizzo E-mail',
      'name' => 'Nome Completo',
      'phone' => 'Telefono',
      'message' => 'Messaggio',
      'new_password' => 'Nuova Password',
      'new_password_confirmation' => 'Conferma Nuova Password',
      'timezone' => 'Fuso Orario',
      'language' => 'Lingua',
      'gravatar' => 'Gravatar',
      'upload' => 'Carica',
      'captcha' => 'Captcha richiesto',
      'personal_information' => 'Informazioni Personali',
      'social_information' => 'Informazioni Social',
      'payment_information' => 'Informazioni di Pagamento',
    ),
    'backend' => 
    array (
      'access' => 
      array (
        'roles' => 
        array (
          'name' => 'Nome',
          'associated_permissions' => 'Permessi Associati',
          'sort' => 'Ordina',
        ),
        'users' => 
        array (
          'password' => 'Password',
          'password_confirmation' => 'Conferma Password',
          'first_name' => 'Nome',
          'last_name' => 'Cognome',
          'email' => 'Indirizzo E-mail',
          'active' => 'Attivo',
          'confirmed' => 'Confermato',
          'send_confirmation_email' => 'Invia E-mail di Conferma',
          'associated_roles' => 'Ruoli Associati',
          'name' => 'Nome',
          'other_permissions' => 'Altri Permessi',
          'timezone' => 'Fuso Orario',
          'language' => 'Lingua',
        ),
        'permissions' => 
        array (
          'associated_roles' => 'Ruoli Associati',
          'dependencies' => 'Dipendenze',
          'display_name' => 'Nome Visualizzato',
          'group' => 'Gruppo',
          'group_sort' => 'Ordine del Gruppo',
          'groups' => 
          array (
            'name' => 'Nome del Gruppo',
          ),
          'name' => 'Nome',
          'first_name' => 'Nome',
          'last_name' => 'Cognome',
          'system' => 'Sistema',
        ),
      ),
      'settings' => 
      array (
        'social_settings' => 
        array (
          'facebook' => 
          array (
            'label' => 'Stato di accesso a Facebook',
            'client_id' => 'ID client',
            'client_secret' => 'Segreto client',
            'redirect' => 'URL di reindirizzamento',
          ),
          'google' => 
          array (
            'label' => 'Stato di accesso a Google',
            'client_id' => 'ID client',
            'client_secret' => 'Segreto client',
            'redirect' => 'URL di reindirizzamento',
          ),
          'twitter' => 
          array (
            'label' => 'Stato di accesso a Twitter',
            'client_id' => 'ID client',
            'client_secret' => 'Segreto client',
            'redirect' => 'URL di reindirizzamento',
          ),
          'linkedin' => 
          array (
            'label' => 'Stato di accesso a LinkedIn',
            'client_id' => 'ID client',
            'client_secret' => 'Segreto client',
            'redirect' => 'URL di reindirizzamento',
          ),
          'github' => 
          array (
            'label' => 'Stato di accesso a Github',
            'client_id' => 'ID del cliente',
            'client_secret' => 'Segreto del cliente',
            'redirect' => 'URL di reindirizzamento',
          ),
          'bitbucket' => 
          array (
            'label' => 'Stato di accesso a Bitbucket',
            'client_id' => 'ID del cliente',
            'client_secret' => 'Segreto del cliente',
            'redirect' => 'URL di reindirizzamento',
          ),
        ),
        'general_settings' => 
        array (
          'app_name' => 'Nome App',
          'app_url' => 'URL App',
          'app_locale' => 'Lingua App',
          'app_timezone' => 'Fuso Orario App',
          'mail_driver' => 'Driver Mail',
          'mail_host' => 'Host Mail',
          'mail_port' => 'Porta Mail',
          'mail_from_name' => 'Nome Mittente Mail',
          'lesson_timer' => 'Timer Lezione',
          'mail_from_address' => 'Indirizzo Mittente Mail',
          'mail_username' => 'Nome Utente Mail',
          'mail_password' => 'Password Mail',
          'enable_registration' => 'Abilita Registrazione',
          'change_email' => 'Cambia Email',
          'password_history' => 'Cronologia Password',
          'password_expires_days' => 'Scadenza Password (giorni)',
          'requires_approval' => 'Richiede Approvazione',
          'confirm_email' => 'Conferma Email',
          'homepage' => 'Seleziona Home Page',
          'captcha_status' => 'Stato Captcha',
          'captcha_site_key' => 'Captcha Key',
          'captcha_site_secret' => 'Captcha Secret',
          'google_analytics' => 'Codice Google Analytics',
          'theme_layout' => 'Layout Tema',
          'font_color' => 'Colore Font',
          'layout_type' => 'Tipo Layout',
          'retest_status' => 'Status Re-Test',
          'show_offers' => 'Mostra Pagina Offerte',
          'one_signal_push_notification' => 'Configurazione OneSignal',
          'onesignal_code' => 'Incolla qui il codice script OneSignal',
        ),
      ),
    ),
  ),
  'accepted' => 'Devi accettare :attribute.',
  'active_url' => ':attribute non è un URL valido.',
  'after' => ':attribute deve essere una data successiva a :date.',
  'after_or_equal' => ':attribute deve essere una data successiva o uguale a :date.',
  'alpha' => ':attribute può contenere solo lettere.',
  'alpha_dash' => ':attribute può contenere solo lettere, numeri, trattini e underscore.',
  'alpha_num' => ':attribute può contenere solo lettere e numeri.',
  'array' => ':attribute deve essere un array.',
  'before' => ':attribute deve essere una data precedente a :date.',
  'before_or_equal' => ':attribute deve essere una data precedente o uguale a :date.',
  'between' => 
  array (
    'numeric' => 'Il campo :attribute deve essere compreso tra :min e :max.',
    'file' => 'Il campo :attribute deve essere compreso tra :min e :max kilobyte.',
    'string' => 'Il campo :attribute deve essere compreso tra :min e :max caratteri.',
    'array' => 'Il campo :attribute deve avere tra :min e :max elementi.',
  ),
  'boolean' => 'Il campo :attribute deve essere vero o falso.',
  'confirmed' => 'La conferma di :attribute non corrisponde.',
  'date' => 'La data :attribute non è valida.',
  'date_format' => 'Il formato di :attribute non corrisponde a :format.',
  'different' => ':attribute e :other devono essere diversi.',
  'digits' => ':attribute deve avere :digits cifre.',
  'digits_between' => ':attribute deve avere tra :min e :max cifre.',
  'dimensions' => 'Le dimensioni di :attribute non sono valide.',
  'distinct' => 'Il campo :attribute ha un valore duplicato.',
  'email' => ':attribute deve essere un indirizzo email valido.',
  'exists' => 'Il valore selezionato per :attribute non è valido.',
  'file' => ':attribute deve essere un file.',
  'filled' => 'Il campo :attribute deve avere un valore.',
  'gt' => 
  array (
    'numeric' => 'Il campo :attribute deve essere maggiore di :value.',
    'file' => 'Il campo :attribute deve essere maggiore di :value kilobyte.',
    'string' => 'Il campo :attribute deve essere maggiore di :value caratteri.',
    'array' => 'Il campo :attribute deve avere più di :value elementi.',
  ),
  'gte' => 
  array (
    'numeric' => 'Il campo :attribute deve essere maggiore o uguale a :value.',
    'file' => 'Il campo :attribute deve essere maggiore o uguale a :value kilobyte.',
    'string' => 'Il campo :attribute deve essere maggiore o uguale a :value caratteri.',
    'array' => 'Il campo :attribute deve avere :value elementi o più.',
  ),
  'image' => 'Il campo :attribute deve essere un\'immagine.',
  'in' => 'Il campo selezionato :attribute non è valido.',
  'in_array' => 'Il campo :attribute non esiste in :other.',
  'integer' => 'Il campo :attribute deve essere un numero intero.',
  'ip' => 'Il campo :attribute deve essere un indirizzo IP valido.',
  'ipv4' => 'Il campo :attribute deve essere un indirizzo IPv4 valido.',
  'ipv6' => 'Il campo :attribute deve essere un indirizzo IPv6 valido.',
  'json' => 'Il campo :attribute deve essere una stringa JSON valida.',
  'lt' => 
  array (
    'numeric' => 'Il campo :attribute deve essere inferiore a :value.',
    'file' => 'Il campo :attribute deve essere inferiore a :value kilobyte.',
    'string' => 'Il campo :attribute deve essere inferiore a :value caratteri.',
    'array' => 'Il campo :attribute deve avere meno di :value elementi.',
  ),
  'lte' => 
  array (
    'numeric' => 'Il campo :attribute deve essere minore o uguale a :value.',
    'file' => 'Il campo :attribute deve essere minore o uguale a :value kilobyte.',
    'string' => 'Il campo :attribute deve essere minore o uguale a :value caratteri.',
    'array' => 'Il campo :attribute non deve avere più di :value elementi.',
  ),
  'max' => 
  array (
    'numeric' => 'Il campo :attribute non può essere maggiore di :max.',
    'file' => 'Il campo :attribute non può essere maggiore di :max kilobyte.',
    'string' => 'Il campo :attribute non può essere maggiore di :max caratteri.',
    'array' => 'Il campo :attribute non può avere più di :max elementi.',
  ),
  'mimes' => 'Il campo :attribute deve essere un file di tipo: :values.',
  'mimetypes' => 'Il campo :attribute deve essere un file di tipo: :values.',
  'min' => 
  array (
    'numeric' => 'Il campo :attribute deve essere almeno :min.',
    'file' => 'Il campo :attribute deve essere almeno :min kilobyte.',
    'string' => 'Il campo :attribute deve essere almeno :min caratteri.',
    'array' => 'Il campo :attribute deve avere almeno :min elementi.',
  ),
  'not_in' => 'Il campo selezionato :attribute non è valido.',
  'not_regex' => 'Il formato del campo :attribute non è valido.',
  'numeric' => 'Il campo :attribute deve essere un numero.',
  'present' => 'Il campo :attribute deve essere presente.',
  // 'regex' => 'Il formato del campo :attribute non è valido.',
  'regex' => 'Il campo :attribute deve essere lungo almeno 6 caratteri e contenere almeno una lettera, una cifra e uno dei seguenti caratteri speciali: !, $, # o %.',
  'required_if' => 'Il campo :attribute è obbligatorio quando :other è :value.',
  'required_unless' => 'Il campo :attribute è obbligatorio a meno che :other sia in :values.',
  'required_with' => 'Il campo :attribute è obbligatorio quando :values è presente.',
  'required_with_all' => 'Il campo :attribute è obbligatorio quando :values sono presenti.',
  'required_without' => 'Il campo :attribute è obbligatorio quando :values non è presente.',
  'required_without_all' => 'Il campo :attribute è obbligatorio quando nessuno dei seguenti valori :values è presente.',
  'same' => 'Il campo :attribute e :other devono corrispondere.',
  'size' => 
  array (
    'numeric' => 'Il campo :attribute deve essere :size.',
    'file' => 'Il campo :attribute deve essere :size kilobyte.',
    'string' => 'Il campo :attribute deve essere di :size caratteri.',
    'array' => 'Il campo :attribute deve contenere :size elementi.',
  ),
  'string' => 'Il campo :attribute deve essere una stringa.',
  'timezone' => 'Il campo :attribute deve essere una zona valida.',
  'unique' => 'Il campo :attribute è già stato preso.',
  'uploaded' => 'Il campo :attribute non è stato caricato correttamente.',
  'url' => 'Il formato del campo :attribute non è valido.',
  'uuid' => 'Il campo :attribute deve essere un UUID valido.',
  'custom' => 
  array (
    'attribute-name' => 
    array (
      'rule-name' => 'custom-message',
    ),
  ),
);
