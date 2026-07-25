
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Bloc de chargement plein écran</title>
<style>
  /* Overlay plein écran */
  .overlay {
    position: fixed;
    inset: 0; /* équivaut à top/left/right/bottom: 0 */
    background: rgba(0, 0, 0, 0.45); /* semi-transparent; mets 0 si tu veux 100% transparent */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    backdrop-filter: blur(0px); /* optionnel: tu peux mettre 2-4px pour un léger flou */
  }

  /* Spinner circulaire */
  .loader {
    width: 64px;
    height: 64px;
    border: 6px solid #e6e6e6;       /* anneau pâle */
    border-top-color: #3498db;        /* couleur de l’indicateur */
    border-radius: 50%;
    animation: spin 1s linear infinite; /* <- l’animation */
  }

  /* Animation de rotation */
  @keyframes spin {
    to { transform: rotate(360deg); }
  }

  /* Juste pour la démo */
  .content {
    padding: 24px;
    font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
  }

  /* (Optionnel) Masquage par classe utilitaire */
  .hidden { display: none !important; }
</style>
</head>
<body>

<!-- Bloc de chargement -->
<div class="overlay" id="loading" role="status" aria-live="polite" aria-label="Chargement en cours">
  <div class="loader" aria-hidden="true"></div>
</div>

<!-- Contenu de la page -->
<div class="content">
  <h1>Contenu de la page</h1>
  <p>Votre contenu s'affiche ici.</p>

  <button type="button" onclick="showLoader()">Afficher le chargement</button>
  <button type="button" onclick="hideLoader()">Masquer le chargement</button>
</div>

<script>
  function showLoader() {
    document.getElementById('loading').classList.remove('hidden');
  }
  function hideLoader() {
    document.getElementById('loading').classList.add('hidden');
  }

  // Exemple : masquer automatiquement le loader après 1,5s (démo)
  // Supprime ce bloc dans ton vrai projet si tu gères l'état côté app.
  window.addEventListener('load', () => {
    setTimeout(hideLoader, 1500);
  });
</script>

</body>
</html>
