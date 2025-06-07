![E-commerce Project Slider](public/images/slider/slider1.png)

# E-commerce Project

Questo progetto è stato sviluppato come parte del corso universitario di Progetto di Applicazioni Basate su Strutture Dati. Si tratta di un'applicazione e-commerce basilare ma funzionale, realizzata utilizzando PHP vanilla e MySQL.

## 📋 Descrizione del Progetto

Il progetto implementa un negozio online con le seguenti funzionalità principali:
- Registrazione e login utenti
- Visualizzazione catalogo prodotti
- Carrello della spesa
- Processo di checkout
- Gestione degli ordini

## 🛠️ Tecnologie Utilizzate

- **PHP**: Ho scelto di utilizzare PHP "vanilla" senza framework per comprendere meglio i concetti base della programmazione web
- **MySQL**: Database relazionale per la gestione dei dati
- **HTML/CSS**: Per la struttura e lo stile delle pagine
- **JavaScript**: Per migliorare l'interattività lato client

## 🏗️ Struttura del Progetto

```
ecommerce-project/
├── app/                    # Logica dell'applicazione
│   ├── views/             # Template delle pagine
│   └── ...                # Altri componenti dell'applicazione
├── public/                # File accessibili pubblicamente
└── database_setup.sql     # Script per l'inizializzazione del database
```

## 💭 Scelte Progettuali

Ho strutturato il progetto seguendo un'architettura MVC semplificata per:
1. Separare la logica di business dalla presentazione
2. Rendere il codice più organizzato e mantenibile
3. Applicare i principi base appresi durante il corso

Ho scelto di non utilizzare framework per:
- Comprendere meglio i meccanismi di base di PHP
- Imparare a gestire manualmente aspetti come il routing e la sicurezza
- Avere un maggiore controllo sul codice scritto

## 🚀 Come Iniziare

1. Clona il repository
2. Importa `database_setup.sql` nel tuo database MySQL
3. Configura il file di connessione al database
4. Avvia un server PHP locale

## � Development Server

The project includes a built-in development server setup for easy local development:

### Using the Development Server

1. Copy `.env.example` to `.env` and adjust settings as needed:
   ```ini
   APP_PORT=8080  # Choose your preferred port
   APP_ENV=development
   APP_URL=http://localhost
   ```

2. Start the server using one of these methods:
   - **Using PHP directly**: `php server.php`
   - **Using PowerShell**: `$env:APP_PORT="8080"; php server.php`
   - **Using Command Prompt**: `set APP_PORT=8080 && php server.php`

The server will start and be accessible at `http://localhost:8080` (or your configured port).

### Security Features

- Only files in the `public` directory are directly accessible
- Application code stays private
- Configuration files remain secure

## �🔒 Sicurezza

Ho implementato misure di sicurezza base come:
- Protezione contro SQL injection
- Validazione degli input
- Gestione delle sessioni utente

## 🎨 Design Pattern Utilizzati

- **MVC (Model-View-Controller)**: L'architettura principale del progetto segue il pattern MVC per separare la logica di business (Models), la presentazione (Views) e il controllo del flusso dell'applicazione (Controllers).

- **Front Controller**: Implementato attraverso il sistema di routing che gestisce tutte le richieste HTTP attraverso un singolo punto di ingresso.

- **Repository Pattern**: Utilizzato nei model per l'accesso ai dati, incapsulando la logica di persistenza e fornendo un'interfaccia orientata agli oggetti per interagire con il database.

- **Singleton**: Utilizzato per la connessione al database, assicurando una singola istanza di connessione durante l'esecuzione dell'applicazione.

- **Factory Method**: Implementato nel core Controller per la creazione dinamica di istanze dei model.

## 📝 Note

Questo progetto è stato sviluppato a scopo didattico e potrebbe non includere tutte le funzionalità che ci si aspetterebbe da un e-commerce in produzione.

## 👤 Autore
Antonio Palomba
