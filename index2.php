<?php
// index.php - Pagina di benvenuto con sfondo blu e logo al centro
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home - G.I.FRA. Milazzo</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #003366; /* Blu scuro */
      font-family: Arial, sans-serif;
      color: white;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background-image: url('Logo GiFra nuovo.png'); /* Logo come sfondo */
      background-size: contain;         /* Adatta il logo */
      background-repeat: no-repeat;
      background-position: center;
      background-attachment: fixed;
    }

    .content {
      text-align: center;
      z-index: 1;
      padding: 20px;
      background-color: rgba(0, 0, 0, 0.3);
      border-radius: 10px;
      max-width: 500px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
    }

    h1 {
      color: white;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
    }

    p {
      margin-top: 10px;
      font-size: 1.1em;
    }
  </style>
</head>
<body>
  <div class="content">
    <h1>BENVENUTI SU G.I.FRA. MILAZZO</h1>
    <p>San Papino - Fondato nel 1990</p>
  </div>
</body>
</html>
